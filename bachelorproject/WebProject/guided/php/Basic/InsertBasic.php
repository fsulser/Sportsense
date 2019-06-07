<?php
class InsertValues {
	private static $DB, $rating, $data, $missed;

	function InsertValues($data, $rating, $missed) {
		self::$DB =
		require ('../Connect.php');
		self::$data = $data;
		self::$rating = $rating;
		self::$missed = $missed;
		$this -> createTask();
	}

	function createTask() {
		// create a new task and insert the user informations
		$token = $_SESSION['token'];
		$campaign = $_SESSION['campaign'];
		$sql = "INSERT INTO Task values (0, (Select UID FROM Users WHERE UID =" . $_SESSION['UID'] . "), 1, (SELECT c.start FROM VideoInformations v, campaign c WHERE v.VideoId = c.VideoId and c.CampaignId=1), '" . $token . "', '" . $campaign . "', 0, 1, 0," . self::$missed . ")";
		$stmt = self::$DB -> prepare($sql);
		if (!$stmt -> execute()) {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		} else {
			$this -> checkCount();
		}
	}

	function checkCount() {
		//checking if user enter data or not
		if (count(self::$data) == 0) {
			$this -> updateRating();
		} else {
			$this -> insertEvents();
		}
	}

	function insertEvents() {
		//insert all entered events of the user in the database
		$sql = 'INSERT INTO Event values';
		foreach (self::$data as $i => $row) {
			//generate minute, seconds and milliseconds
			$time = explode('.', $row['Time']);
			if (strpos($row['Time'], '.') !== false) {
				$msec = $time[1] . ' ';
			} else {
				$msec = '00';
			}
			$min = date('i', $time[0]);
			$sec = date('s', $time[0]);

			//split the position data to positionx and positiony
			$positions = explode(' ', $row['Position']);
			$posX = $positions[0];
			$posY = $positions[1];

			//check if a rating value is calculated to the related event. If not rating for this event is set to -0.5
			if (array_key_exists($i, self::$rating)) {
				$rating = self::$rating[$i];
			} else {
				$rating = -0.5;
			}

			//structure of Event: EventId, TaskId, trackedPointX, trackedPointY, min, sec, msec, type_id, team_id, player_id, period_id, rating
			if (count(self::$data) != $i + 1) {
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="' . $_SESSION['token'] . '" Limit 1), ' . $posX . ',' . $posY . ', ' . $min . ', ' . $sec . ', ' . $msec . ', ' . $row['EventId'] . ', (SELECT TeamId FROM Teams WHERE TeamName="' . $row['Team'] . '"), null, null, ' . $rating . '), ';
			} else {
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="' . $_SESSION['token'] . '" Limit 1), ' . $posX . ',' . $posY . ', ' . $min . ', ' . $sec . ', ' . $msec . ', ' . $row['EventId'] . ', (SELECT TeamId FROM Teams WHERE TeamName="' . $row['Team'] . '"), null, null, ' . $rating . ')';
			}
			$sql = $sql . $appendingString;
		}
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> updateRating();
		} else {
			print_r($stmt -> errorInfo());
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

	function updateRating() {
		//update the rating of the task finished
		$rating = $this -> getTaskRating();
		$sql = 'UPDATE Task SET rating=' . $rating . ', isRated=1 WHERE token="' . $_SESSION['token'] . '"';
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> updateCampaign();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

	function getTaskRating() {
		//calculate the task rating with all rating of events + the number of missed events *-0.5
		$rating = -self::$missed * 0.5;
		foreach (self::$data as $i => $row) {
			//if a event does belong to a ground truth event take the calculated value. Otherwise set its rating to -0.5
			if (array_key_exists($i, self::$rating)) {
				$rating = $rating + self::$rating[$i];
			} else {
				$rating = $rating - 0.5;
			}
		}
		return $rating;
	}

	function updateCampaign() {
		//update the number of finished tasks in the pretest campaign
		$rating = $this -> getTaskRating();
		$sql = "Update campaign set number=number+1 where CampaignId=1";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> updateUser();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}

	}

	function updateUser() {
		// update the users rating by the new task rating + the rating of the user as far
		$rating = $this -> getTaskRating();
		$sql = "Update Users set finishedBasic=1, userRating=userRating+" . $rating . " where UID='" . $_SESSION['UID'] . "'";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$arr = array('success' => 1, 'error_msg' => '', 'rating' => $rating);
			echo json_encode($arr);
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

}
?>