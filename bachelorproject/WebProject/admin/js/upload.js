$(document).on('click', '#newTeam', function() {
	$(this).hide();
	$('#newTeam_panel').append('<p>Enter team name:</p><input type="text" id="newTeam_text"/>  <input class="alert-info" type="button" value="create new Team" id="newTeam_create"/>');
});

$(document).on('click', '#newTeam_create', function() {
	$('.info').remove();
	$.ajax({
		url : 'php/createTeam.php',
		type : 'POST',
		dataType : 'json',
		data : {
			teamName : $('#newTeam_text').val()
		},
		success : function(data) {
			if (data.success == 1) {
				$('#newTeam_panel').append('<p class="alert-success info" style="padding: 10px; margin: 10px">' + data.error_msg + '</p>');
				refreshList();
			} else {
				$('#newTeam_panel').append('<p class="alert-danger info" style="padding: 10px; margin: 10px">' + data.error_msg + '</p>');
				refreshList();
			}
		},
		error : function(data) {
			$('#newTeam_panel').append('<p class="alert-danger info" style="padding: 10px; margin: 10px">' + data.error_msg + '</p>');
		}
	});
});

function refreshList() {
	$('select[name="home"]').empty();
	$('select[name="away"]').empty();
	$.ajax({
		url : 'php/selectTeams.php',
		type : 'POST',
		dataType : 'json',
		success : function(data) {
			$('select[name="home"]').append('<option value="--">Home Team</option>');
			$('select[name="away"]').append('<option value="--">Away Team</option>');
			for ( i = 0; i < data.length; i++) {
				$('select[name="home"]').append('<option value="' + data[i].TeamId + '">' + data[i].TeamName + '</option>');
				$('select[name="away"]').append('<option value="' + data[i].TeamId + '">' + data[i].TeamName + '</option>');
			}
		},
		error : function(data) {
			$('#newTeam_panel').append('<p class="alert-danger info" style="padding: 10px; margin: 10px">' + data.error_msg + '</p>');
		}
	});
}


$(document).on('click', '#upload_video', function() {
	$('.info').remove();
	
	if(checkValues()){
   		$('#progress').show();
		var control = document.getElementById("fileSelector");
		
		var url = "php/upload.php"; // the script where you handle the form input.
		var form = new FormData();
		form.append("homeColor", $('#homeColor').val());
		form.append("awayColor", $('#awayColor').val());
		form.append("home", $('select[name="home"] option:selected').val());
		form.append("away", $('select[name="away"] option:selected').val());
		form.append("video", control.files[0]);
		
		// send via XHR - look ma, no headers being set!
		var xhr = new XMLHttpRequest();
		xhr.addEventListener("progress", updateProgress, false);
		xhr.addEventListener("error", transferFailed, false);
		xhr.addEventListener("abort", transferCanceled, false);
		xhr.onload = function() {
			$('#progress').hide();
			var jsonResponse = JSON.parse(xhr.responseText);
			if(jsonResponse.success==1){
				$('#upload_video').after('<p class="alert-success info" style="padding: 30px; margin:10px">File has been uploaded and new Video was created.</p>');
			}else{
				$('#upload_video').after('<p class="alert-danger info" style="padding: 30px; margin:10px">'+jsonResponse.error_msg+'</p>');
			}
		};
		xhr.open("post", url, true);
		xhr.send(form);
	}
	
	function updateProgress (oEvent) {
		if (oEvent.lengthComputable) {
    		var percentComplete = oEvent.loaded / oEvent.total;
    		$('#progress').show();
		} else {
    		$('#progress').show();
		}
	}
	
	function transferFailed(evt) {
		$('#upload_video').after('<p class="alert-danger info" style="padding: 30px; margin:10px">An error occurred while transferring the file.</p>');
	}
	
	function transferCanceled(evt) {
	  alert("The transfer has been canceled by the user.");
	}


});

function checkValues() {
	if ($('select[name="home"] option:selected').val() == "--") {
		$('select[name="home"]').after('<p class="alert-danger info" style="padding: 10px; margin:10px">Please select a home team.</p>');
		return false;
	} else {
		if ($('select[name="away"] option:selected').val() == "--") {
			$('select[name="away"]').after('<p class="alert-danger info" style="padding: 10px; margin:10px">Please select a away team.</p>');
			return false;
		} else {
			if (!$('#homeColor').val()) {
				$('#homeColor').after('<p class="alert-danger info" style="padding: 10px; margin:10px">Please enter a value for the home team color.</p>');
				return false;
			} else {
				if (!$('#awayColor').val()) {
					$('#awayColor').after('<p class="alert-danger info" style="padding: 10px; margin:10px">Please enter a value for the aways team color.</p>');
					return false;
				} else {
					if ($('select[name="home"] option:selected').val() == $('select[name="away"] option:selected').val()) {
						$('#upload_video').before('<p class="alert-danger info" style="padding: 10px; margin:10px">Home and away team can not be the same.</p>');
					} else {
						if(document.getElementById("fileSelector").value){
							return true;
						}else{
							$('#upload_video').before('<p class="alert-danger info" style="padding: 10px; margin:10px">Please select a video file.</p>');
							return false;
						}
					}
				}
			}
		}
	}

}


// function progressHandlingFunction(e){
// if(e.lengthComputable){
// $('progress').attr({value:e.loaded,max:e.total});
// }
// }