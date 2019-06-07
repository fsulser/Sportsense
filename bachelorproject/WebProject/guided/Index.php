<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		<title>SportSense</title>
		<script src="js/extensions/jquery-1.11.0.js"></script>
		<script src="js/extensions/jquery.blockUI.js"></script>
		<script src="js/createEvent.js"></script>
		<script src="js/SubmitEvents.js"></script>
		<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<?php
		session_start();

		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		//check if the link contains parameters from microworkers
		if(isset($_GET['campaign']) && isset($_GET['worker'])){
			$Campaign_id = $_GET['campaign'];
			$Worker_id = $_GET['worker'];
			//set the two parameters to the session
			$_SESSION['worker'] = $Worker_id;
			$_SESSION['campaign'] = $Campaign_id;
			
			//check if setting up session succeeded
			if (isset($_SESSION['worker']) && isset($_SESSION['campaign'])) {
				
				//creating new User if no exists and check if he has already finished the basic task
				include 'php/User.php';
				new LoginClass();
				if ($_SESSION['Task'] == 'basic') {
					//create a new basic task to get a first rating
					include 'php/Basic/BasicTask.php';
					new BasicTask();
				} else {
					//create a standard task
					include 'php/Standard/StandardTask.php';
					new StandardTask();
				}
			} else {
				header('Location: ' . 'Info.php?title=Error in Microworkers Information&text=We couldn\'t get your account informations from microworkers.&display=danger');
			}
		}else{
			header('Location: ' . 'Info.php?title=Error in Microworkers Information&text=We couldn\'t get your account informations from microworkers.&display=danger');
		}
		
		
		?>

		<script type="text/javascript">
			//save session values in javascript to make them usable in javascript files.
			campaign = "<?php echo $_SESSION['campaign']; ?>";
			worker = "<?php echo $_SESSION['worker'] ?>";
			basic = "<?php echo $_SESSION['Task'] ?>";
			token = "<?php echo $_SESSION['token'] ?>";
		</script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>

	<body align="center">
		<?php include_once("analyticstracking.php") ?>
		<script type="text/javascript">
			//add a blocking message telling that video is still loading
			$.blockUI({
				message : '<h1> Please Wait until VideoPlayer loaded</h1>'
			});
			//get the startTime and the Snippet Length from the database und add it to variable used in createPlayer.js
			startTime = <?php echo Video::$sequence ?>;
			snippetLength = <?php echo Video::$sequenceLength ?>;
			//source file of the video. Load from the database
			videoSource = "<?php echo Video::$VideoSrc ?>";
		</script>

		<?php		
			//ask user if he really want to start the task
			echo '
				<div class="background"></div>
				<div class="overlay alert-success" ><h2>If you start this task, please finish it.</h2> Are you sure you want to start it? <br><div style="text-align:center"><input type="button" value="YES" onclick="resetToDefault();" style="margin: 10px"/><input type="button" value="NO" onclick="window.location.href = \'http://www.microworkers.com\'" style="margin: 10px"></div>
				<h2>Decription:</h2><br><h4> You get to see a 5 second snippet.<br> Please choose all events and add them to the list.</h4>
				</div>
			';
		?>
		<!-- adding the tutorial video in the foreground with a gray background -->
		<div class="background1"></div>
		<div class="overlay1 alert-success" style="padding: 10px; height: 800px; width: 1200px; margin-top: 0px">
			<h2 class="alert-info">Tutorial video</h2>
			<video controls src="videos/tutorial.mp4" style="height: 650px; position: relative; border: 7px solid black"></video>
			<input type="button" value="skip" style="position: absolute; margin: 100px; margin-top: 300px" onclick="$('.overlay1').remove(); $('.background1').remove(); startedTask = true;"/>
		</div>

		<div class="panel panel-success" id="outerBox"  style="width: 1200px; margin: 0 auto; border-width: 8px">
			<div class="panel-heading" style="border-top-right-radius: 0px; border-top-left-radius: 0px; text-align: center">
				<?php
					echo '<h2 style="margin-top: 0px; text-decoration:underline">' . Video::$home . ' - ' . Video::$away . '</h2>';
				?>
			</div>
			<div class="panel-body" style="padding: 10px; margin: 0px;">
				<div class="mytable">
					<div class="column1"></div>
					<div class="column2"></div>
					<div class="myrow">
						<div class="mycell alert-info panel">
							<h3 style="width: 100%;text-align: center; padding: 10px"><b>1.</b> Go to the imageframe where an event happens</h3>
						</div>
						<div id="titles" class="mycell alert-info panel">
							<h3 class="Out" style="padding: 10px;"><b>Outside your task</b></h3>
							<h3 class="Events" style="padding: 10px;"><b>2.</b> Select the event that happend</h3>
							<h3 class="Teams" style="padding: 10px;"><b>3.</b> Select the team that performed the event, or
							<input type="button" class="cancelAdding alert-danger" value="cancel" />
							adding this event</h3>
							<h3 class="Field" style="padding: 10px;"><b>4.</b> Set the point on the fiel where the event was, or
							<input type="button" class="cancelAdding alert-danger" value="cancel" />
							adding this event</h3>
						</div>
					</div>
					<div class="myrow">
						<div class="mycell" style="text-align: center">
							<video id="VideoElement"></video>
							<div>
								Current Time : <span  id="currentTime">0</span>
							</div>

							<div class="imageContainer">
								<div id="imgdiv-3" class="frames"><img id="img-3" class="overlayPictures" src="images/fffb.png"/>
								</div>
								<div id="imgdiv-2" class="frames"><img id="img-2" class="overlayPictures" src="images/ffb.png"/>
								</div>
								<div id="imgdiv-1" class="frames"><img id="img-1" class="overlayPictures" src="images/fb.png"/>
								</div>
								<div id="imgdiv0" class="frames"><img id="img0" class="overlayPictures" src="images/pause.png"/>
								</div>
								<div id="imgdiv1" class="frames"><img id="img1" class="overlayPictures" src="images/fv.png"/>
								</div>
								<div id="imgdiv2" class="frames"><img id="img2" class="overlayPictures" src="images/ffv.png"/>
								</div>
								<div id="imgdiv3" class="frames"><img id="img3" class="overlayPictures" src="images/fffv.png"/>
								</div>
							</div>
							<p id="videoText" class="alert"></p>
						</div>
						<div class="mycell Events">
							<?php
								//get all events with descriptions from the database
								$sql = "SELECT EventNamesId, EventName, EventDescription FROM EventNames ORDER BY ListId";
								require ('php/Connect.php');
								$stmt = $DB -> prepare($sql);
								$stmt -> execute();
								$rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
								foreach ($rows as $row) {
									echo "<div class='EventOpt btn-primary' id='EventNamesId_" . $row['EventNamesId'] . "'><b class='buttonOuter'>" . $row['EventName'] . "</b><img src='images/question.png' class='question' rel='tooltip' title='" . $row['EventDescription'] . "'/></div>";
								}
							?>
						</div>
						<div class="mycell Teams">
							<?php
							//get the teams names and colors from the database
							echo "<div class='teamOpt btn-lg btn-primary' id='Team_" . Video::$home . "'><b class='buttonOuter'>" . Video::$home . " (" . Video::$homeColor . ")</b></div>";
							echo "<div class='teamOpt btn-lg btn-primary' id='Team_" . Video::$away . "'><b class='buttonOuter'>" . Video::$away . " (" . Video::$awayColor . ")</b></div>";
							?>
						</div>

						<div class="mycell Field">
							<div id="FieldImage"><img src="images/field.png" style="width: 100%; height: 100%" />
							</div>
							<input type="button" id="addImagePoint" value="add Point" />
						</div>

						<div class="mycell Out alert-warning" style="height: 341px; padding-top: 100px">
							<h3> Your task starts at:</h3>
							<p id="start"></p>
							<h3>and ends at:</h3>
							<p id="end"></p>
						</div>
					</div>
				</div>
				<script src="js/createPlayer.js"></script>

				<div class="alert alert-warning" style="padding: 2px; margin-top: 10px; margin-bottom: 0px; text-align: center">
					<h4 style="padding-top: 10px;">Added events</h4>
				</div>
				<div class="alert panel-warning" style="margin-top: 0px; text-align: center">
					<table class="table table-striped" style="margin-bottom: 10px">
						<thead>
							<tr class="row">
								<th>Id</th>
								<th>Team</th>
								<th>Event</th>
								<th>Time</th>
								<th>Position</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody id="capturedEvents"></tbody>
					</table>
					<input type="button" id="submit" value="Submit all Events"/>
				</div>
			</div>
		</div>
	</body>
</html>