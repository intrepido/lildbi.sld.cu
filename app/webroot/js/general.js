$(document).ready(function() {

	////Falta arreglar cuando no tiene mas perfiles
	$("#change-profile").click(function() {
		
		if( $('#profiles').find("li").length == 0 && $('#profiles').find("p").length == 0 ){
			//Obtengo el nombre de usuario y su rol del menu a la derecha
			var element = $('.navbar-form.pull-right p').text().split(':');
			var rol = $.trim(element[0]);
			var username = $.trim(element[1]);
			
			$.post('/lildbi/users/listRolUser', {
				username : username
			}, function(data) {	
				
				
				var roles = $.parseJSON(data);
				//alert("hola");
				var temp= true;
				
				 $.each(roles, function(i, item){			
					 if(item['name'] != rol){
						 if(temp){						
							 temp = false;
						 }		
						 //alert(item['name']);
						 $('#profiles').append( "<li><a href='/lildbi/rols/changeRol/" + item['name'] + "'>" + item['name'] + "</a></li>" );	
					 }			 		 
				 });
				 
				 if(temp){
					 $('#profiles').append( "<p style='margin-left: 10px; margin-bottom: 0px;'>	No tiene otros perfiles...</p>" );
				 }
				
			});
		}		
		
	});
	
	
    $(".onoffswitch input").change(function() {
    	
    	//alert("hola");
    	$.post('/lildbi/admin/maintenance/');
    	/*if($(this).checked()) { 
    		$(this).prop('checked', true);
        }	
    	else{
    		$(this).prop('checked', false);
    	}*/
	});


});
