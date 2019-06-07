<?php
	session_start();
	if(isset($_POST['user']) && isset($_POST['pw'])) {
		$Login = new Login();
	} else {
		$arr = array('success' => 0, 'error_msg' => 'Access denied');
		echo json_encode($arr);
	}

	Class Login{
		
		private static $User;
		private static $pw;
		private static $DB;
		
		function Login(){
			self::$DB = require ('config.php');
			self::$User = $_POST['user'];
			self::$pw = $this->encrypt($_POST['pw']);
			$this->checkUser();
		}

		function checkUser(){
			$sql = "Select * from Admin where AdminName='".self::$User."' AND AdminPW='".self::$pw."'";
			$stmt = self::$DB -> prepare($sql);
			if($stmt->execute()){
				if($stmt->rowCount()==1){
					$this->createSession($stmt->fetch());
				}else{
					$arr = array('success' => 0, 'error_msg' => 'Wrong password or username!');
					echo json_encode($arr);
				}
			}else{
				$arr = array('success' => 0, 'error_msg' => 'Failed to execute query');
				echo json_encode($arr);
			}
		}
		
		function createSession($stmt){
			$_SESSION['AdminId'] = $stmt['AdminId'];
			$arr = array('success' => 1, 'error_msg' => '');
			echo json_encode($arr);
		}
		
		function encrypt($password) {
			return hash("sha512", $password);
		}
	}

?>