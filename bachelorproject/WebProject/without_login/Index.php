<?php
	session_start();

	// $userAgent = $_SERVER['HTTP_USER_AGENT'];
	// if(isset($_GET['campaign']) && isset($_GET['worker'])){
		// $Campaign_id = $_GET['campaign'];
		// $Worker_id = $_GET['worker'];
		// $_SESSION['worker'] = $Worker_id;
		// $_SESSION['campaign'] = $Campaign_id;
// 		
		// if (isset($_SESSION['worker']) && isset($_SESSION['campaign'])) {
			// $Login = new LoginClass();
		// } else {
			// header('Location: ' . 'Failed.php?title=Error in Microworkers Information&text=We couldn\'t get your account informations from microworkers.&display=danger');
		// }
	// }else{
		// header('Location: ' . 'Failed.php?title=Error in Microworkers Information&text=We couldn\'t get your account informations from microworkers.&display=danger');
	// }

	$_SESSION['worker'] = 'a'.rand(0,1000);
	$_SESSION['campaign'] = 'test';
	new LoginClass();
	
	class LoginClass {
		private static $DB;
	
		function LoginClass() {
			self::$DB =
			require ('php/config.php');
			$this -> checkIfUserExists();
		}
	
		function checkIfUserExists() {
			$sql = "SELECT UID FROM Users WHERE microworkersId='" . $_SESSION['worker'] . "'";
			$stmt = self::$DB -> prepare($sql);
			if ($stmt -> execute()) {
				if ($stmt -> rowCount() == 1) {
					$this -> createSession($stmt);
				} elseif ($stmt -> rowCount() == 0) {
					$this -> createUser();
				} else {
					header('Location: ' . 'Failed.php?title=Database Error&text= An error with your account occured in the database. &display=dangers');
				}
			} else {
//				header('Location: ' . 'Failed.php?title=Error&text=We couldn\'t get your account information. &display=danger');
			}
		}
	
		function createUser() {
			//Users UID, microworkersId, userRating
			$sql = "INSERT INTO Users values(0, '" . $_SESSION['worker'] . "', null, null, 5)";
			$stmt = self::$DB -> prepare($sql);
			if ($stmt -> execute()) {
				$this -> checkIfUserExists();
			} else {
				// header('Location: ' . 'Failed.php?title=Error&text=We couldn\'t get your account information. &display=danger');
			}
		}
	
		function createSession($stmt) {
			self::$DB = null;
			$stmt = $stmt -> fetch();
			$_SESSION['UID'] = $stmt['UID'];
			new Task();
		}
	
	}
	
	class Task{
		public static $DB, $home, $away, $homeColor, $awayColor, $sequence, $sequenceLength, $VideoSrc;
		
		function Task(){
			self::$DB = require 'php/config.php';
			if($this->checkCampaignFirstTime()){
				if($this->checkRating()){
					$this->generateToke();
					$this->getVideoInformations();
					$this->createImages();
				}
			}
		}
		
		function generateToke(){
			$My_secret_key = '7ac67acc9451904dae80d6b532a3cb0ee9471029859914e8a9cfdff4a3ddcd0a';
			$FinalString = $_SESSION['campaign'] . $_SESSION['worker'] . $My_secret_key;
	
			$vcode_for_proof = "mw-" . hash('sha256', $FinalString);

			$_SESSION['token'] = $vcode_for_proof;
		}
		
		function checkCampaignFirstTime(){
			$sql = "SELECT TaskId FROM Task WHERE taskToken='".$_SESSION['campaign']."' AND UID='".$_SESSION['UID']."'";
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				if($stmt->rowCount()==0){
					return true;
				}else{
					header('Location: ' . 'Failed.php?title=Task Already Finished&text=You have already finished this task. Due to the paying of Microworkers it is not possible to do a task twice. &display=warning');
					return false;
				}
			}else{
				// header('Location: ' . 'Failed.php?title=Failed&text=Couldn\'t connect to server &display=danger');
				return false;
			}
		}
		
		function checkRating(){
			$sql = "SELECT userRating FROM Users WHERE UID=".$_SESSION['UID'];
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				if($stmt->rowCount()==1){
					$stmt = $stmt->fetch();
					if($stmt['userRating']<=0){
						header('Location: ' . 'Failed.php?title=Rating&text=Your Rating is too bad, you can\'t do any more tasks&display=danger');
					}elseif($stmt['userRating']<=2){
						//TODO alert warning caused to rating
					}else{
						return true;
					}
				}else{
					header('Location: ' . 'Failed.php?title=Error&text=Your account does not exists or there was en error in the database. &display=danger');
				}
			}else{
				header('Location: ' . 'Failed.php?title=Error&text=We couldn\'t get your account information. &display=danger');
			}
		}

		function getVideoInformations(){
			$sql = 'SELECT (Select TeamName from Teams where TeamId=awayTeam)as homeTeam, (Select TeamName from Teams where TeamId=homeTeam)as awayTeam, link, homeColor, awayColor, sequence, sequenceLength, sequenceEnd FROM VideoInformations where active=1 LIMIT 1 ';
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				$row = $stmt->fetch();

				self::$home = $row['homeTeam'];
				self::$away = $row['awayTeam'];
				self::$homeColor = $row['homeColor'];
				self::$awayColor = $row['awayColor'];
				self::$sequence = $row['sequence'];
				self::$sequenceLength = $row['sequenceLength'];
				self::$VideoSrc = $row['link'];
			}else{
				header('Location: ' . 'Failed.php?title=Failed to get Video Information &text=We couldn\'t get your task information. Please try again from Microworkers. &display=warnings');
			}
		}
				
		function createImages(){
			$size = '67*36';
			$framesPerSecond = 10;
			$filePath = 'tmp/'.$_SESSION['token'].'/out%2d.png';
			$length = self::$sequenceLength+0.001;
			$cmd = 'ffmpeg -ss '.self::$sequence.' -t '.$length.' -i '.self::$VideoSrc.' -s '.$size.' -r '.$framesPerSecond.' '.$filePath;

			exec('rm -rf tmp/'.$_SESSION['token']);
			exec('mkdir tmp/'.$_SESSION['token']);
			
			exec($cmd);
			
		}
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
		  <meta http-equiv="Cache-Control" content="max-age=299999999" />
		  <meta http-equiv="Pragma" content="no-cache" />
		<title>SportSense</title>
		<script src="js/extensions/jquery-1.11.0.js"></script>
		<script src="js/extensions/jquery.blockUI.js"></script>
		<script src="js/showEntry.js"></script>
		<script src="js/addEvent.js"></script>
		<script src="js/EventButtons.js"></script>
		<script src="js/SubmitEvents.js"></script>
		<script src="js/login.js"></script>
		<script src="js/createTask.js"></script>
		<script type="text/javascript">
			campaign = "<?php echo $_SESSION['campaign']; ?>";
			worker = "<?php echo $_SESSION['worker'] ?>";
			
			imageArray = new Array();
			for(var i=1; i<=51; i++){
				imageArray[i] = new Image();
				if(i<10){
					imageArray[i].src = "<?php echo 'tmp/'.$_SESSION['token'].'/out';?>0" + i + ".png?v=123";
				}else{
					imageArray[i].src = "<?php echo 'tmp/'.$_SESSION['token'].'/out';?>" + i + ".png?v=123";
				}
			}
			

		</script>
		
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	<body align="center">
		<script type="text/javascript">
			$.blockUI({
				message : '<h1> Please Wait until VideoPlayer is loaded</h1>'
			});
		</script>
		
		<?php
			echo '
			<div class="background"></div>
			<div id="login_outer"><h2>If you start this task, please finish it.</h2> Are you sure you want to start it? <br><div style="text-align:center"><input type="button" value="YES" onclick="createTask();" style="margin: 10px"/><input type="button" value="NO" onclick="window.location = \'php/logout.php\'" style="margin: 10px"></div>
				<h2>Decription:</h2><br><h4> You get to see a 5 second snippet.<br> Please choose all events and add them to the list.</h4>
			</div>
			';
		?>
		
		<div class="panel panel-success" id="outerBox"  style="width: 860px; margin: 0 auto; border-width: 8px">

			<div class="panel-heading" style="border-top-right-radius: 0px; border-top-left-radius: 0px; text-align: center">
				<?php
					echo '<h2 style="margin-top: 0px; text-decoration:underline">' . Task::$home . ' - ' . Task::$away . '</h2>';
				?>
			</div>

			<div class="panel-body">
				<div id="container">
					<div id="videoFrame">

						<video id="VideoElement"></video>

						<div>
							Current Time : <span  id="currentTime">0</span>
						</div>

						<div class="imageContainer">
							<div id="imgdiv-3" class="frames"><img id="img-3" class="eventPictures" src="images/fffb.png"/></div>
							<div id="imgdiv-2" class="frames"><img id="img-2" class="eventPictures" src="images/ffb.png"/></div>
							<div id="imgdiv-1" class="frames"><img id="img-1" class="eventPictures" src="images/fb.png"/></div>
							<div id="imgdiv0" class="frames"><img id="img0" class="eventPictures" src="images/pause.png"/></div>
							<div id="imgdiv1" class="frames"><img id="img1" class="eventPictures" src="images/fv.png"/></div>
							<div id="imgdiv2" class="frames"><img id="img2" class="eventPictures" src="images/ffv.png"/></div>
							<div id="imgdiv3" class="frames"><img id="img3" class="eventPictures" src="images/fffv.png"/></div>
						</div>
						<p id="videoText" class="alert"></p>

						<script type="text/javascript">
							//get the startTime and the Snippet Length from the database und add it to variable used in createPlayer.js
							startTime = <?php echo Task::$sequence ?>;
							snippetLength = <?php echo Task::$sequenceLength ?>;
							//source file of the video. Load from the database
							videoSource = "<?php echo Task::$VideoSrc ?>
								";
						</script>
						<script src="js/createPlayer.js"></script>
					</div>

					<div id="eventFrame" class="box">
						<div class="box">
							<p>
								<b>Please select the event that happend</b>
							</p>

							<select id="Events">
								<option value="--">Event</option>
								<?php
								$sql = "SELECT EventNamesId, EventName, EventDescription FROM EventNames ORDER BY ListId";
								$stmt = Task::$DB -> prepare($sql);
								$stmt -> execute();
								$rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
								foreach ($rows as $row) {
									echo "<option value='" . $row['EventNamesId'] . "' class='EventOpt' title='" . $row['EventDescription'] . "'>" . $row['EventName'] . "</option>";
								}
								?>
							</select>
						</div>
						<div class="box">
							<p>
								<b>Please select the team that performed the event</b>
							</p>
							<select id="Team">
								<option value="--">Team</option>
								<?php
								echo '<option value="'.Task::$home.'">' . Task::$home . ' (' . Task::$homeColor . ') </option>';
								echo '<option value="'.Task::$away.'">' . Task::$away . ' (' . Task::$awayColor . ') </option>';
								?>
							</select>
						</div>
						<div class="box">
							<p>
								<b>Please check the time:</b>
							</p>
							<div>
								<b style="padding:20px"> Minute:</b>
								<b style="padding:20px"> Seconds:</b>
							</div>
							<p>
								<i id="minute"></i>
								<i id="second" style="padding-left:70px"></i>.<i id="millisecond"></i>
							</p>
						</div>
						<div class="box" style="border: 0px; padding:0px; margin:0px">
							<input type="button" id="addEvent" value="Add Event"/>
							<input type="button" class="alert-success" id="changeEvent" value="Change" style="display: none;"/>
							<input type="button" class="alert-warning" id="cancelChangingEvent" value="Cancel" style="display: none; margin-left: 5px; margin-right: 5px"/>
							<input type="button" class="alert-danger" id="clearEvent" value="Delete" style="display: none"/>
						</div>
					</div>
				</div>
				
				<div class="alert alert-warning" style="padding: 2px; margin-top: 10px; margin-bottom: 0px; text-align: center"><h5>Added events</h5></div>
				<div class="alert panel-warning" style="margin-top: 0px; text-align: center">
					<h4 style="color: #8a6d3b">click on a row to change the event</h4>
					<table style="margin-bottom: 10px">
						<tbody id="capturedEvents">
							<tr>
								<th style="min-width: 30px;">Id</th>
								<th style="min-width: 100px;">Team</th>
								<th style="min-width: 100px;">Event</th>
								<th style="min-width: 60px;">Time</th>
							</tr>
						</tbody>
					</table>
					<input type="button" id="submit" value="Submit all Events"/>
				</div>
			</div>
		</div>
	</body>
</html>