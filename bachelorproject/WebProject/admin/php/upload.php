<?php
	header("Content-Type: application/json");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	$target_path = "../../guided/videos/";

	$target_path = $target_path . basename( $_FILES['video']['name']);
	
	
	if (($_FILES["video"]["type"] == "video/avi")|| ($_FILES["video"]["type"] == "video/quicktime")
	|| ($_FILES["video"]["type"] == "video/mpeg")|| ($_FILES["video"]["type"] == "video/x-matroska")
	|| ($_FILES["video"]["type"] == "video/mp4")|| ($_FILES["video"]["type"] == "video/x-ms-wmv")
	|| ($_FILES["video"]["type"] == "video/ogg")|| ($_FILES["video"]["type"] == "video/x-flv")
	|| ($_FILES["video"]["type"] == "video/webm")|| ($_FILES["video"]["type"] == "video/mov")){
		if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
			createInformations();
		} else{
			$arr = array('success' => 0, 'error_msg' => 'There was an error uploading the file.');
			echo json_encode($arr);
		}
		
	}else{
		$arr = array('success' => 0, 'error_msg' => 'The added file is not a video.');
		echo json_encode($arr);
	}


	function createInformations(){
		$sql = "INSERT INTO VideoInformations VALUES(0, 'videos/".$_FILES['video']['name']."',".$_POST['home'].",".$_POST['away'].",'".$_POST['homeColor']."','".$_POST['awayColor']."',0,1000)";
		require ('config.php');
		$stmt = $DB->prepare($sql);
		if($stmt->execute()){
			$arr = array('success' => 1, 'error_msg' => 'Created new video file.');
			echo json_encode($arr);
		}else{
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t create new VideoInformations.');
			echo json_encode($arr);
		}
	}
		
?>