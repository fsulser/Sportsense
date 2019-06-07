<?php
session_start();
if (!isset($_SESSION['AdminId'])) {
	$arr = array('success' => 2, 'error_msg' => 'Couldn\'t execute query.');
	echo json_encode($arr);
} else {
	new Task();
}

Class Task {
	private static $DB;

	function Task() {
		self::$DB =
		require_once ('config.php');
		$this -> selectTask();
	}

	function selectTask() {
		$sql = "SELECT t.TaskId, t.UID, t.sequenceStart, t.token, t.rating as TaskRating, t.isRated, t.missed, e.EventId, e.trackedPointX, e.trackedPointY, e.min, e.sec, e.msec, e.type_id, e.team_id, e.rating as EventRating, (Select ev.EventName FROM EventNames ev WHERE ev.EventNamesId = e.type_id)as Event, (Select t.TeamName FROM Teams t Where e.team_id=t.TeamId)as team FROM Task t Left JOIN Event e ON e.TaskId=t.taskId WHERE finished=1 AND CampaignId=".$_POST['id']." ORDER BY sequenceStart, TaskId";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$array = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($array);
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t execute query.');
			echo json_encode($arr);
		}
	}

}
?>