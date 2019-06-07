<?php
	session_start();
	require 'config.php';
	$sql = "SELECT TeamName, TeamId FROM Teams";
	$stmt = $DB -> prepare($sql);
	if ($stmt -> execute()) {
		$array = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($array);
	} else {
		$arr = array('success' => 0, 'error_msg' => 'Couldn\'t execute query.');
		echo json_encode($arr);
	}

?>