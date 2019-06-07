$(document).on('click', '#loginUser', function() {
	$('.popup').remove();
	var user = $('#login_user').val();
	var pw = $('#login_pw').val();
	$.ajax({
		url : 'php/Login.php',
		type : 'POST',
		dataType : 'json',
		data : {
			user : user,
			pw : pw,
		},
		success : function(data) {
			if (data.success == 1) {
				window.location= 'Index.php';
			} else {
				$('#login_pw').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px"><p>' + data.error_msg + '</p></div>');
			}
		},
		error : function(data) {
			$('#login_pw').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px"><p>' + data + '</p></div>');
		}
	});

});

function loginSucceeded() {
	window.location = 'Task.php';
}

function showWarning() {
	$('#login_outer').empty();
	$('#login_outer').append('<div class="alert-warning popup" style="width: 100%; height:100%"><h2 style="margin-top:100px">Your Rating is bad if you\'re Answers won\'t get better your not able to do any more Jobs </h2> <input type="button" value="OK" style="margin-top:40px" onclick="loginSucceeded()"/></div>');
}