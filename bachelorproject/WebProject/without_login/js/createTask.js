function createTask() {
	$.ajax({
		url : 'php/CreateTask.php?campaign='+campaign +'&worker='+worker,
		dataType : 'json',
		success : function(data) {
			if (data.success == 1) {
				$('#login_outer').remove(); 
				$('.background').remove();
			} else {
				window.location = 'Failed.php?title=No more Tasks&text=There are actually no more Tasks to do..&display=warning';
			}
		},error : function(data){
			window.location = 'Failed.php?title=No more Tasks&text=There are actually no more Tasks to do.&display=warning';
		}
	});
}
