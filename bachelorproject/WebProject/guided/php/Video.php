<?php
class Video {
	public static $DB, $home, $away, $homeColor, $awayColor, $sequence, $sequenceLength, $VideoSrc;
	//get informations about the video
	function Video($stmt) {
		self::$DB =
		require ('Connect.php');
		//check weather user is doing a pretest or a standard task
		if ($_SESSION['Task'] == 'basic') {
			$this -> getBasicVideoInformations();
		} else {
			$this -> getStandardVideoInformations($stmt);
		}
		$this -> createImages();
	}

	function getBasicVideoInformations() {
		//get all necessary informations about the video for a pretest in the task. Those are: hometeam, awayteam, homecolo, awaycolor, link, sequencestart, sequencelength
		$sql = 'SELECT (SELECT TeamName FROM Teams WHERE TeamId=v.homeTeam)AS homeTeam, (SELECT TeamName FROM Teams WHERE TeamId=v.awayTeam)AS awayTeam, v.link, v.homeColor, v.awayColor, c.start AS sequence, c.sequenceLength FROM VideoInformations v, campaign c WHERE v.VideoId = c.VideoId and c.CampaignId=1 LIMIT 1';
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$row = $stmt -> fetch();
			self::$home = $row['homeTeam'];
			self::$away = $row['awayTeam'];
			self::$homeColor = $row['homeColor'];
			self::$awayColor = $row['awayColor'];
			self::$sequence = $row['sequence'];
			self::$sequenceLength = $row['sequenceLength'];
			self::$VideoSrc = $row['link'];
		} else {
			header('Location: ' . 'Info.php?title=Failed to get Video Information &text=We couldn\'t get your task information. Please try again from Microworkers. &display=warnings');
		}
	}

	function getStandardVideoInformations($result) {
		//get all necessary informations about the video for standard task. Those are: hometeam, awayteam, homecolor, awaycolor, link, sequenceLength
		$sql = 'SELECT v.link, v.homeColor, v.awayColor, c.sequenceLength, (SELECT TeamName FROM Teams WHERE TeamId = v.homeTeam)AS homeTeam, (SELECT TeamName FROM Teams WHERE TeamId= v.awayTeam)AS awayTeam FROM VideoInformations v, Task t, campaign c WHERE v.VideoId = c.VideoId AND c.CampaignId=t.CampaignId AND t.TaskId='.$result['TaskId'].' LIMIT 1';
		self::$sequence = $result['sequenceStart'];
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			$row = $stmt -> fetch();
			self::$home = $row['homeTeam'];
			self::$away = $row['awayTeam'];
			self::$homeColor = $row['homeColor'];
			self::$awayColor = $row['awayColor'];
			self::$sequenceLength = $row['sequenceLength'];
			self::$VideoSrc = $row['link'];
		} else {
			header('Location: ' . 'Info.php?title=Failed to get Video Information &text=We couldn\'t get your task information. Please try again from Microworkers. &display=warnings');
		}

	}

	function createImages() {
		//create the images with ffmpeg by using the unix command line.
		$size = '92*49';
		$framesPerSecond = 10;
		//create folder by token containing the images
		$filePath = 'tmp/' . $_SESSION['token'] . '/out%2d.png';
		//manipulate values to get correct images from ffmpeg
		$length = self::$sequenceLength + 0.001;
		$start = self::$sequence + 0.25;
		$cmd = 'ffmpeg -ss ' . $start . ' -t ' . $length . ' -i ' . self::$VideoSrc . ' -s ' . $size . ' -r ' . $framesPerSecond . ' ' . $filePath;

		exec('rm -rf tmp/' . $_SESSION['token']);
		exec('mkdir tmp/' . $_SESSION['token']);

		exec($cmd);
	}

}
?>