var data = [];

$(document).on('click', '.nav a[href="#rate"]', function() {
	emptyAll();
	$.ajax({
		url : 'php/GetCampaigns.php',
		type : 'POST',
		async : false,
		dataType : 'json',
		success : function(data) {
			if (data.success != 0) {
				if (data.success == 2) {
					window.location = 'Login.php';
				} else {
					if(data.length!=0){
						for(i=0; i<data.length; i++){
							if(data[i].finished==0){
								$('#rate').append('<div class="panel alert-info campaigns" id="'+data[i].CampaignId+'"><p>'+ data[i].home +' - '+data[i].away+'</p>\
								<p>Not finished</p>\
								<p>Total tasks: '+data[i].number+' </p>\
								<p>Tasks finished: '+data[i].finishedNumber+'</p>\
								</div>');
							}else{
								$('#rate').append('<div class="panel alert-success campaigns" id="'+data[i].CampaignId+'"><p>'+ data[i].home +' - '+data[i].away+'</p>\
								<p>Finished</p>\
								<p>Total tasks: '+data[i].number+' </p>\
								<p>Tasks finished: '+data[i].finishedNumber+'</p>\
								</div>');
							}
						}
					}else{
						$('#rate').append('<p>No campaigns have been created</p>');
					}
				}
			} else {
				$(this).append('<div class="alert alert-danger">' + data.error_msg + '</div>');
			}
		},
		error : function(data) {
			$('#login_outer').empty();
			$('#login_outer').append("<h3>An error with you're network connection occured.<br> Please try to send again.</h3><br><input type='button' value='OK' onclick='cancelSubmit()'>");
		}
	});
});


$(document).on('click','.campaigns', function(){
	id = this.id;
	emptyAll();
	$.ajax({
		url : 'php/GetTasks.php',
		type : 'POST',
		async : false,
		dataType : 'json',
		data : {
			id: id
		},
		success : function(JSONdata) {
			if (data.success != 0) {
				if (data.success == 2) {
					window.location = 'Login.php';
				} else {
					data = JSONdata;
					addData();
				}
			} else {
				$('#rate').append('<div class="alert alert-danger">' + data.error_msg + '</div>');
			}
		},
		error : function(data) {
			$('#login_outer').empty();
			$('#login_outer').append("<h3>An error with you're network connection occured.<br> Please try to send again.</h3><br><input type='button' value='OK' onclick='cancelSubmit()'>");
		}
	});
});

function addData(){
	if(data.length==0){
		$('#rate').append('<p>No tasks found</p>');
	}
	j=0;
	for( i=0; i<data.length; i++){
		if($('#Task_'+data[i].TaskId).length>0){
			if (data[i].EventRating == null) {
				$('#Task_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>null</p></tr>');
			} else {
				$('#Task_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>' + data[i].EventRating + '</p></td></tr>');
			}
		}else{
			$('#rate').append('<div class="panel panel-success" id="TaskContainer_'+j+'" style="display: none"><div class="panel-heading">TaskId: ' + data[i].TaskId + '<br>SequenceStart: ' + secondsToTime(data[i].sequenceStart) + '<br> missed: '+data[i].missed+ '<br> token: ' + data[i].token + '<br>Rating:<p><b>' + data[i].TaskRating + '</b></p></div><div class="panel_body">\
			<table class="table table-striped" id="Task_' + data[i].TaskId + '"><tr class="row"><th>EventId</th><th>Event</th><th>Time</th><th>Team</th><th>TeamId</th><th>Point</th><th>Rating</th></tr></table></div></div>');
			var length = +data[i].sequenceStart + +data[i].videoLength;
			if (data[i].Event == null) {
				$('#Task_' + data[i].TaskId).append('<tr class="row"><td>no events</td></tr>');
			} else {
				if (data[i].EventRating == null) {
					$('#Task_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>null</p></td></tr>');
				} else {
					$('#Task_' + data[i].TaskId).append('<tr class="row"><td>' + data[i].type_id + '</td><td>' + data[i].Event + '</td><td>' + data[i].min + ':' + data[i].sec + '.' + data[i].msec + '</td><td>' + data[i].team + '</td><td>' + data[i].team_id + '</td><td>' + data[i].trackedPointX + ',' + data[i].trackedPointY + '</td><td><p>' + data[i].EventRating + '</p></td></tr>');
				}
			}
			j++;
		}
	}
	
	appendPageNumber();
}

function showData(index){
	$('.pages').removeClass('alert-danger');
	$('#pageNumber_'+index).addClass('alert-danger');
	index = parseInt(index);
	$('#rate').find('.panel').hide();
	for(i =index*6; i<index*6+6; i++){
		$('#TaskContainer_'+i).show();
	}
}



function appendPageNumber(){
	number = $('#rate').children().length;
	if(number==0){
		$('#rate').empty();
		$('#rate').append('<div style="text-align: center;"> No Tasks</div>');
	}else{
		pageNumber = Math.ceil(number/6)-1;
		$('#rate').append('<div id="PageNumbers" style="text-align: center;"></div>');
	
		for(i=0;i<=pageNumber; i++){
			$('#PageNumbers').append('<input type="button" class="pages" id="pageNumber_'+i+'" value="'+i+'" />');
		}
		showData(0);
	}
}

$(document).on('click', '.pages', function(){
	index = $(this).attr('id');
	index = index.slice(index.indexOf('_')+1, index.length);
	showData(index);
});
