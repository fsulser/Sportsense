<?php
session_start();
if (!isset($_SESSION['AdminId'])) {
	$arr = array('success' => 2, 'error_msg' => 'Couldn\'t execute query.');
	echo json_encode($arr);
} else {
	new CreateTasks();
}

Class CreateTasks {
	private static $DB;

	function CreateTasks() {
		self::$DB =
		require_once ('config.php');
		$this -> createCampaign();
	}

	function createCampaign() {
		if ($this -> checkTime()) {
			$sql = "INSERT INTO campaign VALUES(0," . $_POST['video'] . ", " . $_POST['start'] . ", 5, " . $_POST['number'] . ", 0)";
			$stmt = self::$DB -> prepare($sql);
			if ($stmt -> execute()) {
				$this -> insertTasks(self::$DB -> lastInsertId());
			} else {
				$arr = array('success' => 0, 'error_msg' => 'Couldn\'t create Campaign');
				echo json_encode($arr);
			}
		}
	}

	function checkTime() {
		$sql = "SELECT sequenceEnd FROM VideoInformations WHERE VideoId=" . $_POST['video'] . " LIMIT 1";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$stmt = $stmt -> fetch();
			if (intval($stmt['sequenceEnd']) >= intval($_POST['start']) + intval($_POST['number'])) {
				return true;
			} else {
				$arr = array('success' => 0, 'error_msg' => 'Time is outside Video Length');
				echo json_encode($arr);
				return false;
			}
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t create campaign');
			echo json_encode($arr);
			return false;
		}

	}

	function insertTasks($id) {
		$sql = 'INSERT INTO Task values ';
		for ($i = 0; $i < $_POST['number'] ; $i++) {
			$sequence = intval($_POST['start']) + intval($i)/2;
			if ($_POST['number'] != $i+1) {
				$appendingString = '(0, null, ' . $id . ', ' . $sequence . ', null, null, null, 0, 0, 0), ';
			} else {
				$appendingString = '(0, null, ' . $id . ', ' . $sequence . ', null, null, null, 0, 0, 0)';
			}
			
			$sql = $sql . $appendingString;
		}
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$arr = array('success' => 1, 'error_msg' => '');
			echo json_encode($arr);
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t create Tasks');
			echo json_encode($arr);
		}
	}

}
?>