<?php

	if(isset($_POST['teamName'])){
		$sql = "INSERT INTO Teams VALUES(0,'".$_POST['teamName']."')";
		if(!checkTeamExists($_POST['teamName'])){
			$array = (array('success' => 0, 'error_msg' => 'Team already exists.'));
			echo json_encode($array);
		}else{
			require ('config.php');
			$stmt = $DB->prepare($sql);
			if($stmt->execute()){
				$array = (array('success' => 1, 'error_msg' => 'Created new Team.'));
				echo json_encode($array);
			}else{
				$array = (array('success' => 0, 'error_msg' => 'Failed to create new Team.'));
				echo json_encode($array);
			}
		}
	}else{
		$array = (array('success' => 0, 'error_msg' => 'Access denied.'));
		echo json_encode($array);
	}
	
	function checkTeamExists($name){
		$sql = "SELECT COUNT(*)AS count FROM Teams WHERE TeamName='".$name."'";
		require ('config.php');
		$stmt = $DB->prepare($sql);
		if($stmt->execute()){
			$stmt = $stmt->fetch();
			if($stmt['count']==0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}



?>