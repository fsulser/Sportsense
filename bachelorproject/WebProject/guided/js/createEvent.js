var entryIndex = 0;
Entries = new Array();
var actualEntry;

//remove event layer and save entered event, show team layer
$(document).on('click', '.EventOpt', function() {
	checkValue();
	$('.EventOpt').tooltip('toggle');
	actualEntry = new Object();
	var id = this.id.slice(this.id.indexOf('_') + 1, this.id.length);
	
	actualEntry.GameEvent = $(this).text();
	actualEntry.EventId = id;

	$('.Events').slideUp('slow');
	$('.Teams').slideDown('slow');
});

//remove team layer and save entered team, show position layer
$(document).on('click', '.teamOpt', function(){
	var id = this.id.slice(this.id.indexOf('_')+1, this.id.length);
	actualEntry.Team = id;
	
	$('.popup').remove();
	$('.Teams').slideUp('slow');
	$('.Field').slideDown('slow');
});

//on add event click
$(document).on('click', '#addImagePoint', function(){
	if ($("#FieldPoint").length > 0){
		actualEntry.Time = video.currentTime;
		//calculate the relative position from the users entered position
		var posY = parseFloat($('#FieldPoint').css('top').slice(0, $('#FieldPoint').css('top').length-2))+20;
		var posX = parseFloat($('#FieldPoint').css('left').slice(0, $('#FieldPoint').css('left').length-2))+20;
		var width = $('#FieldImage').width();
		var height = $('#FieldImage').height();
		posX = (posX * 664/width).toFixed(2);
		posY = (posY * 445/height).toFixed(2);
		actualEntry.Position = posX +' '+posY;
		//add new entered value to table containing all entered events
		Entries.push(actualEntry);
		entryIndex++;
		refreshList();
		$('#FieldPoint').remove();
		$('.Field').hide();
		
		$('body').append('<div class="background"></div><div class="overlay alert-warning"><h2>Event has been added.</h2><b>There might be more events in your sequence. Please check it and add them. </b><br><br><input type="button" value="OK" onclick="continueEntering();"/></div>');
		$('.Events').show();
	}else{
		$('#addImagePoint').after('<div class="alert alert-danger popup"> Please set the point</div>');
	}
});

//catch users click on field and add yellow point.
$(document).on('click', '#FieldImage', function(e){
	$('#FieldPoint').remove();
	var posX = $(this).offset().left;
	var posY = $(this).offset().top;
	var left = (e.pageX - posX)-20;
	var top = (e.pageY - posY)-20;
	$('#FieldImage').append('<div id="FieldPoint" style="border: 3px solid yellow; width: 40px; height: 40px; border-radius:100%; position: absolute; top: '+top+'px; left:'+left+'px;"><div style="width: 8px; height: 8px; border-radius: 100%; background-color: yellow;  position: relative; top: 13px; left:13px;"></div></div>');
});

//if user clicks a second time on the field to change his point and clicks inside the border off the point check that he can not set the point outside of the image
$(document).on('click', '#FieldPoint', function(e){
	e.stopPropagation();
	var width = $('#FieldImage').width();
	var height = $('#FieldImage').height();
	var posX = $('#FieldImage').offset().left;
	var posY = $('#FieldImage').offset().top;
	var left = (e.pageX - posX)-20;
	var top = (e.pageY - posY)-20;
	if(parseFloat(left)<=width-20){
		if(parseFloat(left)>=-20){
			if(parseFloat(top)>=-20){
				if(parseFloat(top)<=height-20){
					$('#FieldPoint').remove();
					$('#FieldImage').append('<div id="FieldPoint" style="border: 3px solid yellow; width: 40px; height: 40px; border-radius:100%; position: absolute; top: '+top+'px; left:'+left+'px;"><div style="width: 8px; height: 8px; border-radius: 100%; background-color: yellow;  position: relative; top: 13px; left:13px;"></div></div>');
				}
			}
		}
	}
});

//delete an added event
$(document).on('click', '.removeIndex', function(){
	id = this.id.slice(this.id.indexOf('_')+1, this.id.length);
	Entries.splice(parseInt(id), 1);
 	refreshList();
});

$(document).on('click', '.cancelAdding', function(){
	resetToDefault();
});

//update list after adding or removing an event
function refreshList(){
	$('#capturedEvents').empty();
	for(var i=0; i<Entries.length; i++){
		if(Entries[i]!=null){
			$('#capturedEvents').append('<tr id="tr_'+i+'" class="row" style="text-align: left;"><td>'+ i + '</td><td>' + Entries[i].Team + '</td><td>' + Entries[i].GameEvent + '</td><td>' + secondsToTime(Entries[i].Time) +'</td><td>'+Entries[i].Position+'</td><td><img src="images/remove.png" class="removeIndex" id="RemoveObject_'+i+'"/></td></tr>');
		}
	}
}

//check if entered value is in sequence
function checkValue(){
	for(var i =0; i< Entries.length; i++){
		if(Entries[i].Time == video.currentTime){
			showWarning('<h2>You have already added an event at this time.</h2> <b>Are you sure there is a second one at the same time?</b>');
		}
	}
}

function showWarning(text){
	finishedLoading = false;
	$('body').append('<div class="background"></div><div class="overlay alert-warning">'+text+' <br><br><input type="button" value="YES" onclick="continueEntering();"/> <input type="button" value="NO" onclick="resetToDefault();"/></div>');
}

function resetToDefault(){
	finishedLoading = true;
	$('.Events').slideDown('fast');
	$('.Teams').slideUp('fast');
	$('.Field').slideUp('fast');
	$('.overlay').remove();
	$('.background').remove();
	$('#FieldPoint').remove();
}

function continueEntering(){
	finishedLoading = true;
	$('.background').remove();
	$('.overlay').remove();
}

