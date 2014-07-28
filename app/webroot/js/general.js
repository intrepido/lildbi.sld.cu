$(document).ready(function() {
	
	if(window.nodeConnection != undefined){	
		var socket = io.connect('http://'+ window.nodeConnection['host'] +':'+ window.nodeConnection['port'] +'');
	    
	    $.post('/users/getUserLogged/', function(data) {   //Actualizar Socket ID		
			if(data){   			
				 socket.emit('updateSocketIdUser', {username: data});
			}
		});
	}
    
   /* var interval = null;
      interval = setInterval(function() { //Verifico si el usuario esta logueado	    	
    	$.post('/users/verifySessionUser/', function(data) {    		
    		if(data){//Si no lo esta logueado entonces lo quito del servidor de Node para que se elimine de la lista de los otros usuario    			
    			socket.emit('disconnectUser', {username: data});
    			stop();
    		}
    	});
	}, 30000);
    
    function stop() {
        clearTimeout(interval);
    };*/

	////Falta arreglar cuando no tiene mas perfiles
	$("#change-profile").click(function() {
		
		if( $('#profiles').find("li").length == 0 && $('#profiles').find("p").length == 0 ){
			//Obtengo el nombre de usuario y su rol del menu a la derecha
			var element = $('.navbar-form.pull-right p').text().split(':');
			var rol = $.trim(element[0]);
			var username = $.trim(element[1]);
			
			$.post('/users/listRolUser', {
				username : username
			}, function(data) {	
				
				
				var rols = $.parseJSON(data);
				//alert("hola");
				var temp= true;
				
				 $.each(rols, function(i, item){			
					 if(item['name'] != rol){
						 if(temp){						
							 temp = false;
						 }		
						 //alert(item['name']);
						 $('#profiles').append( "<li><a href='/rols/changeRol/" + item['name'] + "'>" + item['name'] + "</a></li>" );	
					 }			 		 
				 });
				 
				 if(temp){
					 $('#profiles').append( "<p style='margin-left: 10px; margin-bottom: 0px;'>	No tiene otros perfiles...</p>" );
				 }
				
			});
		}		
		
	});
	
	//Change idioms
	$("#idioms a").click(function() {    	
		$.post('/', {
			language : $(this).attr('id')
		}, function(data) {	
			location.reload();
		});		
	}); 
	
	
    $(".onoffswitch input").change(function() {
    	
    	//alert("hola");
    	$.post('/admin/maintenance/');
    	/*if($(this).checked()) { 
    		$(this).prop('checked', true);
        }	
    	else{
    		$(this).prop('checked', false);
    	}*/
	});  

});
