<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-2.1.0.min.js"></script>
		<script src="js/login.js"></script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	<body align="center">
		<?php
		session_start();
		
		if (isset($_SESSION['AdminId'])) {
			echo "string";
			header('Location: ' . 'Index.php');
		} else {
			session_destroy();
			echo '<div class="background" style="width: 100%; margin: 0 auto; border-width: 8px; border-color: #dff0d8"></div>
						<div id="login_outer" style="position: relative; margin: 0 auto;">
							<h1>Login</h1>
							<p class="left">Email: <input type="text" class="field" id="login_user"/></p>
							<p class="left">Password: <input type="password" class="field" id="login_pw"/></p>
							<br>
							<input type="button" value="Login" id="loginUser" class="loginButton" />
						</div>
					';
		}
		
		?>
	</body>
</html>