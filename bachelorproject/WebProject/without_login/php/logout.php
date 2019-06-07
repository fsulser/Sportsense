<?php
	session_start();
	$worker = $_SESSION['worker'];
	$campaign = $_SESSION['campaign'];
	session_destroy();
	header("Location: " . "http://www.microworkers.com");
?>