$(document).ready(
		function() {
			
			if(window.arrayData != undefined){ //Entra cuando llega de darle al boton atras de la pagina de visualizacion
				for (var key2 in arrayData["v9"])
				{
					$.post('/Codifiers/getById', {
						value : arrayData["v9"][key2]
					}).done(function(data) {
						
						showOtherCombos(data, function(){  //Llama a la funcion "showOtherCombos" del "codifiers.js"
							
							$(document).one('ajaxComplete', function() { //La funcion "one" es para que se ejecute solo una vez cuando se carga la pagina								
								$.each(arrayData, function(key1, value) {						
									for (var key2 in value) {
										if(arrayData[key1][key2] != ""){					
											var element = $("[name = 'data[Document][" + key1 + "][" + key2 + "]']");
											if(element.is('input')){
												openAccordion(element);
												if(element.attr('type') == 'hidden'){							
													$.each(arrayData[key1][key2], function(key3, value2) {								
														element.next().children().find("option[value='" + arrayData[key1][key2][key3] + "']").attr('selected', 'selected');				
													});
												}
												else{
													element.attr('value', arrayData[key1][key2]);
												}												
											}
											if(element.is('textarea')){
												openAccordion(element);
												element.attr('value', arrayData[key1][key2]);
											}
											if(element.is('select')){								
												openAccordion(element);
												element.find("option[value='" + arrayData[key1][key2] + "']").attr('selected', 'selected');														
											}
										}					
									}	
								});
							});	
							
						});
						
					});
				}						
				
				function openAccordion(element){
					if(element.closest('div .accordion').length > 0){	
						element.closest('div .accordion').children().next().collapse('show');
						element.closest('div .accordion').children().children().attr('checked', true);
					}
				}
			}			
			
			
			$("#confirm-type-document").click(
					function() {
						$(this).attr(
								"href",
								"/documents/add/"
										+ $("select").attr("value"));
					});

			$('#cleanField').live(
					'click',
					function(e) {
						$(this).parent().parent().parent().next().children()
								.attr('value', "");
						e.preventDefault();
					});				
		
			$("#backBreadcrumb").click(function() {
				$("#backAction").click();
				e.preventDefault();
			});
			
			//Boton "Atras" de las vistas view Document y Analitic
			$("#backView").click(function() {				
				$(location).attr("href", $("#backUrl").attr("href"));		
			});	
			
			//Boton "Cancelar" 
			$("#documentCancelButton button[type='button']").click(function() {
				if($(location).attr("href").indexOf('add') != -1){ //Si estoy insertando
					$(location).attr("href", "/documents/add");
				}
				else{// Si estoy editando
					$(location).attr("href", "/documents");
				}			
			});		
			
			//"Confirm" action in "visualization" page
			$('#confirmAction').click(function() {	
				$("#DocumentData").attr('name','data[Document][Confirm]');
				//$("#DocumentVisualizationForm").attr('action','/documents/add');
			});
			
			//Submit Formulario
			$('#DocumentAddForm').submit(function(e) {				
				var alertElements = $(this).children().next().children().first().find("[class='alert alert-error lil'][style = 'display: block;']");				
				if(alertElements.length){					
					e.preventDefault(); 					
				}	
				else{					
					$('textarea[disabled]').attr('disabled',false);					
				}
			});	
			
			// Validation required fields
			$("#documentPreviewButton button[type='submit']").click(function() {				
					var requiredElements = $("#DocumentAddForm").children().next().children().find("[required]");
					var temp = false;
					var temp2 = true;
					requiredElements.each(function(index){						
						if(($(this).is('input')) && ($(this).attr("value") == "")){	
							//alert($(this).parent().parent().prev().attr("style"));
							if($(this).parent().parent().prev().hasClass("alert alert-error lil") && $(this).parent().parent().prev().css("display") == "block"){
								$(this).parent().parent().prev().hide();							
							}
							$(this).parent().parent().prev().css('display', 'block');
							!temp ? temp=true : null;							
						}
						if(($(this).is('textarea')) && ($(this).attr("value") == "")){
							if($(this).prev().hasClass("alert alert-error lil") && $(this).prev().css("display") == "block"){
								$(this).prev().hide();
							}							
							$(this).prev().css('display', 'block');						
							!temp ? temp=true : null;
						}
						if(($(this).is('select')) && ($(this).find(":selected").text().trim() == "")){
							if($(this).parent().parent().prev().hasClass("alert alert-error lil") && $(this).parent().parent().prev().css("display") == "block"){
								$(this).parent().parent().prev().hide();
							}	
							$(this).parent().parent().prev().css('display', 'block');
							!temp ? temp=true : null;
						}
						
						if(temp && temp2){								
							$('html, body').stop().animate({scrollTop: $(this).offset().top - 118}, 500);
							temp2 = false;
						}
					 });
			});
									
			$("input").keypress(function() {
				if($(this).parent().parent().prev().hasClass("alert alert-error lil")){
					$(this).parent().parent().prev().hide();	//oculto el mensaje de error
				}			
			});
			
			$('textarea').keypress(function() {
				if($(this).prev().hasClass("alert alert-error lil")){
					$(this).prev().hide(); //oculto el mensaje de error
				}
			});
			
			$("select").change(function() {
				if($(this).parent().parent().prev().hasClass("alert alert-error lil")){
					$(this).parent().parent().prev().hide(); //oculto el mensaje de error
				}
			});
			
			
			//Close alert
			$('.alert.alert-error.lil .close').live("click", function(e) {
			    $(this).parent().hide();
			});		
			
			
			//Complements			
			setTimeout(function() {//Para que se pongan los campos como madatorios en Notas de Evento cuando se edita el documento
				var elementRequired = $('#collapseOne').children().find("td[class='mandatory']");
				   
				   if( $("#eventNotes").is(':checked') ){					  
					    elementRequired.each(function(index){
					    	if($(this).prev().find("textarea").length > 0){						    	
					    		 $(this).prev().find("textarea").attr("required", true);
						    }
						    else{						    	
						    	$(this).prev().children().find("input").attr("required", true);						    	
						    }					    
					    });					    
				   } 
			}, 3000);			
					
			$("#eventNotes").click( function(){
				var elementRequired = $('#collapseOne').children().find("td[class='mandatory']");
				   
				   if( $(this).is(':checked') ){
					    $('#collapseOne').collapse('show');
					    elementRequired.each(function(index){
					    	if($(this).prev().find("textarea").length > 0){						    	
					    		 $(this).prev().find("textarea").attr("required", true);
						    }
						    else{						    	
						    	$(this).prev().children().find("input").attr("required", true);						    	
						    }					    
					    });					    
				   } 
				   else{
					    $('#collapseOne').collapse('hide');
					    elementRequired.each(function(index){					    	
					    	if($(this).prev().find("textarea").length > 0){						    	
						    	$(this).prev().find("textarea").attr("required", false);						    	
						    	if($(this).prev().find("textarea").prev().css("display") == "block"){
						    		$(this).prev().find("textarea").prev().hide();
						    	}  						    	
						    }
						    else{						    	
						    	$(this).prev().children().find("input").attr("required", false);						    	
						    	if($(this).prev().children().find("input").parent().parent().prev().css("display") == "block"){
						    		$(this).prev().children().find("input").parent().parent().prev().hide();
						    	}
						    }					    
					    });
					    
					    $('#collapseOne').children().find("input").attr("value", "");
					    $('#collapseOne').children().find("textarea").attr("value", "");
					    $('#collapseOne').children().find("select").find("option:eq(0)").attr('selected', 'selected');
				   }
			});			
			
			$("#proyectNotes").click( function(){
				   if( $(this).is(':checked') ){
					    $('#collapseTwo').collapse('show');
				   } 
				   else{
					   $('#collapseTwo').collapse('hide');
					   $('#collapseTwo').children().find("input").attr("value", "");
					   $('#collapseTwo').children().find("textarea").attr("value", "");
				   }
			});	
			
			
		});
