$(document).ready(function() {
	Entries = new Array();
	var minutes;
	var seconds;
	var milliseconds;
	var team;
	var gameEvent;
	var EventId;
	var entryIndex = 1;

	$('#addEvent').on('click', function() {
		$('#change').hide();
		//remove old warnings
		$('.popup').remove();

		gameEvent = $('#Events option:selected').text();
		EventId = $('#Events option:selected').val();
		//check if Event is selected
		if (EventId == '--') {
			$('#Events').after('<div class="alert-danger popup" style="padding:5px; margin-top:10px; margin-bottom:3px">Please select an Event</div>');
		} else {
			//check if Team is selected
			team = $('#Team option:selected').val();
			if (team == '--') {
				$('#Team').after('<div class="alert-danger popup" style="padding:5px; margin-top:10px; margin-bottom:3px">Please select a Team</div>');
			} else {
				if(video.currentTime < startTime){
					$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>This event is outside your task! <br> Please select only events that are in your task</h2><div style="text-align:center"> <input type="button" value="NO" onclick="cancelSubmit()"></div></div>');
				}else if(video.currentTime > +startTime + +snippetLength){
					$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>This event is outside your task! <br> Please select only events that are in your task</h2><div style="text-align:center"> <input type="button" value="NO" onclick="cancelSubmit()"></div></div>');
				}else{
					minutes = $('#minute').text();
					seconds = $('#second').text();
					milliseconds = $('#millisecond').text();
					submitEntry();
				}
			}
		}

	});

	function submitEntry() {
		var actualEntry = new Object();
		var time = timeToSeconds(minutes, seconds, milliseconds);
		actualEntry.Time = time;
		actualEntry.Team = team;
		actualEntry.GameEvent = gameEvent;
		actualEntry.EventId = EventId;
		Entries[entryIndex] = actualEntry;
		$('#capturedEvents').append('<tr id="tr_'+entryIndex+'"><td>'+ entryIndex + '</td><td>' + team + '</td><td>' + gameEvent + '</td><td>' + secondsToTime(time) +'</td></tr>');
		entryIndex++;
		$('#Events').val('--');
		$('#Team').val('--');
	}

});

function timeToSeconds(minutes, seconds, milliseconds) {
	return +seconds + +(minutes * 60) + +milliseconds / 100;
}
