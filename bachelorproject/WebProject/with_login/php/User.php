<?php
session_start();
if (isset($_POST['tag']) && isset($_POST['mail']) && isset($_POST['pw'])) {
	$Login = new LoginClass();
} else {
	$arr = array('success' => 0, 'error_msg' => 'Access denied');
	echo json_encode($arr);
}
class LoginClass {

	private static $mail;
	private static $pw;
	private static $tag;
	private static $encyptedPW;
	private static $DB;

	function LoginClass() {
		self::$DB = require ('config.php');
		self::$mail = $_POST['mail'];
		self::$pw = $_POST['pw'];
		self::$tag = $_POST['tag'];
		self::$encyptedPW = $this -> encrypt(self::$pw);
		if (self::$tag == 'register') {
			$this -> register();
		} elseif (self::$tag == 'login') {
			$this -> login();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Access denied');
			echo json_encode($arr);
		}
	}

	function register() {
		if ($this -> checkIfEmailNotExists()) {
			if ($this -> createUser()) {
				if ($this -> selectUserId()) {
				}
			}
		}
	}

	function login() {
		if ($this -> checklogin()) {
		}
	}

	function createUser() {
		$sql = 'INSERT INTO Users value(0, "' . self::$mail . '", "' . self::$encyptedPW . '", 5)';
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			return true;
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t create new User');
			echo json_encode($arr);
			return false;
		}
	}

	function selectUserId() {
		$sql1 = 'SELECT UID, userRating FROM Users WHERE userEmail="' . self::$mail . '"';
		$stmt1 = self::$DB -> prepare($sql1);
		if ($stmt1 -> execute()) {
			$stmt1 = $stmt1 -> fetch();
			$this -> createSession($stmt1);
			return true;
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t login as new User');
			echo json_encode($arr);
			return false;
		}
	}

	function createSession($stmt) {
		$_SESSION['UID'] = $stmt['UID'];
		$_SESSION['Mail'] = self::$mail;
		$arr = array('success' => 1, 'error_msg' => '', 'rating' => $stmt['userRating']);
		echo json_encode($arr);
	}

	function checkLogin() {
		$sql = 'SELECT userRating, userPassword, UID FROM Users WHERE userEmail="' . self::$mail . '"';
		$stmt = self::$DB -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() != 0) {
			$stmt = $stmt -> fetch();
			if ($this -> checkPassword($stmt)) {
				if ($this -> checkRating($stmt)) {
					$this -> createSession($stmt);
				}
			}
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Email doesn\'t exist');
			echo json_encode($arr);
			return false;
		}
	}

	function checkPassword($stmt) {
		if (self::$encyptedPW == $stmt['userPassword']) {
			return true;
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Wrong password');
			echo json_encode($arr);
			return false;
		}
	}

	function checkRating($stmt) {
		if (floatval($stmt['userRating']) > floatval(0)) {
			return true;
		} else {
			$arr = array('success' => 2, 'error_msg' => 'Failed.php?title=Rating&text=Your Rating is too bad, you can\'t do any more tasks');
			echo json_encode($arr);
			return false;
		}
	}

	function encrypt($password) {
		return hash("sha512", $password);
	}

	function checkIfEmailNotExists() {
		$sql = 'SELECT * FROM Users WHERE userEmail="' . self::$mail . '"';
		$stmt = self::$DB -> query($sql);
		if ($stmt -> rowCount() == 0) {
			return true;
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Email already exists');
			echo json_encode($arr);
			return false;
		}
	}

}
?>