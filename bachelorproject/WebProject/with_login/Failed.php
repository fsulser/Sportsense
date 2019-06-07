<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-1.11.0.js"></script>
		<script src="js/login.js"></script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	
	<body align="center">
		<div class="background" style="width: 100%; margin: 0 auto; border-width: 8px;"></div>
		<?php
			session_start();
			if($_GET['display']=='warning'){
				echo '<div id="login_outer" class="alert-warning" style="position: relative; margin: 0 auto; background-color: #FCF8E3; padding-top: 140px;">';
			}elseif($_GET['display'] == 'success'){
				echo '<div id="login_outer" class="alert-success" style="position: relative; margin: 0 auto; background-color: rgb(214, 233, 198); border-color: rgb(250, 235, 204); color: #3C763D; padding-top: 140px;">';
			}else{
				session_destroy();
				echo '<div id="login_outer" class="alert-danger" style="position: relative; margin: 0 auto; background-color: #f2dede; padding-top: 140px;">';				
			}
		?>
			<div>
				<h1><?php echo $_GET['title'];?></h1>
				<p><?php echo $_GET['text'];?></p>
				<br>
				<p> Click here to go back to <a href="http://www.microworkers.com">Microworkers</a>.</p>
				<br>
				<input type="button" value="Logout" onclick="window.location = 'php/logout.php'" />
			</div>
		</div>
	</body>
</html>