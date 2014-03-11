$(document).ready(
		function() {
			
			$('#next').live(
					'click',
					function(e) {						
						$('html, body').stop().animate({
							scrollTop: $(this).parent().parent().nextAll('tr.info:first').offset().top - 75
						}, 1000);
					
					e.preventDefault();
			});
			
			$('#prev').live(
					'click',
					function() {
						$('html, body').stop().animate({							
							scrollTop: $(this).parent().parent().prevAll('tr.info:first').offset().top - 75
						}, 1000);
						
					return false;
					e.preventDefault();	
			});
			
			$('#top').live(
					'click',
					function() {
						$('html, body').animate({
							scrollTop: $(this).parent().parent().prevAll('tr.info:last').offset().top - 75
						}, 1000);
						
					return false;
					e.preventDefault();	
			});
			
			$('#bott').live(
					'click',
					function() {
						$('html, body').stop().animate({
							scrollTop: $(this).parent().parent().nextAll('tr.info:last').offset().top - 75
						}, 1000);
					
					e.preventDefault();	
			});
						
						
			
			$('#conditional-select').live(
					'change',
					function() {
													
						if($(this).find("option:selected").text().trim() == "Otro")
						{
							$(this).prev().css({"display" : "inline"});	
							$(this).before('<br/>');
							$(this).css({"left" : "25px"});	
						}
						else if($(this).prev().css("display") == "inline")
						{							
							$(this).prev().prev().css({"display" : "none"});
							$(this).prev().prev().val("");
							$(this).prev().remove();
							$(this).css({"left" : "0px"});
						}
			});

			
			// Add field
			$('.add-field').live(
					'click',
					function() {

						var nameOfAssistant = ($(this).parent().parent().next()
								.children().next().children().children().next()
								.children().children().first()).attr('id');

						var repeatingFieldOfAssistant = $(this).parent().parent()
								.next().children().next().children().first();

						var containerFieldOfAssistant = $(this).parent().parent().parent().find("[id = 'container-field']");								
						
						if ($("div[id~='repeating-field-" + nameOfAssistant
								+ "']").length == 0) {
							repeatingFieldOfAssistant.after("<hr/>");
							repeatingFieldOfAssistant.css({
								"margin-bottom" : "0px"
							});
						} else {
							$("div[id~='repeating-field-"
											+ nameOfAssistant + "']").last()
									.after("<hr/>");
							$("div[id~='repeating-field-"
											+ nameOfAssistant + "']").last()
									.css({
										"margin-bottom" : "0px"
									});
						}
												
						var repeatingFieldClone = repeatingFieldOfAssistant
								.clone();
											
						cleanField(repeatingFieldClone.children().next().children().children().children().children().children());	
						
						repeatingFieldClone.find("textarea").each(function(index) {								
							if($(this).css("display") == "inline")
							{								
								$(this).css({"display" : "none"})
								$(this).next().next().css({"left" : "0px"});
								$(this).next().remove();
							}							
						});	
						
						repeatingFieldClone.attr("id", "repeating-field-"
								+ nameOfAssistant);
						repeatingFieldClone.css({
							"margin-bottom" : "60px"
						});
						containerFieldOfAssistant.animate({
							scrollTop : containerFieldOfAssistant
									.prop("scrollHeight")
						}, 1000);
						repeatingFieldClone.fadeIn(2000).appendTo(
								containerFieldOfAssistant);

						return false;
			});

			
			// Fadeout selected item and remove
			$('.remove-field').live('click', function() {

				var field = $(this).parent().parent().parent();
				var fieldPrev = field.prev().prev();
				var nameOfAssistant = ($(this).parent().prev().children().first()).attr('id');				
				
				if ($("div[id~='repeating-field-" + nameOfAssistant
						+ "']").length > 1) { //si no es el unico
					field.fadeOut(1000, function() {
						if(!($(this).prev().is('hr'))){ //si el field que voy a eliminar es el primero
							$(this).next().remove(); //elimino el <hr> posterior al field
						}
						else{
							if (($(this).next('hr')).length == 0) { //si el field que voy a eliminar es el ultimo							
								fieldPrev.css({
									"margin-bottom" : "60px"
								});						
							}							
							$(this).prev().remove(); //elimino el <hr> previo al field
						}						
						$(this).remove(); //elimino el field
					});
				}
				else{ //si es el unico entonces limpio los datos de este					
					var field = $(this).parent().prev().children().children().children().children();			
					cleanField(field);
				}

				return false;
			});
			

			// Save field
			$('.save-field').live(
					'click',
					function() {
					
						var lengthResult = 0;
						var error = false;
						var result = "";						
						var field = $(this).parent().prev().children()
								.children().next().children().next().children()
								.children().next().children().children(); // <div id="v3">
												
						var titleAssistantComplete = $("#modal" + field.attr('id').substring(1)).children().find('h3').text();						
						var titleAssistant = titleAssistantComplete.substring(titleAssistantComplete.indexOf('-') + 1 ,titleAssistantComplete.length).trim();
						
						
						$("div[id~='repeating-field-" + field.attr('id') + "']").each(function(index) {
							$(this).find("div .input-prepend").children().each(function(index) { 
								if ($(this).is("span")) { // span								
									if ((($(this).parent().find("textarea").attr("value") != "") && (($(this).parent().find("textarea")).length != 0)) 
											|| (($(this).parent().find("select option:selected").text().trim() != "") 
												&& (($(this).parent().find("select")).length != 0) && ($(this).parent().find("select option:selected").text().trim() != "Otro") ) 
												|| $(this).parent().find("input").is(':checked') ) 
									{
										if ($(this).text() != '*') {
											result = result + "^" + $(this).text();
										}
									}
								} else if($(this).is("textarea")) { //textarea
									if ($(this).attr("value") != "") {
										result = result + $(this).attr("value").trim();										
									}else if($(this).is('[required]') && ($(this).css("display") != "none")){										
										error = true;
									}
								} else if($(this).is("select")){ //select
									if(($(this).find("option:selected").text().trim() != "Otro") && ($(this).find("option:selected").text().trim() != ""))
									{
										if($(this).parent().find("span").text() == 'i' || $(this).parent().find("span").text() == 'r'){											
											result = result + $(this).find("option:selected").val().trim();											
										}else{
											result = result + $(this).find("option:selected").text().trim();
										}																			
									}else if($(this).is('[required]') && ($(this).find("option:selected").text().trim() != "Otro")){											
									    error = true;
									}
								} else { //div que contiene el checkbox
									if($(this).find("input").is(':checked')){											
										result = result + $(this).find("input").val().trim();									
									}
								}
							});							
						
							if(result.length == lengthResult){								
								result = result.substr(0, result.length - 1); //elimina el ultimo caracter \n si el elemento repetido esta vacio									
							}
							if(($(this).next()).length > 0){								
								result = result + "\n"; //agrega \n al final si tiene otro elemento repetido, para separarlos
								lengthResult = result.length;
							} 
							
						});		
						
						if(error){//si faltan campos obligatorios por llenar							
							$(".alert.alert-error.fade.in").each(function(index) {
								$(this).show();
							});						
						}
						else
						{
							$(".alert.alert-error.fade.in").each(function(index) {
								$(this).hide();
							});	
							
							
							$("textarea[name='data[Document][" + field.attr('id') + "][" + titleAssistant + "]']").attr('value', result);
							$(this).parent().prev().prev().parent().modal('hide');	
						}						
						
						return false;
					});			
				
			
			//Edit field			
			$('.assistant').live(
					'click',
					function() {
						
						var containerFieldOfAssistant = $(this).next().find("#container-field");
						var repeatingFieldOfAssistant = $(this).next().find("div[id|='repeating-field']");						
						
						//Pongo los field que sean requeridos
						setObligatoryField(repeatingFieldOfAssistant.children().next().children().children().children().children().children());						
						
						var txt = $(this).parent().parent().parent().next().find('textarea').val();
						var arrayFields = txt.split('\n');
						
						$.each(arrayFields, function(key1, field) { //recorro cada field
														
							if(key1 > 0){ //si no es el primer field
								var repeatingFieldClone = repeatingFieldOfAssistant.clone();
								cleanField(repeatingFieldClone.children().next().children().children().children().children().children());	
								
								repeatingFieldClone.find("textarea").each(function(index) {								
									if($(this).css("display") == "inline")
									{								
										$(this).css({"display" : "none"})
										$(this).next().next().css({"left" : "0px"});
										$(this).next().remove();
									}							
								});	
								
								$("<hr/>").appendTo(containerFieldOfAssistant);
								repeatingFieldClone.appendTo(containerFieldOfAssistant);
								repeatingFieldOfAssistant = containerFieldOfAssistant.children().last();									
							}
							
							var arrayParts = field.split('^');
							
							$.each(arrayParts, function(key2, part) { //recorro cada parte del field								
								
								if(part.charAt(0) != ' ' && key2 == 0){									
									repeatingFieldOfAssistant.find("span:contains('*')").next().attr('value', part);
								}
								else if (part.charAt(0) != ' '){
									var field = repeatingFieldOfAssistant.find("span:contains(" + part.charAt(0) + ")").next();
									if(field.is("select") || field.next().is("select")){ //select
										var value;
										var temp = false;
										
										if(field.is("select")){
											$options = field.find("option");
										}else{
											$options = field.next().find("option");
											field =  field.next();
										}
										
							            $options.each(function(index){	
							            	
							            	 if(part.charAt(0) == 'i' || part.charAt(0) == 'r'){ //select (Codigo de Idioma) o (Grado de Responsabilidad)
							            		 value = $(this).val().trim();
							            	 }
							            	 else{
							            		 value = $(this).text().trim();
							            	 }
							            	
								             if(value == part.substring(1)){								            	
								               	field.find("option:contains(" + $(this).text() + ")").attr("selected", true);
								               	temp = true;
							                 }
							            });
							            
							            if(!temp){ //si es la option Otro
							            	field.prev().css({"display" : "inline"});
							            	field.prev().attr('value', part.substring(1));
							            	field.before('<br/>');
							            	field.css({"left" : "25px"});	
							            	field.find("option[value=0]").attr("selected", true);								            	
								           	temp = false;
							            }
								            
									}else if(field.is("textarea")){ //textarea
										field.attr('value', part.substring(1));
									}else { //div que contiene el checkbox
										part.substring(1) == "Texto Completo" ? field.children().prop('checked', true) : null;
									}
								}
															
							});
						});	
						
						containerFieldOfAssistant.children().last().css({
							"margin-bottom" : "60px"
						});
						
			});	
			
			
			//Close alert
			$('.alert.alert-error.fade.in .close').live("click", function(e) {
			    $(this).parent().hide();
			});
					
			
			//Close Modal
			$('div.modal.hide.fade').live('hide', function(e) { //al ocultarse el modal					
				var modalBody = $(this).children().next();
				var containerFieldOfAssistant = modalBody.find("[id = 'container-field']");			
				containerFieldOfAssistant.scrollTop(0);	
				
				if($(this).parent().parent().parent().next().children().first().hasClass("alert alert-error lil")){
					if($(this).parent().parent().parent().next().children().next().attr('value') != ''){						
						$(this).parent().parent().parent().next().children().first().hide();
					}					
				}
			});
			
			$('div.modal.hide.fade').live('hidden', function(e) { //una vez oculto el modal				
				$(".alert.alert-error.fade.in").each(function(index) {
					$(this).hide();
				});					
				
				//restaurar asistente						
				var numberField = $(this).attr('id').substring(5);	
				var modalBody = $(this).children().next();
				var condition = true;
				modalBody.find("[id~='repeating-field-v" + numberField + "']").each(function(index){							
					if(condition){ //el primer elemento no se elimina								
						condition = false;
						cleanField($(this).find("[id='v" + numberField + "']").children().children().children());
						cleanObligatoryField($(this).find("[id='v" + numberField + "']").children().children().children());
					}
					else{
						$(this).prev().is('hr') ? $(this).prev().remove() : null;
						$(this).remove();
						$(this).next().remove();
					}
				});				
			});
					
			
			
			
/////////////////////////////////////////// Utiles /////////////////////////////////////////////////////////			
			
			function cleanField(field){
				field.each(function(index) { //recorro los datos del unico field
					if($(this).is("textarea")) { //textarea
						$(this).attr("value", ""); 
					}else if($(this).is("select")) { //select
						if($(this).find(":selected").text().trim() == "Otro"){
							$(this).prev().prev().css({"display" : "none"});
							$(this).prev().prev().val("");
							$(this).prev().remove();
							$(this).css({"left" : "0px"});
						}						
						$(this).find("option:eq(0)").attr('selected', 'selected');									
					}else{ //checkbox
						$(this).find("input").attr('checked', false);							
					}
				});
			}
			
			function cleanObligatoryField(field){
				field.each(function(index) {
										
					if($(this).hasClass('required')){						
						$(this).attr("required", false);
					}
					
				});
			}
			
			function setObligatoryField(field){
				field.each(function(index) {
										
					if($(this).hasClass('required')){						
						$(this).attr("required", true);
					}					
					
				});
			}
			

});
