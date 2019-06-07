<?php
class LoginClass {
	private static $DB;

	function LoginClass() {
		self::$DB =
		require ('Connect.php');
		$this -> checkIfUserExists();
	}

	function checkIfUserExists() {
		//check if user with microworkers id already exists in database
		$sql = "SELECT UID, finishedBasic FROM Users WHERE microworkersId='" . $_SESSION['worker'] . "'";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			if ($stmt -> rowCount() == 1) {
				$this -> createSession($stmt);
			} elseif ($stmt -> rowCount() == 0) {
				//if it do not already exists create a new database entry
				$this -> createUser();
			} else {
				header('Location: ' . 'Info.php?title=Database Error&text= An error with your account occured in the database. &display=dangers');
			}
		} else {
			header('Location: ' . 'Info.php?title=Error&text=We couldn\'t get your account information. &display=danger');
		}
	}

	function createUser() {
		// Creat new Users with: UID, microworkersId, finishedBasic, userRating
		$sql = "INSERT INTO Users values(0, '" . $_SESSION['worker'] . "', 0, null, 0)";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> checkIfUserExists();
		} else {
			header('Location: ' . 'Info.php?title=Error&text=We couldn\'t get your account information. &display=danger');
		}
	}

	function createSession($stmt) {
		//create the php session
		$stmt = $stmt -> fetch();
		if ($stmt['finishedBasic'] == 0) {
			$_SESSION['Task'] = 'basic';
		} else {
			$_SESSION['Task'] = 'standard';
		}
		$_SESSION['UID'] = $stmt['UID'];
		new GenerateValues();
	}

}

class GenerateValues {
	private static $DB;

	function GenerateValues() {
		self::$DB =
		require 'Connect.php';
		if ($this -> checkCampaignFirstTime()) {
			if ($this -> checkRating()) {
				$this -> generateToke();
			}
		}
	}

	function generateToke() {
		//generate the token provided by microworkers and saving it in a session variable.
		$My_secret_key = '7ac67acc9451904dae80d6b532a3cb0ee9471029859914e8a9cfdff4a3ddcd0a';
		$FinalString = $_SESSION['campaign'] . $_SESSION['worker'] . $My_secret_key;

		$vcode_for_proof = "mw-" . hash('sha256', $FinalString);

		$_SESSION['token'] = $vcode_for_proof;
	}

	function checkCampaignFirstTime() {
		//cehck if a user is doing this campaign for the first time or if he has already finished the campaign, because users can only do one task per campaign by microworkers
		$sql = "SELECT TaskId FROM Task WHERE campaign='" . $_SESSION['campaign'] . "' AND UID='" . $_SESSION['UID'] . "'";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			if ($stmt -> rowCount() == 0) {
				return true;
			} else {
				//if he has already participated the campaign, link him to other page
				header('Location: ' . 'Info.php?title=Task Already Finished&text=You have already finished this task. Due to the paying of Microworkers it is not possible to do a task twice. &display=task');
				return false;
			}
		} else {
			header('Location: ' . 'Info.php?title=Failed&text=Couldn\'t connect to server &display=danger');
			return false;
		}
	}

	function checkRating() {
		//check if rating is not to small, otherwise user will not be able to do more taks
		$sql = "SELECT userRating FROM Users WHERE UID=" . $_SESSION['UID'];
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			if ($stmt -> rowCount() == 1) {
				$stmt = $stmt -> fetch();
				//check if rating of user is smaller than -1.5
				if ($stmt['userRating'] <= -1.5) {
					header('Location: ' . 'Info.php?title=Rating&text=Your Rating is too bad, you can\'t do any more tasks&display=danger');
				} else{
					//check if userrating is bigger than -1 if. if not user will receive a warning
					if ($stmt['userRating'] <= -1) {
						echo '<div class="background3"></div><div class="overlay3 alert-warning"><h3>Your rating is bad</h3><b>If your tasks won\'t get better you won\'t be able to do more tasks</b><br><br><input type="button" value="OK" onclick="$(\'.overlay3\').remove(); $(\'.background3\').remove();"/></div>';
						return true;
					}else{
						return true;
					}
				}
			} else {
				header('Location: ' . 'Info.php?title=Error&text=Your account does not exists or there was en error in the database. &display=danger');
			}
		} else {
			header('Location: ' . 'Info.php?title=Error&text=We couldn\'t get your account information. &display=danger');
		}
	}

}
?>