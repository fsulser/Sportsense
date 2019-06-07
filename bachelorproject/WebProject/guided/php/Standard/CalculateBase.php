<?php

//check if CampaignId value is set
if (count($argv) == 0) {
	echo "string";
	include_once "Email.php";
	new Email('failed', 'to get id', $id);
} else {
	$id = $argv[1];
	new Base($id);
}

class Base {
	private $DB, $events;
	function Base($id) {
		$this -> DB =
		require '../Connect.php';
		$this -> getEvents($id);
	}

	function getEvents($id) {
		//select all events belongig to this campaign
		$sql = "SELECT DISTINCT e.trackedPointX, e.trackedPointY, (e.min*60+e.sec+e.msec/10)AS time, e.type_id, e.team_id, u.userRating FROM Event e, Task t LEFT JOIN Users u ON u.UID=t.UID WHERE e.TaskId = t.Taskid AND u.UserRating>-1 AND t.isRated=0 AND t.CampaignId=" . $id . " Order By u.userRating, time";
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$events = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			if (empty($events)) {
				//if there are no events rate all tasks in this campaign
				include_once 'Rating.php';
				new CalculateRating($id);
			} else {
				//otherwise calculte the events
				$events = json_encode($events);
				$points = $this -> calculatePoints($events);
				if ($this -> insertPoints($points, $id)) {
					include_once 'Rating.php';
					new CalculateRating($id);
				} else {
					include_once "Email.php";
					new Email('failed', 'to enter calculated points', $id);
				}
			}
		} else {
			include_once "Email.php";
			new Email('failed', 'to select all events from database', $id);
		}
	}

	function calculatePoints($events) {
		//calculate the points with unix command using octave
		$values = shell_exec("cd ../../matlab; octave --silent --eval \"MainDBSCAN(parseJSON('" . $events . "'))\" ");

		$values = substr($values, strrpos($values, "["), strlen($values));
		$values = substr($values, 0, strrpos($values, "]") + 1);

		return json_decode($values);
	}

	function insertPoints($points, $id) {
		//insert all calculated events
		if (is_array($points)) {
			$sql = "INSERT INTO CalculatedEvent values";
			foreach ($points as $i => $item) {

				//split the time to enter in the database
				$time = explode('.', $item -> time);
				if (strpos($item -> time, '.') !== false) {
					$msec = $time[1] . ' ';
				} else {
					$msec = '00';
				}
				$min = date('i', $time[0]);
				$sec = date('s', $time[0]);

				if (count($points) != $i + 1) {
					$subsql = "(0, " . $id . ", " . $item -> trackedPointX . ", " . $item -> trackedPointY . ", " . $min . ", " . $sec . ", " . $msec . ", " . $item -> type_id . ", " . $item -> team_id . ", null, null),";
				} else {
					$subsql = "(0, " . $id . ", " . $item -> trackedPointX . ", " . $item -> trackedPointY . ", " . $min . ", " . $sec . ", " . $msec . ", " . $item -> type_id . ", " . $item -> team_id . ", null, null)";
				}
				$sql = $sql . $subsql;
			}

			$stmt = $this -> DB -> prepare($sql);
			if ($stmt -> execute()) {
				return true;
			} else {
				print_r($stmt -> errorInfo());
				return false;
			}
		} else {
			return true;
		}
	}

}
?>
