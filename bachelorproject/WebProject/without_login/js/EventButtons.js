$(document).on('click', '#clearEvent', function() {
	delete Entries[rowIndex];
	$('#tr_'+rowIndex).empty();
	showDefault();
});

$(document).on('click', '#cancelChangingEvent', function(){
	showDefault();
});

$(document).on('click', '#changeEvent', function(){
	//remove old warnings
	$('.popup').remove();
	
	var gameEvent = $('#Events option:selected').text();
	var EventId = $('#Events option:selected').val();
	//check if Event is selected
	if (EventId == '--') {
		$('#Events').after('<div class="alert-danger popup" style="padding:5px; margin-top:10px; margin-bottom:3px">Please select an Event</div>');
	} else {
		//check if Team is selected
		var team = $('#Team option:selected').val();
		if (team == '--') {
			$('#Team').after('<div class="alert-danger popup" style="padding:5px; margin-top:10px; margin-bottom:3px">Please select a Team</div>');
		} else {
			if(video.currentTime < startTime){
				$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>This event is outside your task! <br> Please select only events that are in your task</h2><div style="text-align:center"> <input type="button" value="NO" onclick="cancelSubmit()"></div></div>');
			}else if(video.currentTime > +startTime + +snippetLength){
				$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>This event is outside your task! <br> Please select only events that are in your task</h2><div style="text-align:center"> <input type="button" value="NO" onclick="cancelSubmit()"></div></div>');
			}else{
				var minutes = $('#minute').text();
				var seconds = $('#second').text();
				var milliseconds = $('#millisecond').text();
				$('#changeEvent').hide();
				$('#clearEvent').hide();
				$('#addEvent').show();
				updateObject(timeToSeconds(minutes, seconds, milliseconds), gameEvent, EventId, team);
				showDefault();
			}
		}
	}
});

function updateObject(time, gameEvent, eventId, team){
	Entries[rowIndex].Team = team;
	Entries[rowIndex].GameEvent = gameEvent;
	Entries[rowIndex].EventId = eventId;
	Entries[rowIndex].Time = time;
	updateList(time, gameEvent, team);
}

function updateList(time, gameEvent, team){
	$('#tr_'+rowIndex).empty();
	$('#tr_'+rowIndex).append('<td>'+ rowIndex + '</td><td>' + team + '</td><td>' + gameEvent + '</td><td>' + secondsToTime(time)  +'</td>');
}


function showDefault(){
	$('.info').hide();
	$('.popup').hide();
	$('#capturedEvents > tr').removeClass('alert-info');
	$('#Events').val('--');
	$('#Team').val('--');
	$('#eventInformation').remove();
	$('.background1').remove();
	$('#cancelChangingEvent').hide();
	$('#clearEvent').hide();
	$('#changeEvent').hide();
	$('#addEvent').show();
}
