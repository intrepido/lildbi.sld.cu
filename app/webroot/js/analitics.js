$(document).ready(
		function() {
			
			//LLenar los datos correspondientes al documento	
			if(window.arrayDataDocument != undefined){ 
				$(".success td:nth-child(3)").each(function (index) {
					 var element = $(this);
					 var temp = element.text().replace('[', '');
					 temp = temp.replace(']', '');				 
					 for (var key in window.arrayDataDocument)
						{						    					
							if(key == 'v'+ temp){
								$.each(window.arrayDataDocument[key], function(key2, name) {								
									element.prev().text(window.arrayDataDocument[key][key2]);
							    });							
							}
						}
				 });
				
				// LLena los datos del combo 'Tipo de Registro' y sus combos correspondientes, del documento. Cuando se carga la pagina por primera vez 
				if(window.arrayData == undefined){
					if(window.arrayDataDocument["v9"] != null){
						$.each(window.arrayDataDocument["v9"], function(key, name) {	
							$.post('/Codifiers/getById', {value : window.arrayDataDocument["v9"][key]}).done(function( data ) {
								showOtherCombos(data, function(){  //Llama a la funcion "showOtherCombos" del "codifiers.js"
									for (var key in window.arrayDataDocument)
									{
										if(key == "v9" || key == "v110" || key == "v111" || key == "v112" || key == "v114" || key == "v115"){					
											$.each(window.arrayDataDocument[key], function(key2, name) {								
												var element = $("[name = 'data[Document][" + key + "][" + key2 + "]']");								
												if(element.is('select')){	
													element.find("option[value='" + window.arrayDataDocument[key][key2] + "']").attr('selected', 'selected');														
												}
											});	
										}					
									}
								});															
							}); 
						});
					}	
				}
			}
			
			//LLenar los datos de la analitica cuando vengo de la pagina de visualizacion
			if(window.arrayData != undefined){
				for (var key2 in window.arrayData["v9"])
				{
					$.post('/Codifiers/getById', {
						value : window.arrayData["v9"][key2]
					}).done(function(data) {
						
						showOtherCombos(data, function(){  //Llama a la funcion "showOtherCombos" del "codifiers.js"
							
							$(document).one('ajaxComplete', function() { //La funcion "one" es para que se ejecute solo una vez cuando se carga la pagina								
								$.each(window.arrayData, function(key1, value) {						
									for (var key2 in value) {
										if(window.arrayData[key1][key2] != ""){					
											var element = $("[name = 'data[Document][" + key1 + "][" + key2 + "]']");
											if(element.is('input')){
												openAccordion(element);
												if(element.attr('type') == 'hidden'){							
													$.each(window.arrayData[key1][key2], function(key3, value2) {								
														element.next().children().find("option[value='" + window.arrayData[key1][key2][key3] + "']").attr('selected', 'selected');				
													});
												}
												else{
													element.attr('value', window.arrayData[key1][key2]);
												}												
											}
											if(element.is('textarea')){
												openAccordion(element);
												element.attr('value', window.arrayData[key1][key2]);
											}
											if(element.is('select')){								
												openAccordion(element);
												element.find("option[value='" + window.arrayData[key1][key2] + "']").attr('selected', 'selected');														
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
					$(location).attr("href", "/documents");
				}
				else{// Si estoy editando
					$(location).attr("href", "/analitics");
				}			
			});		
			
			//"Confirm" action in "visualization" page
			$('#confirmAction').click(function() {	
				$("#DocumentData").attr('name','data[Document][Confirm]');
				//$("#DocumentVisualizationForm").attr('action','/documents/add');
			});
			
			//Submit Formulario
			$('#DocumentAddForm').submit(function(e) {				
				var alertElements = $(this).children().next().children().next().children().find("[class='alert alert-error lil'][style = 'display: block;']");				
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
