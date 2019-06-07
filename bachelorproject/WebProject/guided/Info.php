<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-1.11.0.js"></script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">

	</head>

	
	<body align="center">
		<?php include_once("analyticstracking.php") ?>
		<div class="background"></div>
		<?php
			session_start();
			// check which background color should be used to warn user
			if($_GET['display']=='task'){
				echo '<div class="overlay alert-warning" style="position: relative; margin: 0 auto; background-color: #FCF8E3; padding-top: 140px;">';				
			}else{
				if(!isset($_GET['display'])){
					if(!isset($_GET['title'])){
						$_GET['display']='danger';
						$_GET['title'] = 'ERROR';
						$_GET['text'] = 'Coulnd\'t create token.';
					}
				}
	
				if($_GET['display']=='warning'){
					echo '<div class="overlay alert-warning" style="position: relative; margin: 0 auto; background-color: #FCF8E3; padding-top: 140px;">';
				}elseif($_GET['display'] == 'success'){
					echo '<div class="overlay alert-success" style="position: relative; margin: 0 auto; background-color: rgb(214, 233, 198); border-color: rgb(250, 235, 204); color: #3C763D; padding-top: 80px;">';
				}else{
					echo '<div class="overlay alert-danger" style="position: relative; margin: 0 auto; background-color: #f2dede; padding-top: 140px;">';				
				}				
			}
		?>
			<div>
				<h1><?php echo $_GET['title'];?></h1>
				<p><?php echo $_GET['text'];?></p>
				<?php
					if($_GET['display'] == 'success'){
						echo "<br><div class='alert alert-info'><h4>".$_SESSION['token']."</h4></div>";
					}
				?>
				<br>
				<p> Click here to go back to <a href="http://www.microworkers.com">Microworkers</a>.</p>
			</div>
		</div>
		<?php
			session_destroy();
		?>
	</body>
</html>