<?php
	$host = 'localhost';
	$database = 'SportSense_without';
	$userName = 'root';
	$Password = '';
	
	try {
		$DB = new PDO('mysql:host=' . $host . ';dbname=' . $database, $userName, $Password);
		return $DB;
	} catch(PDOException $e) {
		print 'Error: ' . $e -> getMessage();
		die();
	}
?>
