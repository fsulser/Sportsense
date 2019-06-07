$(document).on('click', '#submit', function() {
	FinalEntries = new Array();
	var j = 0;
	//remove all empty rows from array
	for (var i = 0; i < Entries.length; i++) {
		if (Entries[i] != null) {
			FinalEntries[j] = Entries[i];
			j++;
		}
	}
	if (FinalEntries.length == 0) {
		$('body').after('<div class="background"></div><div class="overlay alert-warning"><h2>Are you sure there are no events in the sequence? <br> If you miss any you will not get paid</h2><div style="text-align:center"> <input type="button" value="YES" onclick="sendValues()" style="margin: 10px"/><input type="button" value="NO" onclick="cancelSubmit()"></div></div>');
	} else {
		$('body').after('<div class="background"></div><div class="overlay alert-warning"><h2>Are you sure you want to send these events? <br> If they are incorrect or you miss any you will not get paid.</h2><div style="text-align:center"> <input type="button" value="Send" onclick="sendValues()" style="margin: 10px"/><input type="button" value="Edit" onclick="cancelSubmit()"></div></div>');
	}
});

// ajax function to send the entered event values
function sendValues() {
	if (basic == 'basic') {
		var url = 'php/Basic/SubmitBasic.php';
	} else {
		var url = 'php/Standard/SubmitStandard.php';
	}

	$.ajax({
		url : url,
		type : 'POST',
		dataType : 'json',
		data : {
			data : JSON.stringify(FinalEntries)
		},
		success : function(data) {
			if (data.success == 1) {
				if(basic == 'basic'){
					if(data.rating >= -1){
						window.location = 'Info.php?text= Thank you for doing this Tasks. <br>Your Token for Microworkers is:&title= Finished Task&display=success';
					}else{
						window.location = 'Info.php?text= Thank you for doing this Tasks. <br>We are sorry, but you will not receive your token. Your answers have been to bad. &title= Finished Task&display=warning';
					}
				}else{
					window.location = 'Info.php?text= Thank you for doing this Tasks. <br>Your Token for Microworkers is:&title= Finished Task&display=success';
				}
			} else {
				if(data.success==3){
					$('.overlay').empty();
					$('.overlay').append("<h3>You have entered impossible values. Please check them and send again.</h3><br><input type='button' value='OK' onclick='cancelSubmit()'>");
				}else{
					window.location = 'Info.php?title=ERROR&text=Coulnd\'t enter your events.&display=warning';
				}
			}
		},
		error : function(data) {
			$('.overlay').empty();
			$('.overlay').append("<h3>An error with you're network connection occured.<br> Please try to send again.</h3><br><input type='button' value='OK' onclick='cancelSubmit()'>");
		}
	});
}

function cancelSubmit() {
	$('.overlay').remove();
	$('.background').remove();
}
