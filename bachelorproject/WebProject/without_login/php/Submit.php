<?php
	session_start();
	$data = json_decode($_POST['data'], true);

	if(count($data) == 0){
		updateTask();
	}else{
		$sql = 'INSERT INTO Event values';
		foreach ( $data as $i=>$row ){
			//generate minute, seconds and milliseconds
			$time = explode ('.', $row['Time']);
			if (strpos($row['Time'],'.') !== false) {
				$msec = $time[1].' ';
			}else{
				$msec = '00';				
			}
			$min = date ('i', $time[0]);
			$sec = date ('s', $time[0]);
			
			//structure of Event: EventId, TaskId, trackedPoint, min, sec, msec, type_id, team_id, player_id, period_id, rating
			if(count($data)!= $i+1){
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="'.$_SESSION['token'].'" Limit 1), null, '.$min.', '.$sec.', '.$msec.', '.$row['EventId'].', (SELECT TeamId FROM Teams WHERE TeamName="'.$row['Team'].'"), null, null, null), ';
			}else{
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="'.$_SESSION['token'].'" Limit 1), null, '.$min.', '.$sec.', '.$msec.', '.$row['EventId'].', (SELECT TeamId FROM Teams WHERE TeamName="'.$row['Team'].'"), null, null, null)';
			}
			$sql = $sql . $appendingString;
		}
		require 'config.php';
		$stmt = $DB->prepare($sql);
		if($stmt->execute()){
			updateTask();
		}else{
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
			
	}
	
	function updateTask(){
		require 'config.php';
		$sql1 = 'UPDATE Task set finished = 1 WHERE token="'.$_SESSION['token'].'"';
		$stmt1 = $DB->prepare($sql1);
		if($stmt1->execute()){
			$arr = array('success' => 1, 'error_msg' => '');
			echo json_encode($arr);
		}else{
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}		
	}
	
?>