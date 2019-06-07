<?php
class StandardTask {
	private $DB;
	function StandardTask() {
		$this->DB =
		require ('php/Connect.php');
		$this -> selectTask();
	}

	function selectTask() {
		//select randomly a task of all tasks in the database not finished yet and not started(InProgress)
		$sql = "Select t.TaskId, t.sequenceStart  FROM Task t where t.finished=0 AND NOT EXISTS (SELECT TaskId FROM TaskInProgress tp WHERE tp.TaskId=t.TaskId) ORDER BY RAND() LIMIT 1";
		$stmt = $this->DB -> prepare($sql);
		if ($stmt -> execute()) {
			if ($stmt -> rowCount() == 0) {
				//if there are no more tasks show a message to the user he sould come back later
				header('Location: ' . 'Info.php?title=No more tasks &text=Please try again later&display=warning');
			} else {
				$stmt = $stmt -> fetch();
				$_SESSION['TaskId'] = $stmt['TaskId'];
				$this -> setInUse($stmt);
			}
		} else {
			header('Location: ' . 'Info.php?title=couldn\'t create a new task&text=please go back to <a href="http://www.microworkers.com">Mikroworkers</a> and try again&display=danger');
		}
	}

	function setInUse($result) {
		//set the assigned task as in progress in the database
		$sql = "Insert into TaskInProgress values(" . $result['TaskId'] . ",'" . date("Y-m-d H:i:s") . "')";
		$stmt = $this->DB -> prepare($sql);
		if ($stmt -> execute()) {
			include 'php/Video.php';
			new Video($result);
		} else {
			header('Location: ' . 'Info.php?title=couldn\'t get video informations&text=please go back to Mikroworkers and try again. &display=danger');
		}

	}

}
?>