<?php
	session_start();
	if (isset($_SESSION['token'])) {
		$Task = new CreateTask();
	}else{
		header('Location: ' . 'Task.php?campaign=' . $Campaign_id . '&worker=' . $Worker_id);
	}
	
	
	class CreateTask{
		private static $Campaign_id, $Worker_id;
		private static $DB;
		private static $videoId;
		
		function CreateTask(){
			self::$DB = require ('config.php');
			$this->setWorkerInformations();
			if($this->checkSequenceTime()){
				//structure:  TaskId, UId, VideoId, sequenceStart, token, taskToken, rating, finished
				$token = $_SESSION['token'];
				$campaign = $_SESSION['campaign'];
				$sql = "INSERT INTO Task values (0, (Select UID FROM Users WHERE UID =".$_SESSION['UID']."), (SELECT VideoId from VideoInformations where active=1),  (SELECT sequence FROM VideoInformations WHERE active=1), '".$token."', '".$campaign."', null, 0)";
				$stmt = self::$DB->prepare($sql);
				if(!$stmt->execute()){
					header('Location: ' . 'Failed.php?title=couldn\'t create a new Task&text=please go back to <a href="http://www.microworkers.com">Mikroworkers</a> and try again&display=danger');
				}else{
					$this->updateSequence();
				}
			}
		}
		
		function setWorkerInformations(){
			if(!isset($_GET['campaign'])){
				header('Location: ' . 'Failed.php?title=couldn\'t create a new Task&text=please go back to <a href="http://www.microworkers.com">Mikroworkers</a> and try again&display=danger');
			}elseif(!isset($_GET['worker'])){
				header('Location: ' . 'Failed.php?title=couldn\'t create a new Task&text=please go back to <a href="http://www.microworkers.com">Mikroworkers</a> and try again&display=danger');
			}else{
				self::$Campaign_id = $_GET['campaign'];
				self::$Worker_id = $_GET['worker'];
			}
		}
		
		function checkSequenceTime(){
			$sql = 'SELECT VideoId, sequence, sequenceLength, sequenceEnd FROM VideoInformations WHERE active=1';
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				$stmt = $stmt->fetch();
				self::$videoId = $stmt['VideoId'];
				if(intval($stmt['sequenceEnd']) <= intval($stmt['sequence']) + intval($stmt['sequenceLength'])){
					header('Location: ' . 'Failed.php?title=No more Tasks&text=There are actually no more Tasks to do. Click on the link to go back to <a href="http://www.microworkers.com">Mikroworkers</a>.&display=warning');
				}else{
					return true;
				}
			}else{
				header('Location: ' . 'Failed.php?title=No more Tasks&text=There are actually no more Tasks to do. Click on the link to go back to <a href="http://www.microworkers.com">Mikroworkers</a>.&display=warning');
			}
		}

		function updateSequence(){
			$sql = 'Update VideoInformations set sequence=sequence+1 WHERE VideoId='. self::$videoId;
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				$arr = array('success' => 1, 'error_msg' => '');
				echo json_encode($arr);
			}else{
				print_r($stmt->errorInfo());
				header('Location: ' . 'Failed.php?title=couldn\'t create a new Task&text=please go back to <a href="http://www.microworkers.com">Mikroworkers</a> and try again&display=danger');
			}
		}
	}
?>