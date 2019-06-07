$(document).on('click', '#submit', function() {
	FinalEntries = new Array();
	var j = 0;
	for (var i = 1; i < Entries.length; i++) {
		if (Entries[i] != null) {
			FinalEntries[j] = Entries[i];
			j++;
		}
	}
	if(FinalEntries.length == 0){
		$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>Are you sure there are no actions in the sequence? <br> If they are some you won\'t get payed</h2><div style="text-align:center"> <input type="button" value="YES" onclick="sendValues()" style="margin: 10px"/><input type="button" value="NO" onclick="cancelSubmit()"></div></div>');		
	}else{
		$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>Are you sure you want to send these Informations? <br> If they are incorrect you won\'t get payed.</h2><div style="text-align:center"> <input type="button" value="Send" onclick="sendValues()" style="margin: 10px"/><input type="button" value="Edit" onclick="cancelSubmit()"></div></div>');
	}
});

function sendValues(){
	$.ajax({
		url : 'php/Submit.php',
		type : 'POST',
		dataType : 'json',
		data : {
			data : JSON.stringify(FinalEntries)
		},
		success : function(data) {
			if (data.success == 1) {
				window.location = 'Failed.php?text= Thank you for doing this Tasks.&title= Finished Task&display=success';
			} else {
				window.location = 'Failed.php?title=ERROR&text=Coulnd\'t enter your events.&display=warning';
			}
		},
		error : function(data) {
			$('#login_outer').empty();
			$('#login_outer').append("<h3>An error with you're network connection occured.<br> Please try to send again.</h3><br><input type='button' value='OK' onclick='cancelSubmit()'>");
		}
	});
}

function cancelSubmit(){
	$('#login_outer').remove();
	$('.background').remove();
}
