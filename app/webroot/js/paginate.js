$(document).ready(
		function() {
			
			var jsonObj; //Variable Global. Contiene la lista de documentos a mostrar.
			var groupBy = 3; //Variable Global. Cantidad de documentos por paginas.
			var url;
			var idDocument = "";
			
			if($(location).attr("href").indexOf('documents') != -1){//Documents
				url = 'documents';
			}else{ //Analitics
				url = 'analitics';
				var array = $(location).attr("href").split("index");
				if(array.length > 1){
					idDocument = array[1].replace('/', "");	
				}
			}
			
			//Paginator documents
			if($("#paginator").length){
				 $('#loading').html('<img src="/lildbi/img/loader.gif">');				 
				 
				//Se obtienen los documentos o analiticas a listar
				$.post("/lildbi/" + url + "/index" , { id: idDocument } )
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
						 var ref;
						 
						 ref = actions.find("a:nth-child(1)").attr('href');
						 actions.find("a:nth-child(1)").attr('href', ref + value['id']);
						 
						 ref = actions.find("a:nth-child(2)").attr('href');
						 actions.find("a:nth-child(2)").attr('href', ref + value['type'] + "/" + value['id']);
						 
						 actions.find("a:nth-child(3) input").val(value['id'] + "_" + value['value']['_rev']);						
						 
						 ref = actions.find("a:nth-child(4)").attr('href');
						 actions.find("a:nth-child(4)").attr('href', ref + value['type'] + "/" + value['id']);
						 
						 if(value['totalAnalitics'] != 0){
							 actions.find("a:nth-child(5) span").addClass('badge-info');
							 actions.find("a:nth-child(5) span").text(value['totalAnalitics']);
							 ref = actions.find("a:nth-child(5)").attr('href');
							 actions.find("a:nth-child(5)").attr('href', ref + value['id']);
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
			
});
