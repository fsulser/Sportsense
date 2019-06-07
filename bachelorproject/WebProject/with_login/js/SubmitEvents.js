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
		$('#outerBox').after('<div class="background"></div><div id="login_outer" class="alert-warning popup"><h2>Are you sure you want to send these Informations? <br> If they are incorrect you won\'t get payed.</h2><div style="text-align:center"> <input type="button" value="send" onclick="sendValues()" style="margin: 10px"/><input type="button" value="Edit" onclick="cancelSubmit()"></div></div>');
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
				var endTime = new Date();
				var tasktime = endTime.getSeconds() - startTime.getSeconds();
				window.location = 'Failed.php?text= Thank you for doing this Tasks. We will check your Inputs as soon as possible and send you the tokens in a mail. Your time was '+ tasktime +'&title= Task is finished&display=success';
			} else {
				alert('failed to inser values');
			}
		},
		error : function(data) {
			//TODO change to resubmit
			alert('failed to inser values');
		}
	});
}

function cancelSubmit(){
	$('#login_outer').remove();
	$('.background').remove();
}
