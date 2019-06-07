$(document).on('click', '#searchTask', function() {
});

$(document).on('click', '#searchForTask', function() {
	emptyAll();
	var token = $('#TaskToken').val();

	if (token == null) {
		$('#TaskToken').after('<div class="alert alert-danger"><p>Please enter a token</p></div>');
	} else {
		$.ajax({
			url : 'php/getTaskFromToken.php',
			type : 'POST',
			dataType : 'json',
			data : {
				token : token
			},
			success : function(data) {
				if (data.success != 0) {
					if (data.success == 2) {
						window.location = 'Login.php';
					} else {

						if (data.length != 0) {
							$('#searchResults').append('<div class="panel panel-success"><div class="panel-heading">TaskId: ' + data[0].TaskId + '<br>SequenceStart: ' + secondsToTime(data[0].sequenceStart) +'<br> missed: '+data[0].missed+  '<br>Rating:<b>' + data[0].TaskRating + '</b></div><div class="panel_body">\
							<table class="table table-striped" id="TaskToken_' + data[0].TaskId + '"><tr class="row"><th>EventId</th><th>Event</th><th>Time</th><th>Team</th><th>TeamId</th><th>Point</th><th>Rating</th></tr></table></div></div>');
							for (var i = 0; i < data.length; i++) {
								if (data[i].Event == null) {
									$('#TaskToken_' + data[i].TaskId).append('<tr class="row"><td>no events</td></tr>');
								} else {
									if (data[i].EventRating == null) {
										$('#TaskToken_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>null</p></td></tr>');
									} else {
										$('#TaskToken_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>' + data[i].EventRating + '</p></td></tr>');
									}
								}
							}
						} else {
							$('#searchResults').append('<div class="alert alert-danger">No task found for token</div>');
						}
					}
				} else {
					$(this).append('<div class="alert alert-danger">' + data.error_msg + '</div>');
				}
			},
			error : function(data) {
				alert('Check your intenert connection');
			}
		});
	}
});

function emptyAll() {
	$('#searchResults').empty();
	$('#rate').empty();
}

function secondsToTime(actualTime) {
	var minutes = Math.floor(actualTime / 60);
	var seconds = actualTime - minutes * 60;

	return minutes + ":" + seconds.toFixed(2);
}
