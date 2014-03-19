$(document).ready(
		function() {			
			
			var jsonObj; //Variable Global. Contiene la lista de documentos a mostrar.
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
			$('#loading').html('<img src="/lildbi/img/loader.gif">');				 
				 
			//Se obtienen los documentos o analiticas a listar
			$.post("/lildbi/" + url + "/index" , { id: idDocument } )
				.done(function(data) {						
					$('#loading').fadeOut(100);
					if(data){ 						
						jsonObj = $.parseJSON(data);							
						fullTable(jsonObj['rows']);
						tablestoreOptions();
						$('#list-source-documents-sticky').show();						
					}	
					else{	
						setTimeout(function() {$("#alert-empty-list-document").show(); }, 500);
						if(url == 'analitics'){
							if(idDocument != ''){
								setTimeout(function() {$("#alert-empty-list-document-analitics").show(); }, 500); 
							 }else{
								setTimeout(function() {$("#alert-empty-list-analitics").show(); }, 500);
							 }
						}						
					}
			});
			
			
			//llena la tabla con los documentos paginados
			function fullTable(array){				   
					 
					 $('#list-source-documents tbody').empty();
					  
					 $.each(array, function( index, value ) {	
						 
						 var actions = $('#actions').clone();
						 var ref;
						 
						 ref = actions.find("a:nth-child(1)").attr('href');
						 actions.find("a:nth-child(1)").attr('href', ref + value['id']);
						 
						 ref = actions.find("a:nth-child(2)").attr('href');
						 actions.find("a:nth-child(2)").attr('href', ref + value['type'] + "/" + value['id']);
						 
						 actions.find("a:nth-child(3) input").val(value['id'] + "_" + value['key'][1]);						
						 
						 ref = actions.find("a:nth-child(4)").attr('href');
						 actions.find("a:nth-child(4)").attr('href', ref + value['type'] + "/" + value['id']);
						 
						 if(value['totalAnalitics'] != 0){
							 actions.find("a:nth-child(5) span").addClass('badge-info');
							 actions.find("a:nth-child(5) span").text(value['totalAnalitics']);							
							 actions.find("a:nth-child(5)").attr('href', '/lildbi/analitics/index/' + value['id']);
						 }						
						 
						/* var temp = false;
						 $('#list-source-documents tbody').append( "<tr>");
						 $.each(value['value'], function( index, fieldValue ) {
							 $('#list-source-documents thead tr th').each(function(){
								 if($(this).text().indexOf($.map(fieldValue, function(val, key){return key;})) > -1){ //Si no existe un th con ese nombre entonces lo agrego
									
								 }
							 });							 							 
							 $('#list-source-documents tbody').append("<td>" + $.map(fieldValue, function(val, key){return val;}) + "</td>");
						 });
						 $('#list-source-documents tbody').append( "</tr>");*/
						 
						 $('#list-source-documents tbody').append( "<tr>" +
						   		"<td>" + $.map(value['value']['v2'], function(val, key){return val;}) + "</td>" +
						   		"<td>" + $.map(value['value']['v30'], function(val, key){return val;})  + "</td>" +
						   		"<td>" + $.map(value['value']['v92'], function(val, key){return val;})  + "</td>" +
						   		"<td>" + $.map(value['value']['v64'], function(val, key){return val;})  + "</td>" +	
						   		"<td class='actions'></td></tr>"
						   	);
						 
						 $('#list-source-documents tbody tr:last td:last').append(actions.children());
					 });	

					$("#list-source-documents").delay(800).fadeIn();									
			}			
			
			
			function tablestoreOptions(){
						/*** Bootstrap collapse ***/					
					
						$('#collapseOne').collapse({
							toggle: false
						}).on('shown.bs.collapse', function () {
							$.tablesorter.columnSelector.attachTo( $('.tablesorter'), '#columns');
						});
					
						/*****  Table Sorter ******/
						
						$.extend($.tablesorter.themes.bootstrap, {
						    // these classes are added to the table. To see other table classes available,
						    // look here: http://twitter.github.com/bootstrap/base-css.html#tables
						    table      : 'table table-bordered',
						    header     : 'bootstrap-header', // give the header a gradient background
						    footerRow  : '',
						    footerCells: '',
						    icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
						    sortNone   : 'bootstrap-icon-unsorted',
						    sortAsc    : 'icon-chevron-up',
						    sortDesc   : 'icon-chevron-down',
						    active     : '', // applied when column is sorted
						    hover      : '', // use custom css here - bootstrap class may not override it
						    filterRow  : '', // filter row class
						    even       : '', // odd row zebra striping
						    odd        : ''  // even row zebra striping
						  });
						
						// call the tablesorter plugin and apply the uitheme widget
						$("table").tablesorter({
							// this will apply the bootstrap theme if "uitheme" widget is included
							// the widgetOptions.uitheme is no longer required to be set
							theme : "bootstrap",

							widthFixed : true,

							headerTemplate : '{content} {icon}', // new in v2.7. Needed to add
																	// the bootstrap icon!
																	
							headers: { 
								4: {sorter: false, filter: false}								
							}, 

							// widget code contained in the jquery.tablesorter.widgets.js file
							// use the zebra stripe widget if you plan on hiding any rows (filter
							// widget)
							widgets : [ "uitheme", "filter", "zebra", "columnSelector", "stickyHeaders" ],

							widgetOptions : {
								// using the default zebra striping class name, so it actually isn't
								// included in the theme variable above
								// this is ONLY needed for bootstrap theming if you are using the
								// filter widget, because rows are hidden
								zebra : [ "even", "odd" ],

								// reset filters button
								filter_reset : ".reset",

							// set the uitheme widget to use the bootstrap theme class names
							// this is no longer required, if theme is set
							// ,uitheme : "bootstrap"
							
								stickyHeaders_offset : 75.1

							}
						}).tablesorterPager({

							// target the pager markup - see the HTML block below
							container : $(".pager"),

							// target the pager page select dropdown - choose a page
							cssGoto : ".pagenum",

							// remove rows from the table to speed up the sort of large tables.
							// setting this to false, only hides the non-visible rows; needed if you
							// plan to add/remove rows with the pager enabled.
							removeRows : false,

							// output string - default is '{page}/{totalPages}';
							// possible variables: {page}, {totalPages}, {filteredPages},
							// {startRow}, {endRow}, {filteredRows} and {totalRows}
							output : '{startRow} - {endRow} / {filteredRows} ({totalRows})',
								
							// Number of visible rows - default is 10
							size: 5

						});
						
						$('table thead td input[disabled]').css("display", "none");
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
					
					$('table').trigger('update');				
				     
					$("#modal-confirmation-delete").modal('hide');
					
					if(jsonObj['rows'].length == 0){
						 $("#list-source-documents").fadeOut(100);						
						 setTimeout(function() {$("#alert-empty-list-document").show(); }, 1000);
						 if(url == 'analitics'){
							if(idDocument != ''){
								setTimeout(function() {$("#alert-empty-list-document-analitics").show(); }, 1000); 
						    }else{
								setTimeout(function() {$("#alert-empty-list-analitics").show(); }, 1000);
							 }
						 }							 
					}
				});
			});
			
			//Close Modal
			$('#modal-confirmation-delete').live('hide', function(e) { //al ocultarse el modal				
				$('#x').removeAttr("id");		
			});
			
			
			
			
});
