<?php
	$host = 'localhost';
	$database = 'sportsense';
	$userName = 'root';
	$Password = '';
	
	try {
		//create the pdo connection to the database
		$DB = new PDO('mysql:host=' . $host . ';dbname=' . $database, $userName, $Password);
		return $DB;
	} catch(PDOException $e) {
		print 'Error: ' . $e -> getMessage();
		die();
	}
?>
