<?php
session_start();
if (!isset($_SESSION['AdminId'])) {
	header('Location:' . 'Login.php');
} else {
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-2.1.0.min.js"></script>
		<script src="js/login.js"></script>
		<script src="js/rate.js"></script>
		<script src="js/searchTask.js"></script>
		<script src="js/createTasks.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
		<script src="js/upload.js"></script>
		
		
		<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	<body align="center">
		<div class="panel panel-success" id="outerBox"  style="width: 860px; margin: 0 auto; border-width: 8px">
			<div class="panel-heading" style="border-top-right-radius: 0px; border-top-left-radius: 0px; text-align: center">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#home" data-toggle="tab">Home</a>
					</li>
					<li>
						<a href="#rate" data-toggle="tab">Tasks</a>
					</li>
					<li>
						<a href="#searchTask" data-toggle="tab">Search Task</a>
					</li>
					<li>
						<a href="#createTask" data-toggle="tab">Create Task</a>
					</li>
					<li>
						<a href="#uploader" data-toggle="tab">Upload Video</a>
					</li>
				</ul>
			</div>

			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane active" id="home">
						<?php
						$DB =
						require_once ('php/config.php');
						$sql = "SELECT COUNT(*) as count FROM Task where finished=1 AND isRated=0";
						$stmt = $DB -> prepare($sql);
						if ($stmt -> execute()) {
							$stmt = $stmt -> fetch();
							echo "<p>You have <b>" . $stmt['count'] . "</b> new finished tasks to rate.</p>";
						}
						?>
					</div>
					<div class="tab-pane" id="rate" style="text-align: left;"></div>
					<div class="tab-pane" id="searchTask" style="text-align: left;">
						<div>
							Task Token:
							<input type="text" id="TaskToken" />
							<input type="button" id="searchForTask" value="Search"/>
						</div>
						<br>
						<div id="searchResults"></div>
					</div>
					<div class="tab-pane" id="createTask">
						<?php
							$sql ="SELECT (Select TeamName From Teams where TeamId=homeTeam)as homeTeam, (Select TeamName From Teams where TeamId=awayTeam)as awayTeam, videoId FROM VideoInformations";
							require ('php/config.php');
							$stmt = $DB -> prepare($sql);
							if ($stmt -> execute()) {
								$stmt = $stmt -> fetchAll(PDO::FETCH_ASSOC);
								echo "<p> Select the game: </p> <select id='VideoId'>";
									for($i=0;$i<count($stmt);$i++){
										echo "<option value='".$stmt[$i]['videoId']."'>".$stmt[$i]['homeTeam']." : ".$stmt[$i]['awayTeam'];
								}
								echo "</option></select>";
							}
						?>
						<p>startTime: <input id="start" type="text" /></p>
						<p>number of tasks: <input id="number" type="text" /></p>
						<input type="button" value="create" id="createTasks"/>
					</div>

					<div class="tab-pane" id="uploader">
						<div id="newTeam_panel" class="panel-info">
							<input type="button" value="Add a new Team" id="newTeam" class="alert-info"/>
						</div>

						<form enctype="multipart/form-data" id="data">
							<?php
								$query = "SELECT TeamName, TeamId FROM Teams";
								require ('php/config.php');
								$stmt = $DB -> prepare($query);
								if($stmt->execute()){
									$array = $stmt -> fetchAll(PDO::FETCH_ASSOC);
																		
									echo '<p class="alert-info" style="padding: 10px; margin: 10px">Home team name:</p><select name="home"><option value="--">Home Team</option>';
											for($i=0;$i<count($array);$i++){
												echo '<option value="'.$array[$i]["TeamId"].'">'.$array[$i]["TeamName"].'</option>';
											}
									echo '</select>';
									

									echo '<p class="alert-info" style="padding: 10px; margin: 10px">Away team name:</p> <select name="away"><option value="--">Away Team</option>';
											for($i=0;$i<count($array);$i++){
												echo '<option value="'.$array[$i]["TeamId"].'">'.$array[$i]["TeamName"].'</option>';
											}
									echo '</select>';

									
								}
							?>

						    <p class="alert-info" style="padding: 10px; margin: 10px">Home shirt color:</p><input id="homeColor" type="text" name="homeColor" />
						    <p class="alert-info" style="padding: 10px; margin: 10px">Away shirt color:</p><input id="awayColor" type="text" name="awayColor"/>
						    <p class="alert-info" style="padding: 10px; margin: 10px">Select the video file</p></p><input name="file" type="file" id="fileSelector" />
						    <input type="button" value="Upload" id="upload_video" />
						    <progress id="progress" style="display: none"></progress>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>