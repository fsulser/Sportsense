$(document).on('click', '#createUser', function() {
	$('.popup').remove();
	var mail = $('#create_mail').val();
	var pw = $('#create_pw').val();
	var pw1 = $('#create_pw_verification').val();
	if (pw.length < 6) {
		$('#create_pw').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px">Your password needs at least 6 characters</div>');
	} else if (!pw.match(/([0-9])/)) {
		$('#create_pw').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px">Your password needs to contain a number</div>');
	} else if (!pw.match(/([A-Z])/)) {
		$('#create_pw').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px">Your password needs an uppercase letter</div>');
	} else if (pw.localeCompare(pw1) != 0) {
		$('#create_pw_verification').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px">The two passwords are different</div>');
	} else {
		$.ajax({
			url : 'php/User.php',
			type : 'POST',
			dataType : 'json',
			data : {
				mail : mail,
				pw : pw,
				tag : 'register'
			},
			success : function(data) {
				if (data.success == 1) {
					loginSucceeded();
				} else if (data.success == 2) {
					window.location = data.error_msg;
				} else {
					$('#create_pw_verification').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px"><p>' + data.error_msg + '</p></div>');
				}
			},
			error : function(data) {
				console.log(data);
				$('#create_pw_verification').after('<div class="alert-danger popup" style="padding:5px; margin-top:30px; margin-bottom:3px"><p>' + data + '</p></div>');
			}
		});
	}
});

$(document).on('click', '#loginUser', function() {
	$('.popup').remove();
	var mail = $('#login_mail').val();
	var pw = $('#login_pw').val();
	$.ajax({
		url : 'php/User.php',
		type : 'POST',
		dataType : 'json',
		data : {
			mail : mail,
			pw : pw,
			tag : 'login'
		},
		success : function(data) {
			if (data.success == 1) {
				if (+data.rating < 3) {
					showWarning();
				} else {
					loginSucceeded();
				}
			} else if (data.success == 2) {
				window.location = data.error_msg;
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
	window.location = 'Task.php?campaign=' + campaign + '&worker=' + worker;
}

function showWarning() {
	$('#login_outer').empty();
	$('#login_outer').append('<div class="alert-warning popup" style="width: 100%; height:100%"><h2 style="margin-top:100px">Your Rating is bad if you\'re Answers won\'t get better your not able to do any more Jobs </h2> <input type="button" value="OK" style="margin-top:40px" onclick="loginSucceeded()"/></div>');
}

