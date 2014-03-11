//Global variable
var deleteBaseLoading = Array();

$(document).ready(function() {

	$('input[type=checkbox]').prop('checked', false);
	$('input[type=checkbox]').attr("disabled", false);
	
	$("input[type=checkbox]").each(function(){			 				
		if($(this).parent().parent().hasClass("success")){			
			$(this).attr("disabled", true);
		}
	});
	
	
	
	$("#add-base").click(function() {
	
		$("#alert-name-base").hide();
		$("#alert-empty-base").hide();
		var nameBase = $.trim($(this).parent().find("input").val());		
		$(this).parent().find("input").val("");
		var temp2= false;
		
		if(nameBase != ""){ //si el nombre no esta vacio
			//Verifica si la base ya existe 
			$('#list-bases tr').each(function () {			
				if(nameBase == $(this).find("td").eq(1).html()){
					temp2 = true;
				}			
			});
			
			if (!temp2){ //Si no existe la base se inserta
				
				$.post("/lildbi/bases/exist", {value : nameBase})
				.done(function(data) {
					if(data){ //Si la Base existe en el proveedor
						$.post('/lildbi/bases/add', {value : nameBase});
						
						$("#alert-base-exist").hide();
						$("#list-bases").removeAttr("style");
						
						var temp = "none";
						if($('.load').is(":visible")) {
							temp = "";
						}
								
						$("<tr style='display: none' class=''><td class='span1'><input type='checkbox'></td><td>" + nameBase + "</td><td class='load' style='display: " + temp + "; width:100%;'></td><td class='span1'><a id='delete-alert' style='margin-top: 7px;' class='btn'>X</a></td></tr>").appendTo("#list-bases tbody");
						$("#list-bases tr:last").show("slow");	
					}	
					else{
						$("#alert-empty-base").show();
					}
				});
			}
			else{ //Si existe ya la base entonces muestro la alerta
				$("#alert-name-base").show();
			}
		}		
		
	});
	
	$("#name-base").keypress(function(e) { //Cuando le doy enter al input con el nombre de la base		
		if(e.which==13){	
			$("#add-base").click();	
		}			
	});
	
	
	$(document).on("click", "#delete-alert", function(){				
				if(($(this).parent().parent().attr("class") == "") && ($(this).parent().prev().is(':hidden'))){					
					$.post('/lildbi/bases/delete', {value : $(this).parent().prev().prev().html()});
					$(this).parent().parent().hide('slow', function() {
						$(this).remove();
					});

					setTimeout(function() {
						if($('#list-bases').find("tr").length == 0){
							$("#list-bases").css("display", "none");
							$("#alert-base-exist").show();
						}
					}, 700);
						
				}
				else{
					$(this).parent().parent().attr("id", "x"); //Marcar el <tr> a eliminar una vez confirmado el Modal
					$("#modal-confirmation-delete").modal('show');	
				}				
	});
	
	//Cuando se oprime el boton Eliminar del Modal
	$('#delete-base').click(function() {	
		
				if($('#x').find(".load").is(':visible')){//Guardo el nombre de la base que detendra sus importaciones
					deleteBaseLoading.unshift($('#x').children().next().html());					
				}
		
				$.post('/lildbi/bases/delete', {value : $('#x').children().next().html()});
				
				 $('#x').hide("slow");	
				 
				 setTimeout(function() {					 
					$('#x').remove();					 
					$("#modal-confirmation-delete").modal('hide');
					if($('#list-bases').find("tr").length == 0){
						$("#list-bases").css("display", "none");
						$("#alert-base-exist").show();
					}
				 }, 700);
				 
				 if($(".progress").length == 0 ){
						$(".load").hide(1000);	
					}
	});
	
	
	
	//Close Modal
	$('#modal-confirmation-delete').live('hide', function(e) { //al ocultarse el modal
		$('#x').removeAttr("id");		
	});
	
	//Close alert
	$('.alert.alert-error .close').click(function(e) {
	    $(this).parent().hide();	   
	    return false;
	});
	
		
	//Importar
	$("#importar").click(function() {		
		
			var bases = Array();
			
		    if($('input[type=checkbox]:checked').val() !== undefined) {
		    	
		    	$(".load").show(1000);		    	
		    	$("input[type=checkbox]:checked").each(function(){	
					  //cada elemento seleccionado					
					if(!$(this).is("[disabled]")){
						bases.unshift($(this).parent().next().html());
						$("<div id='" + $(this).parent().next().html() + "' class='progress progress-striped active' style='margin-bottom: 10px; margin-top: 10px; height: 25px;'><div data-percentage='100' style='float: left; width: %;' class='bar'></div></div>").prependTo($(this).parent().next().next());
						$(this).attr("disabled", true);
					}
				}); 
		    }
		    
				var current_perc =  Array();
				
				//inicializo a 0 el porciento inicial de las bases a cargar
				$.each(bases, function(key, value) {	
					current_perc.unshift(0);				
				});
				
				var cont = 0;
				var temp = true;
				
				
				var progress = setInterval(function() {
																		
					if (verifyPercentages(current_perc)) {
						clearInterval(progress);
						$.post('/lildbi/bases/cleanSession', {value : bases});						
						
					} else if(temp) {
												
						temp = false;
						
						//Detengo la importacion de la Base que este en la lista, eliminandola de las otras listas
						if(deleteBaseLoading.length != 0){
							var pos;
							for (var i=0; i < deleteBaseLoading.length; i++)
							{
								pos = $.inArray(deleteBaseLoading[i], bases);
								bases.splice( pos, 1 );
								current_perc.splice( pos, 1 );								
							}
							
							deleteBaseLoading = Array();
						}
						
						$.post('/lildbi/bases/import', {
							value : bases, count: cont
						}, function(data) {
							
							temp = data;
							
							var arrayTotal = $.parseJSON(data);
							var fix;
							
							for (var i=0; i < current_perc.length; i++)
							{			
								if(current_perc[i] < 100){
									if((cont + 20) > arrayTotal[i]){
										current_perc[i] = 100;
										$("#" + bases[i]).parent().parent().animate({backgroundColor: "#dff0d8"}, 2000 );										
										$("#" + bases[i]).parent().prev().prev().children().attr('checked', false);
										$("#" + bases[i]).fadeOut(2000);
										$("#" + bases[i]).delay(300).queue(function(){
											$(this).remove();
											if($(".progress").length == 0 ){
												$(".load").hide(1000);	
											}																															
										});
										
										$("#" + bases[i]).parent().parent().delay(300).queue(function(){$(this).addClass('success');});										
																				
									}	
									else{
										current_perc[i] = (100*cont)/(arrayTotal[i]);
									}
								}								
								
								if(current_perc[i] < 1 ){									
									fix = current_perc[i].toFixed(2);									
								}
								else{
									fix = current_perc[i].toFixed(0);									
								}
								
								$("#" + bases[i] + " .bar").css('width', fix + '%');								
								$("#" + bases[i] + " .bar").text(fix + '%');	
							}
							
							cont = cont + 20;
							
						});
					}
				}, 1000);
				
				
	});	

	function verifyPercentages(current_perc){
		
		var cont = 0;
		
		$.each(current_perc, function(key, value) {	
			if(value >= 100){
				cont ++;
			}				
		});		
		
		if(cont == current_perc.length)
		{
			return true;
		}else{
			return false;
		}
	}

});
