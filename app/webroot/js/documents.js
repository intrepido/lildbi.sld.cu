$(document).ready(
		function() {
			
			var jsonObj; //Variable Global. Contiene la lista de documentos a mostrar.
			var groupBy = 3; //Variable Global. cantidad de documentos por paginas.
			var url;
			if($(location).attr("href").contains('documents')){//Documento
				url = 'documents';
			}else{ //Analitca
				url = 'analitics';
			}
			
			//Paginator documents
			if($("#paginator").length){
				 $('#loading').html('<img src="img/loader.gif">');				 
				 
				//Se obtienen los documentos a listar
				$.post("/lildbi/" + url + "/index")
				.done(function(data) {						
					$('#loading').fadeOut(100);
					if(data){ 						
						 jsonObj = $.parseJSON(data);
						 var temp = jsonObj['rows'].slice(0); //copia por valor	
						 var totalPages = Math.ceil(temp.length / groupBy);							 
						 fullTable(1, groupBy, temp);	
						  
						 var options = {
					            currentPage: 1,
					            totalPages: totalPages,
								alignment: "center",
								itemContainerClass: function (type, page, current) {
					                return (page === current) ? "active" : "pointer-cursor";
					            },
					            onPageClicked: function(e,originalEvent,type,page){									
									 temp = jsonObj['rows'].slice();									 
							     	 fullTable(page, groupBy, temp);  													 
					            }
					      };

					      $('#paginator').bootstrapPaginator(options);				
						   
					}	
					else{						
						$("#alert-empty-list-document").delay(200).fadeIn();
					}
				});
			}
			
			//llena la tabla con los documentos paginados
			function fullTable(noPage, groupBy, array){				   
					 var startRec = Math.max(noPage - 1, 0) * groupBy;  
					 var recordsToShow = array.splice(startRec, groupBy);
					 $('#list-source-documents tbody').empty();
					  
					 $.each(recordsToShow, function( index, value ) {	
						 
						 var actions = $('#actions').clone();
						 var url;
						 
						 url = actions.find("a:nth-child(1)").attr('href');
						 actions.find("a:nth-child(1)").attr('href', url + value['key'][0]);
						 
						 url = actions.find("a:nth-child(2)").attr('href');
						 actions.find("a:nth-child(2)").attr('href', url + value['type'] + "/" + value['key'][0]);
						 
						 actions.find("a:nth-child(3) input").val(value['key'][0] + "_" + value['value']['_rev']);						
						 
						 url = actions.find("a:nth-child(4)").attr('href');
						 actions.find("a:nth-child(4)").attr('href', url + value['type'] + "/" + value['key'][0]);
						 
						 if(value['totalAnalitics'] != 0){
							 actions.find("a:nth-child(5) span").addClass('badge-info');
							 actions.find("a:nth-child(5) span").text(value['totalAnalitics']);
							 actions.find("a:nth-child(5)").attr('href', 'analitics/listDocumentAnalitics/' + value['key'][0]);
						 }						
						 												 
						 $('#list-source-documents tbody').append( "<tr>" +
						   		"<td>" + value['value']['v2'] + "</td>" +
						   		"<td>" + value['value']['v30']  + "</td>" +
						   		"<td>" + value['value']['v92']  + "</td>" +
						   		"<td>" + value['value']['v64']  + "</td>" +	
						   		"<td class='actions'></td>"
						   	);
						 
						 $('#list-source-documents tbody tr:last td:last').append(actions.children());
					 });					
					 
					 $("#list-source-documents").delay(800).fadeIn();
					 $('#paginator').delay(800).fadeIn();
			}
			
			//Tooltip para los botones de las acciones de la tabla de documentos
			$(document).on("mouseenter", "#list-source-documents a", function(){
				var element = $(this);								
				element.tooltip('show');
			});
			
			//Eliminar document de la lista
			$(document).on("click", "#delete", function(){	
				$(this).parent().parent().parent().parent().attr("id", "x"); //Marcar el <tr> a eliminar una vez aparesca el Modal
				$("#modal-confirmation-delete").modal('show');				
			});
			
			//Cuando se oprime el boton Eliminar del Modal
			$('#delete-document').click(function() {
				 
			   $.post("/lildbi/" + url + "/delete", {value : $('#x').find("#delete input").val()});				   
			   $('#x').hide("slow");
			   $("#x").delay(300).queue(function(){					
					var id = ($('#x').find("#delete input").val()).split('_');
					$(this).remove();
					jsonObj['rows'] = $.grep(jsonObj['rows'], function(e){ return e.id !== id[0]}); //Devuelve el array sin el elemento que tiene el id que se le pasa					
					var temp = jsonObj['rows'].slice(0); //Copia por valor del array desde la posicion 0
					var totalPages = Math.ceil(temp.length / groupBy); //La funcion ceil redondea el resultado
					var currentPage;					
					
					if(temp.length != 0){
						if($('#paginator ul li.active a').text() > totalPages){						
							currentPage = ($('#paginator ul li.active a').text()) - 1;
						}
						else{
							currentPage = $('#paginator ul li.active a').text();
						}
						
						 options = {				                
					                totalPages: totalPages,
					            };

					     $('#paginator').bootstrapPaginator(options);
					     $('#paginator').bootstrapPaginator("show", currentPage);
					     fullTable(currentPage, groupBy, temp);  
					}				
				     
					$("#modal-confirmation-delete").modal('hide');
					
					if(jsonObj['rows'].length == 0){
						 $("#list-source-documents").fadeOut(100);
						 $('#paginator').fadeOut(100);
						 setTimeout(function() {$("#alert-empty-list-document").show(); }, 1000);
					}
					
				});
			});
			
			//Close Modal
			$('#modal-confirmation-delete').live('hide', function(e) { //al ocultarse el modal				
				$('#x').removeAttr("id");		
			});
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			
			
			$("#confirm-type-document").click(
					function() {
						$(this).attr(
								"href",
								"/lildbi/documents/add/"
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
			
			//Boton "Cancelar" 
			$("#documentCancelButton button[type='button']").click(function() {
				if($(location).attr("href").contains('documents')){ //Formulario de Documentos
					if($(location).attr("href").contains('add')){ //Si estoy insertando
						$(location).attr("href", "/lildbi/documents/add");
					}
					else{// Si estoy editando
						$(location).attr("href", "/lildbi/documents");
					}
				}
				else{ //Formulario de Analiticas
					$(location).attr("href", "/lildbi/documents");
				}				
			});		
			
			//"Confirm" action in "visualization" page
			$('#confirmAction').click(function() {	
				$("#DocumentData").attr('name','data[Document][Confirm]');
				//$("#DocumentVisualizationForm").attr('action','/lildbi/documents/add');
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
							$('html, body').stop().animate({scrollTop: $(this).offset().top - 150}, 500);
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
