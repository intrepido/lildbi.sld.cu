$(document).ready(function() {

	$("#loginConfirmButton button[type='submit']").addClass("btn btn-primary");
	$("#loginConfirmButton .control-group").css("margin-bottom", '20px');
	$("#loginConfirmButton .control-group").css("padding-right", '5px');

	$("#loginCancelButton button[type='button']").addClass("btn");
	$("#loginCancelButton").parent().css("padding-bottom", '21px');	
	$("#loginCancelButton button[type='button']").click(function() {
		$(location).attr("href", "/lildbi");
	});

});
