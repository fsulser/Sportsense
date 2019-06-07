//video that is shown
var video = $('#VideoElement').get(0);
//get the position of the actual frame
var image0 = 1;
//contains the number of frames per seconds
var framesPerSecond = 10;
//to loop trought the video to create frames-images
var frameTime = 0;

//load start time from database. It's the time where the sequence should start
var startTime = startTime.toFixed(0);
var sequenceLength = snippetLength.toFixed(0);

//set the video file source to both video-elements
video.src = videoSource;
//video.load();

video.addEventListener("error", function(err) {
	$('body').empty();
	$('body').append("<div class='alert-danger' style='font-size:30px'>Sorry you can't do this Task, because you can't play the video. <br> Try to download the newwest version of <a href='https://www.google.com/intl/de/chrome/browser/'>Google Chrome</a> and check again if it works.</div>");
}, false);

//video add eventlistener for pause click. To recalculate the shown images.
video.addEventListener('pause', function() {
	var actualTime = video.currentTime;
	actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond);
	actualTime = actualTime - startTime;
	image0 = actualTime.toFixed(2) * framesPerSecond;

	displayCurrentTime();
	displayCurrentImages();
});

//set the start time of the video in background
video.addEventListener('loadedmetadata', function() {
	// $.blockUI({
		// message : '<h1> Please Wait until Video is loaded</h1>'
	// });
	var w = 67;
	var h = video.videoHeight / video.videoWidth * 67;
	$('.frames').width(w);
	$('.frames').height(h);
	$('.eventPictures').height(h);
	$('.eventPictures').width(w);
	video.currentTime = startTime;
	displayCurrentImages();
});

function displayCurrentImages() {
	for (var i = -3; i <= 3; i++) {
		var img = $('#imgdiv' + i).get(0);
		if (imageArray[+i + +image0] != undefined) {
			img.style.backgroundImage = 'url(' +imageArray[+i + +image0].src +')';
		} else {
			img.style.backgroundImage = '';
		}
	}
}


$('.frames').on("click", function(e) {
	video.pause();
	var id = $(this).attr('id');

	id = id.slice(6);

	image0 = +image0 + +id;

	var actualTime = video.currentTime;
	actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond).toFixed(2);

	video.currentTime = +actualTime + +id / framesPerSecond;
	displayCurrentTime();
	displayCurrentImages();
});

function displayCurrentTime() {

	var actualTime = secondsToTime(video.currentTime);
	$('#currentTime').text(actualTime);
	updateTime(actualTime);
}

function secondsToTime(actualTime) {
	actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond);
	var minutes = Math.floor(actualTime / 60);
	var seconds = actualTime - minutes * 60;

	return minutes + " : " + seconds.toFixed(2);
}

function resetToStartTime() {
	$.unblockUI();
	video.currentTime = startTime;
}

function updateTime(time) {
	var minutes = time.slice(0, time.indexOf(":") - 1);
	var time = time.slice(time.indexOf(":") + 1);
	var seconds = time.slice(1, time.indexOf("."));
	var milliseconds = time.slice(time.indexOf(".") + 1);

	$('#minute').text(minutes);
	$('#second').text(seconds);
	$('#millisecond').text(milliseconds);
	updateText();
}

function updateText() {
	var time = video.currentTime;
	var sequenceEnd = +startTime + +sequenceLength;
	if (time < startTime) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence hasen\'t started');
	} else if (time >= startTime & time <= sequenceEnd) {
		$('#videoText').removeClass('alert-danger');
		$('#videoText').addClass('alert-success');
		$('#videoText').text('Your inside your sequence');
	} else if (time > sequenceEnd) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence is finished');
	}
}

document.addEventListener('keydown', function(e) {
	if (e.keyCode == 32) {
		e.preventDefault();
		if (video.paused) {
			video.play();
		} else {
			video.pause();
		}
	}
	//left arrow key is pressed (keycode==37)
	if (e.keyCode == 37) {
		e.preventDefault();
		video.pause();
		image0 = +image0 - 1;

		var actualTime = video.currentTime;
		actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond).toFixed(2);

		video.currentTime = +actualTime + -1 / framesPerSecond;
		displayCurrentTime();
		displayCurrentImages();
	}
	//right arrow key is pressed (keycode==39)
	if (e.keyCode == 39) {
		e.preventDefault();
		video.pause();
		image0 = +image0 + 1;

		var actualTime = video.currentTime;
		actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond).toFixed(2);

		video.currentTime = +actualTime + +1 / framesPerSecond;
		displayCurrentTime();
		displayCurrentImages();
	}
});

