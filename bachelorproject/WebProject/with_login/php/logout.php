<?php
	session_start();
	$worker = $_SESSION['worker'];
	$campaign = $_SESSION['campaign'];
	session_destroy();
	header("Location: " . "../Index.php?campaign=" . $campaign . '&worker=' . $worker);
?>