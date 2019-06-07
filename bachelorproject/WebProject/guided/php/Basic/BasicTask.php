<?php

	class BasicTask{

		function BasicTask(){
			$this->createTask();
		}
		
		function createTask(){
			//get the video Informations for the basic task
			include 'php/Video.php';
			new Video(null);
		}
		
	}

?>