<?php
	session_start();
	$data = json_decode($_POST['data'], true);

	
	if(count($data) == 0){
		updateTask();
	}else{
		$sql = 'INSERT INTO Event values';
		foreach ( $data as $i=>$row ){
			//generate minute, seconds and milliseconds
			$min = date('i', $row['Time']);
			$sec = date('s.u', $row['Time']);
			//structure of Event: EventId, TaskId, trackedPoint, min, sec, type_id, team_id, period_id, rating
			if(count($data)!= $i+1){
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="'.$_SESSION['token'].'" Limit 1), null, '.$min.', '.$sec.', '.$row['GameEvent'].', "'.$row['Team'].'", null, null, null), ';
			}else{
				$appendingString = '(0, (SELECT TaskId FROM Task WHERE token="'.$_SESSION['token'].'" Limit 1), null, '.$min.', '.$sec.', '.$row['GameEvent'].', "'.$row['Team'].'", null, null, null)';
			}
			$sql = $sql . $appendingString;
		}
		require 'config.php';
		$stmt = $DB->prepare($sql);
		if($stmt->execute()){
			updateTask();
		}else{
			print_r($stmt->errorInfo());
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