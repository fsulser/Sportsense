$(document).on('click', '#capturedEvents > tr', function() {
	//get the index of the entered and clicked event
	rowIndex = this.rowIndex;
	//adding warning panel
	if(rowIndex != 0){
		$('#eventFrame').prepend('<div class="alert-warning info" style="padding:5px; margin-bottom:5px" id="eventInformation"><p>You are changing <b>'+ rowIndex +'.</b> Event!<p></div>');
		$('.popup').remove();
		$(document.body).append('<div class="background1"> </div>');
		$(this).addClass('alert-info');
		//hide submit button and show new ones
		$('#addEvent').hide();
		$('#changeEvent').show();
		$('#clearEvent').show();
		$('#cancelChangingEvent').show();
		//update the panel with the entered and clicked data
		updateTime(secondsToTime(Entries[rowIndex].Time));
		$('#Events').val(Entries[rowIndex].EventId);
		$('#Team').val(Entries[rowIndex].Team);
		
		video.currentTime = Entries[rowIndex].Time;
		var actualTime = Entries[rowIndex].Time;
		actualTime = (Math.round(actualTime * framesPerSecond) / framesPerSecond);
		actualTime = actualTime - startTime;
		image0 = actualTime.toFixed(2) * framesPerSecond;

		displayCurrentTime();
		displayCurrentImages();
	}
});

