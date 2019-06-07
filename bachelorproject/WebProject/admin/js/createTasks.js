$(document).on('click', '#createTasks', function() {
	$('.alert').remove();
	var start = $('#start').val();
	if (start == '') {
		$('#start').after('<div class="alert alert-danger">Please enter a value</div>');
	}
	var number = $('#number').val();
	if (number == '') {
		$('#number').after('<div class="alert alert-danger">Please enter a value</div>');
	}
	var video = $('#VideoId option:selected').val();

	$.ajax({
		url : 'php/CreateTask.php',
		type : 'POST',
		dataType : 'json',
		data : {
			video : video,
			start : start,
			number : number
		},
		success : function(data) {
			if (data.success == 1) {
				$('#createTasks').after('<div class="alert alert-success">Tasks have been createt</div>');
			} else {
				if (data.success == 2) {
					window.location = 'Login.php';
				} else {
					$('#createTasks').after('<div class="alert alert-danger">' + data.error_msg + '</div>');
				}
			}
		},
		error : function(data) {
			$('#createTasks').after('<div class="alert alert-danger">Failed to connect. Please check your connection.</div>');
		}
	});

});
