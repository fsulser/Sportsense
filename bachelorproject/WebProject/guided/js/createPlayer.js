window.onload = function() {
	//if all images are loaded from the server and the movie is ready remove wait overlay
	$.unblockUI();
	$("* [rel='tooltip']").tooltip({
		html: true, 
		placement: 'bottom'
	});
	
};

//video that is shown
var video = $('#VideoElement').get(0);
//set the position of the actual frame to 0
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
// videoOverlay.src = videoSource;

var finishedLoading=false;
var startedTask = false;

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
	$('#start').text(secondsToTime(startTime));
	$('#end').text(secondsToTime(sequenceEnd));
	video.currentTime = startTime;
	getImages();
	displayCurrentTime();
	displayCurrentImages();
});

//set the right images to the image extension unde the video player, if no more images set background black
function displayCurrentImages() {
	for (var i = -3; i <= 3; i++) {
		var img = $('#imgdiv' + i).get(0);
		var imgNumber = parseInt(i) + parseInt(image0 +1);
		if (imgNumber <=51 && imgNumber >0) {
			img.style.background = '#00ff00';
			if(imgNumber<10){
				img.style.backgroundImage = "url('tmp/"+token+"/out0"+ imgNumber +".png')";
			}else{
				img.style.backgroundImage = "url('tmp/"+token+"/out"+ imgNumber +".png')";
			}
		} else {
			img.style.background = '#000000';
			img.style.backgroundImage = '';
		}
	}
}

// used if a user clicks on an image to change the position of the video 
$('.frames').on("click", function(e) {
	//pause the video
	video.pause();
	//get the image id to evaluate the actual position
	var id = $(this).attr('id');
	id = id.slice(6);

	image0 = +image0 + +id;
	
	//change the time of the video
	var actualTime = video.currentTime;
	actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond).toFixed(2);

	video.currentTime = (+actualTime + +id / framesPerSecond).toFixed(2);
	displayCurrentTime();
	displayCurrentImages();
});

//function to show the time under the video player
function displayCurrentTime() {
	var actualTime = secondsToTime(video.currentTime);
	$('#currentTime').text(actualTime);
	updateTime(actualTime);
}
//calculate time out of seconds
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

// if video time is outside sequence remove the input frame and overlay it with a warning
function updateText() {
	var time = video.currentTime;
	if (time < startTime) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence hasn\'t startet yet. Use The controllers to move forward or backward to your sequence.');
		removeAddButton();
	} else if (time >= startTime & time <= sequenceEnd) {
		$('#videoText').removeClass('alert-danger');
		$('#videoText').addClass('alert-success');
		$('#videoText').text('You are inside the sequence to tag.');
		addAddButton();
	} else if (time > sequenceEnd) {
		$('#videoText').removeClass('alert-success');
		$('#videoText').addClass('alert-danger');
		$('#videoText').text('Your sequence has finished. Use The controllers to move forward or backward to your sequence.');
		removeAddButton();
	}
}

// read input frame
function addAddButton(){
	if($('.Teams').css('display')=='none' && $('.Field').css('display')=='none'){
		$('.Events').show();
		$('.Out').hide();
		$('#titles').removeClass('alert-warning');
	}
}

//remove input frame
function removeAddButton(){
	$('#titles').addClass('alert-warning');
	$('.Teams').hide();
	$('.Events').hide();
	$('.Field').hide();
	$('.overlay').remove();
	$('.Out').show();
	$('.background').remove();
	$('#FieldPoint').remove();
}

function removeWarning(){
	$('.overlay1').remove();
}

//to handle the keyboard inputs we override the standard keyboard events.
document.addEventListener('keydown', function(e) {
	if(finishedLoading && startedTask){
		// space bar pressed to start and stop the move
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
	
			video.currentTime = (+actualTime + -1 / framesPerSecond).toFixed(2);
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
	
			video.currentTime = (+actualTime + +1 / framesPerSecond).toFixed(2);
			displayCurrentTime();
			displayCurrentImages();
		}
	}
});

//load all images from the server to an imagearray
function getImages(){
	imageArray = new Array();
	for(var i=1; i<=51; i++){
		imageArray[i] = new Image();
		if(i<10){
			imageArray[i].src = "tmp/"+token+"/out0" + i + ".png";
		}else{
			imageArray[i].src = "tmp/"+token+"/out" + i + ".png";
		}
	}
}

