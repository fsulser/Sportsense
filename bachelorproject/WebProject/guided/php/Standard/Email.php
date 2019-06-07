<?php
class Email{
	function Email($success, $type, $id){
		$this->send($success, $type, $id);
	}
	function send($success, $type, $id){
		$text='';
		$header='';
		//email containing the receivers email adress
		$email = 'fabio.sulser@stud.unibas.ch';
		//$from containing a virtual email adress
		$from = 'info@sportsense.cloudapp.net';
		
		if($success == 'success'){
			$header = "New entered data";
			$text = "Calculated new base and rating for campaign with id=".$id;
		}else{
			$header = "Failed to enter data";
			$text = "Failed to ".$type.", for campaign with id=".$id;
		}
		
		
		require_once ("../extensions/Mail/class.phpmailer.php");

		$mail = new PHPMailer();
		
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->Host     = "localhost"; // SMTP server
		
		$mail->From     = "info@sportsense.cloudapp.net";
		$mail->AddAddress($email);
		
		$mail->Subject  = $header;
		$mail->Body     = $text;
		$mail->WordWrap = 50;
		
		$mail->Send();
	}
}
?>