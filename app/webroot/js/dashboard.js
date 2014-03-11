$(document).ready(function() {

	$.post('/lildbi/onlineUsers/index/').done(function(data){			
		var usersList = $.parseJSON(data);				
		$.each(usersList, function(key, value) {
			$.post('/lildbi/onlineUsers/setTimeOnline/', {user : value}).done(function(data2){	
				$("#list-user-online").append("<div'><a class='pull-left' href='#'><i class='icon-user'></i></a><div class='media-body'><a id='user-online-" + value['OnlineUser']['id'] + "' data-html='true' data-placement='right' data-toggle='tooltip' href='/lildbi/users/view/" + value['OnlineUser']['user_id'] + "' data-original-title='' data-trigger='manual'>" + value['OnlineUser']['username'] + "</a><div id='time-online' class='pull-right''><p class='muted'><small>" + data2 + "</small></p></div></div></div>");								
			});	
		});	
		
		$("#list-user-online").fadeIn(1000);
	});
	
	
	
	setInterval(function() {
		$.post('/lildbi/onlineUsers/index/').done(function(data){			
			var usersList = $.parseJSON(data);
			
			//Remuevo los usuarios que ya no esten conectados y actualizo el tiempo online de los que siguen conectados
			var temp1 = false;
			$( "#list-user-online .media-body" ).each(function(index){
								
				var user = $(this);
				var visualUserName = $.trim($(this).find('a').text());
				var userForSetTime = null;
				
				$.each(usersList, function(key, value){						
					if(visualUserName == value['OnlineUser']['username']){	
						temp1 = true;
						userForSetTime = value;
					}					
				});
				
				if(!temp1){				
					$(this).parent().fadeOut(1000, function(){ $(this).remove();});					
				}
				else{
					//le pongo el tiempo que lleva conectado					
					$.post('/lildbi/onlineUsers/setTimeOnline/', {user : userForSetTime}, function(data2){						
						user.find('#time-online').html("<p class='muted'><small>" + data2 + "</small></p>");				
					});						
				}
				
				temp1 = false;
			});	
			
		    //Adiciono nuevos usuarios conectados a la lista
			var temp2 = false;
			$.each(usersList, function(key, value) {	
				
				$( "#list-user-online .media-body" ).each(function( index ) {
					if(value['OnlineUser']['username'] == $.trim($(this).find('a').text())){
						temp2 = true;
					}								
				});
				
				if(!temp2){					
					$("#list-user-online").append("<div style='display: none'><a class='pull-left' href='#'><i class='icon-user'></i></a><div class='media-body'><a id='user-online-" + value['OnlineUser']['id'] + "' data-html='true' data-placement='right' data-toggle='tooltip' href='/lildbi/users/view/" + value['OnlineUser']['user_id'] + "' data-original-title='' data-trigger='manual'>" + value['OnlineUser']['username'] + "</a><div id='time-online' class='pull-right''></div></div></div>");
					$("#list-user-online :last-child").fadeIn(1000);
				}
				
				temp2 = false;
			});
			
		});				
	}, 6000);
	
		
	
	$(document).on("mouseover", "[id^='user-online']", function(){
		var id = $(this).attr('id');
		var element = $(this);
						
		$.post('/lildbi/onlineUsers/view/', {id : id.replace('user-online-', '')}).done(function(data){	
			var user = $.parseJSON(data);			
			var text = "<table><tbody align='left'><tr><td><strong>Ip:</strong>&nbsp;&nbsp;<em>" + user['OnlineUser']['ip'] + "</em></td></tr><tr><td><strong>Rol actual:</strong>&nbsp;&nbsp;<em>" + user['OnlineUser']['current_rol'] + "</em></td></tr><tr><td><strong>Hora de Inicio: </strong>&nbsp;&nbsp;<em>" + user['OnlineUser']['date'] + "</em></td></tr></tbody></table>";			
			element.attr('data-original-title', text);				
			element.tooltip('show');
		});
	});
	
	$(document).on("mouseout", "[id^='user-online']", function(){
		$(this).tooltip('hide');
	});
	
	
	/*
	$(document).on("mouseover", "[id^='user-online']", function(){
		var id = $(this).attr('id');
		var element = $(this);
		
		$.post('/lildbi/onlineUsers/view/', {id : id.replace('user-online-', '')}).done(function(data){		
						
			var user = $.parseJSON(data);			
			var text = "<dl class='dl-horizontal'><dt style='width: 110px;'>Ip:</dt> <dd style='margin-left: 125px;'>" + user['OnlineUser']['ip'] + "</dd><dt style='width: 110px;'>Rol actual:</dt><dd style='margin-left: 125px;'>" + user['OnlineUser']['current_rol'] + "</dd><dt style='width: 110px;'>Hora de Inicio: </dt><dd style='margin-left: 125px;'>" + user['OnlineUser']['date'] + "</dd></dl>";	
			element.popover('show');
			$(".popover-content").append(text);
			$(".arrow").attr('style', "top: 28px;");
		});	
		
	});
	
	$(document).on("mouseout", "[id^='user-online']", function(){
		$(this).popover('hide');
	});*/
});
