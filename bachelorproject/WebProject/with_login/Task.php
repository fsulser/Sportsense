<?php
	session_start();
	if (isset($_SESSION['UID']) and isset($_SESSION['Mail'])) {
		new Task();
	} else {
		session_destroy();
		header('Location: ' . 'Index.php?campaign=' . $_GET['campaign'] . '&worker=' . $_GET['worker']);
	}
	
	class Task{
		public static $DB, $home, $away, $homeColor, $awayColor, $sequence, $sequenceLength, $VideoSrc,$Campaign_id,$Worker_id;
		
		function Task(){
			self::$DB = require ('php/config.php');
			
			if($this->checkGetters()){
				if($this->checkCampaignFirstTime()){
					if($this->checkSessionValues()){
						$this->getVideoInformations();
						$this->createImages();
					}
				}
			}
			
		}

		function getVideoInformations(){
			$sql = 'SELECT * FROM VideoInformations LIMIT 1';
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				$row = $stmt->fetch();

				self::$home = $row['homeTeam'] . "\t";
				self::$away = $row['awayTeam'] . "\t";
				self::$homeColor = $row['homeColor'] . "\t";
				self::$awayColor = $row['awayColor'] . "\t";
				self::$sequence = $row['sequence'] . "\t";
				self::$sequenceLength = $row['sequenceLength'] . "\t";
				self::$VideoSrc = $row['link'] . "\t";
			}else{
				header('Location: ' . 'Failed.php');
			}
		}
		
		function checkGetters(){
			if (!isset($_GET['campaign']) or !isset($_GET['worker'])) {
				session_destroy();
				header('Location: ' . 'Failed.php');
			}else{
				$this->generateSessions();
				return true;
			}
		}
		
		function generateSessions(){
			self::$Campaign_id = $_GET['campaign'];
			self::$Worker_id = $_GET['worker'];
			
			$My_secret_key = '41955dc109898aea604d482f73a139669e0135dc9ee2750856b289c6fdc5c468';
	
			$FinalString = self::$Campaign_id . self::$Worker_id . $My_secret_key;
	
			$vcode_for_proof = "mw-" . hash('sha256', $FinalString);
			//TODO replace with correct token
			$_SESSION['token'] = $vcode_for_proof;
			$_SESSION['campaign'] = self::$Campaign_id;
			$_SESSION['worker'] = self::$Worker_id;
		}
		
		function checkCampaignFirstTime(){
			$sql = "SELECT TaskId FROM Task WHERE taskToken='".$_SESSION['campaign']."' AND UID='".$_SESSION['UID']."'";
			$stmt = self::$DB->prepare($sql);
			if($stmt->execute()){
				if($stmt->rowCount() == 0){
					return true;
				}else{
					header('Location: ' . 'Failed.php?title=Task Already Finished&text=You have already finished this task. Due to the paying of Microworkers it is not possible to do a task twice. &display=warning');
					return false;
				}
			}else{
				header('Location: ' . 'Failed.php?title=Failed&text=Couldn\'t connect to server &display=danger');
				return false;
			}
		}
		
		function checkSessionValues(){
			$sql = "SELECT userRating FROM Users WHERE UID='".$_SESSION['UID']."'and userEmail='".$_SESSION['Mail']."'";
			$stmt = self::$DB->prepare($sql);
			$stmt->execute();
			if($stmt->rowCount()==1){
				$stmt = $stmt->fetch();
				if($stmt['userRating']<=0){
					header('Location: ' . 'Failed.php?title=Rating&text=Your Rating is too bad, you can\'t do any more tasks&display=danger');
				}else{
					return true;
				}
			}else{
				session_destroy();
				header('Location: ' . 'Index.php?campaign=' . $_GET['campaign'] . '&worker=' . $_GET['worker']);
			}
		}
		
		
		function createImages(){
			$size = '67*36';
			$framesPerSecond = 10;
			$filePath = '../tmp/'.$_SESSION['token'].'/out%2d.bmp';
			$cmd = 'ffmpeg -ss '.self::$sequence.' -t '.self::$sequenceLength.' -i '.self::$VideoSrc.' -s '.$size.' -r '.$framesPerSecond.' '.$filePath;

			exec('rm -rf ../tmp/'.$_SESSION['token']);
			exec('mkdir ../tmp/'.$_SESSION['token']);
			
			exec($cmd);
			
		}
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="US-ASCII">
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
			campaign = "<?php echo Task::$Campaign_id?>";
			worker = "<?php echo Task::$Worker_id?>";

			imageArray = new Array();
			for(var i=1; i<=51; i++){
				imageArray[i] = new Image();
				if(i<10){
					imageArray[i].src = "<?php echo '../tmp/'.$_SESSION['token'].'/out';?>0" + i + ".bmp";
				}else{
					imageArray[i].src = "<?php echo '../tmp/'.$_SESSION['token'].'/out';?>" + i + ".bmp";
				}
			}
			
			<?php
				exec('rm -rf ../tmp/'.$_SESSION['token']);
			?>
			
		</script>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">

	</head>

	<body align="center">
		
		<?php
			echo '
			<div class="background"></div>
			<div id="login_outer"><h2 style="padding-top: 100px">You are already logged in with Email </h2><br><h1 style="color: #31708F">' . $_SESSION['Mail'] . '</h1><br><div style="text-align:center"><input type="button" value="Logout" onclick="window.location = \'php/logout.php\'" style="margin: 10px"/><input type="button" value="OK" onclick="createTask();" style="margin: 10px"></div></div>
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
							<div id="imgdiv-3" class="frames"><img id="img-3" class="eventPictures" src="../images/fffb.png"/></div>
							<div id="imgdiv-2" class="frames"><img id="img-2" class="eventPictures" src="../images/ffb.png"/></div>
							<div id="imgdiv-1" class="frames"><img id="img-1" class="eventPictures" src="../images/fb.png"/></div>
							<div id="imgdiv0" class="frames"><img id="img0" class="eventPictures" src="../images/pause.png"/></div>
							<div id="imgdiv1" class="frames"><img id="img1" class="eventPictures" src="../images/fv.png"/></div>
							<div id="imgdiv2" class="frames"><img id="img2" class="eventPictures" src="../images/ffv.png"/></div>
							<div id="imgdiv3" class="frames"><img id="img3" class="eventPictures" src="../images/fffv.png"/></div>
						</div>
						<p id="videoText" class="alert"></p>

						<script type="text/javascript">
														//get the startTime and the Snippet Length from the database und add it to variable used in createPlayer.js
							startTime = <?php echo Task::$sequence ?>;
							snippetLength = <? echo Task::$sequenceLength ?>;
							//source file of the video. Load from the database
							videoSource = "<?php echo Task::$VideoSrc ?>
								";
						</script>
						<script src="js/createPlayer.js"></script>
					</div>

					<div id="eventFrame" class="box">
						<div class="box">
							<p>
								<b>Please Select The Event that happend</b>
							</p>
							<select id="Events">
								<option value="--">Event </option>
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
								<b>Please Select The Team which belongs to the event</b>
							</p>
							<select id="Team">
								<option value="--">Team</option>
								<?php
								echo '<option value="' . Task::$home . '">' . Task::$home . '(' . Task::$homeColor . ')</option>';
								?>
							</select>
						</div>
						<div class="box">
							<p>
								Please check the time:
							</p>
							<b style="padding:20px"> Minute:</b>
							<p id="minute"></p>
							<b>Second:</b>
							<br>
							<div style="display: inline-flex">
								<div id="second"></div>
								.<div id="millisecond"></div>
							</div>
						</div>
						<div class="box" style="border: 0px; padding:0px; margin:0px">
							<input type="button" id="addEvent" value="add Event"/>
							<input type="button" class="alert-success" id="changeEvent" value="Change" style="display: none;"/>
							<input type="button" class="alert-warning" id="cancelChangingEvent" value="Cancel" style="display: none; margin-left: 5px; margin-right: 5px"/>
							<input type="button" class="alert-danger" id="clearEvent" value="Delete" style="display: none"/>
						</div>
					</div>
				</div>
				
				<div class="alert alert-warning" style="padding: 2px; margin-top: 10px; margin-bottom: 0px; text-align: center"><h5>Your events</h5></div>
				<div class="alert panel-warning" style="margin-top: 0px; text-align: center">
					<h4 style="color: #8a6d3b">click on a row to change the event</h4>
					<table style="margin-bottom: 10px">
						<tbody id="capturedEvents">
							<tr>
								<th>Id</th>
								<th>Team</th>
								<th>Event</th>
								<th>Time</th>
							</tr>
						</tbody>
					</table>
					<input type="button" id="submit" value="Submit all Events"/>
				</div>
			</div>
		</div>
	</body>
</html>