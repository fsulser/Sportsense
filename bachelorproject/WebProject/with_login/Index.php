<!-- Get Informations from Microworkers -->
<?php
session_start();
$Campaign_id = 'test';//$_GET['campaign'];
$Worker_id = 'testworker';//$_GET['worker'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-1.11.0.js"></script>
		<script src="js/login.js"></script>
		<script type="text/javascript">
			campaign = "<?php echo $Campaign_id?>";
			worker = "<?php echo $Worker_id?>";
		</script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	<body align="center">
		<?php
		if (isset($_SESSION['UID']) && isset($_SESSION['Mail'])) {
			header('Location: ' . 'Task.php?campaign=' . $Campaign_id . '&worker=' . $Worker_id);
		} else {
			session_destroy();
			echo '<div class="background" style="width: 100%; margin: 0 auto; border-width: 8px; border-color: #dff0d8"></div>
						<div id="login_outer" style="position: relative; margin: 0 auto">
							<div id="register" class="login_box">
								<h1>Create new Account</h1>
								<h4>Please Enter your correct Email adress. You will receive the tokens after evaluating your answers to this one.</h4>
								<p class="left">Email: <input type="text" class="input_right" id="create_mail"/></p>
								<p class="left">Password: <input type="password" class="input_right" id="create_pw"/></p>
								<p class="left">verify Password: <input type="password" class="input_right" id="create_pw_verification"/></p>
								<br>
								<input type="button" value="Create Account" id="createUser" class="loginButton" />
							</div>
							<div id="login" class="login_box">
								<h1>Login</h1>
								<p class="left">Email: <input type="text" class="input_right" id="login_mail"/></p>
								<p class="left">Password: <input type="password" class="input_right" id="login_pw"/></p>
								<br>
								<input type="button" value="Login" id="loginUser" class="loginButton" />
							</div>
						</div>
					';
		}
		
		?>
	</body>
</html>