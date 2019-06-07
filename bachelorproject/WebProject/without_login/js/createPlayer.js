window.onload = function() {
	$.unblockUI();
	finishedLoading = true;
};
//video that is shown
var video = $('#VideoElement').get(0);
//get the position of the actual frame
var image0 = 0;
//contains the number of frames per seconds
var framesPerSecond = 10;
//to loop trought the video to create frames-images
var frameTime = 0;

//load start time from database. It's the time where the sequence should start
var startTime = startTime.toFixed(0);
var sequenceLength = snippetLength.toFixed(0);
var sequenceEnd = +startTime + +sequenceLength;

//set the video file source to both video-elements
video.src = videoSource;

var finishedLoading=false;

video.addEventListener("error", function(err) {
	$('body').empty();
	$('body').append("<div class='alert-danger' style='font-size:30px'>Sorry you can't do this Task, because you can't play the video. <br> Try to download the newest version of your browser or try an other one which is able to play mp4 videos with html5.</div>");
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
	var w = 67;
	var h = video.videoHeight / video.videoWidth * 67;
	$('.frames').width(w);
	$('.frames').height(h);
	$('.eventPictures').height(h);
	$('.eventPictures').width(w);
	video.currentTime = startTime;
	displayCurrentTime();
	displayCurrentImages();
});

function displayCurrentImages() {
	for (var i = -3; i <= 3; i++) {
		var img = $('#imgdiv' + i).get(0);
		if (imageArray[+i + +image0+1] != undefined) {
			img.style.background = '#00ff00';
			img.style.backgroundImage = 'url(' + imageArray[+i + +image0+1].src + ')';
		} else {
			img.style.background = '#000000';
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

	return minutes + ":" + seconds.toFixed(2);
}

function resetToStartTime() {
	$.unblockUI();
	video.currentTime = startTime;
}

function updateTime(time) {
	var minutes = time.slice(0, time.indexOf(":"));
	var time = time.slice(time.indexOf(":"));
	var seconds = time.slice(1, time.indexOf("."));
	var milliseconds = time.slice(time.indexOf(".") + 1);

	$('#minute').text(minutes);
	$('#second').text(seconds);
	$('#millisecond').text(milliseconds);
	updateText();
}

function updateText() {
	var time = video.currentTime;
	if (time < startTime) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence hasn\'t startet yet. Use The controllers to move forward or backward to your sequence.');
		addOverlayToInput();
	} else if (time >= startTime & time <= sequenceEnd) {
		$('#videoText').removeClass('alert-danger');
		$('#videoText').addClass('alert-success');
		$('#videoText').text('You are inside the sequence to tag.');
		removeOverlayFromInput();
	} else if (time > sequenceEnd) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence has finished. Use The controllers to move forward or backward to your sequence.');
		addOverlayToInput();
	}
}

function addOverlayToInput() {
	$('#timeoverlay').remove();
	$('#eventFrame').hide();
	$('#eventFrame').before('<div id="timeoverlay" style="text-align:center;" class="alert-warning"> <h3> Your task starts at:</h3><p>' + secondsToTime(startTime) + '</p><h3> and ends at:</h3><p>' + secondsToTime(sequenceEnd) + '</p></div>');
}

function removeOverlayFromInput() {
	$('#timeoverlay').remove();
	$('#eventFrame').show();
}

document.addEventListener('keydown', function(e) {
	if(finishedLoading){
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
	}
});

