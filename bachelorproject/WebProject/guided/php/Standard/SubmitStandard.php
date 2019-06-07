<?php
session_start();
if (isset($_SESSION['token']) && isset($_SESSION['TaskId'])) {
	new SubmitStandard();
} else {
	header('Location: ' . 'Info.php?title=couldn\'t send values&text=please go back to Mikroworkers and try again&display=danger');
}

class SubmitStandard {
	private static $DB, $data;

	function SubmitStandard() {
		self::$DB =
		require ('../Connect.php');
		self::$data = json_decode($_POST['data'], true);
		$this -> checkCount();
	}

	function checkCount() {
		//check if the user enterd some data
		if (count(self::$data) == 0) {
			$this -> updateTask();
		} else {
			$this -> insertEvents();
		}
	}

	function insertEvents() {
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
			
			//split the positional data in x and y position
			$positions = explode(' ', $row['Position']);
			$posX = $positions[0];
			$posY = $positions[1];

			//structure of Event: EventId, TaskId, trackedPointX, trackedPointY, min, sec, msec, type_id, team_id, player_id, period_id, rating
			if (count(self::$data) != $i + 1) {
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE TaskId="' . $_SESSION['TaskId'] . '" Limit 1), ' . $posX . ',' . $posY . ', ' . $min . ', ' . $sec . ', ' . $msec . ', ' . $row['EventId'] . ', (SELECT TeamId FROM Teams WHERE TeamName="' . $row['Team'] . '"), null, null, null), ';
			} else {
				$appendingString = '(0, ' . $_SESSION['TaskId'] . ', ' . $posX . ',' . $posY . ', ' . $min . ', ' . $sec . ', ' . $msec . ', ' . $row['EventId'] . ', (SELECT TeamId FROM Teams WHERE TeamName="' . $row['Team'] . '"), null, null, null)';
			}
			$sql = $sql . $appendingString;
		}
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> updateTask();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

	function updateTask() {
		//update the task information after finishing the task
		$sql = 'UPDATE Task set finished = 1, token="' . $_SESSION['token'] . '", campaign="' . $_SESSION['campaign'] . '", UID="' . $_SESSION['UID'] . '" WHERE TaskId="' . $_SESSION['TaskId'] . '"';
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> removeTaskInProgress();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

	function removeTaskInProgress() {
		//remove the finished task from the task in progress table
		$sql = 'DELETE FROM TaskInProgress WHERE TaskId="' . $_SESSION['TaskId'] . '"';
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this->checkForCampaignFinished();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}
	
	function checkForCampaignFinished(){
		//check if all tasks in the campaign are finished.
		$sql = "SELECT t.CampaignId, (Select Count(*) from Task t1 where finished=0 AND t1.CampaignId=t.CampaignId)AS notFinished FROM Task t WHERE t.TaskId=".$_SESSION['TaskId'];
		$stmt = self::$DB->prepare($sql);
		if($stmt->execute()){
			$stmt = $stmt->fetch();
			if(intval($stmt['notFinished']) == 0){
				//if all tasks are finished return accepted to the user and start the php file calculating the events.
				$arr = array('success' => 1, 'error_msg' => '');
				echo json_encode($arr);
				$command = 'nohup php CalculateBase.php '.$stmt['CampaignId'];
				exec( $command ." > /dev/null &");
			}else{
				$arr = array('success' => 1, 'error_msg' => '');
				echo json_encode($arr);
			}
		}else{
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

}
?>