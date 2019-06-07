<?php
	$movie_link = "../medium.mp4";//$_POST['movie'];
	$movie = ffmpeg($movie_link);

	return $movie->getFrameCount();

?>