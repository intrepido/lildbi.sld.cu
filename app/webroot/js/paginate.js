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
			
			//Se inserta el Loader
			$('#loading').html('<img src="/lildbi/img/loader.gif">');				 
				 
			//Se obtienen los documentos o analiticas a listar
			$.post("/lildbi/" + url + "/index" , { id: idDocument } )
				.done(function(data) {						
					$('#loading').fadeOut(100);
					if(data){ 						
						jsonObj = $.parseJSON(data);						
						fullTable(jsonObj['rows'], jsonObj['nameFields']); //llena la tabla con los documentos
						tablestoreOptions(jsonObj['nameFields']); //Se inicializan todos los widgets del tablesorter
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
			
			
			
			function fullTable(array, arrayHeaders){				   
							
					/**** Aqui se llena los th de la tabla *****/
					 $.each(arrayHeaders, function( index, value ) {
						 var mostImportantFieldDocument = Array("v1", "v2", "v18", "v20", "v30", "v91");
						 if($.inArray(index, mostImportantFieldDocument) > -1){ //Estos th estaran visibles por defecto, son los que se mostraran u ocultaran cuando se redimensione la tabla
							 if(index == "v91"){ 
								 $('#list-source-documents thead tr').append("<th data-priority='5'>" + value + "</th>");
							 }else if(index == "v30"){
								 $('#list-source-documents thead tr').append("<th data-priority='4'>" + value + "</th>");
							 }else if(index == "v20"){
								 $('#list-source-documents thead tr').append("<th data-priority='3'>" + value + "</th>");
							 }else if(index == "v18"){
								 $('#list-source-documents thead tr').append("<th data-priority='2'>" + value + "</th>");
							 }else if(index == "v1"){
								 $('#list-source-documents thead tr').append("<th data-priority='1'>" + value + "</th>");
							 }else{
								 $('#list-source-documents thead tr').append("<th data-priority='critical'>" + value + "</th>");	//v2 
							 }							 									 
						 }else{	//Estos th estaran ocultos por defecto, no se mostraran en la tabla cuando esta se redimensione						 
							 $('#list-source-documents thead tr').append("<th data-priority='6' class='columnSelector-false'>" + value + "</th>"); 
						 }						 
					 });				 
					 
					 $('#list-source-documents thead tr').find("th:nth-child(1)").insertAfter( $('#list-source-documents thead tr th:last') ); //Pone el th de Acciones como ultimo de los th
					 
					 
					 /**** Aqui se llena cada td de cada tr de la tabla *****/
					 $.each(array, function( index, value ) { //Recorro cada documento
						 
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
						 						
						 $('#list-source-documents tbody').append("<tr></tr>"); //Se agrega un tr al tbody
						 
						 $.each(arrayHeaders, function( index, value ) { //Se agrega al tr todos los td vacios	 
							 $('#list-source-documents tbody tr:last').append( "<td id='" + index + "'></td>");								 
						 });
						 
						 $.each(value['value'], function( index, fieldValue ) {	//Se agrega a los td del tr, los datos del documento			
							 if($('#list-source-documents tbody tr:last').find("td[id='" + index + "']").length > 0){ 
								 $('#list-source-documents tbody tr:last').find("td[id='" + index + "']").append($.map(fieldValue, function(val, key){return val;}));
							 }
						 });	
						 
						 $('#list-source-documents tbody tr:last').append("<td></td>"); //Se agrega un ultimo td al tr
						 $('#list-source-documents tbody tr:last td:last').append(actions.children()); //En este ultimo td se agregan las acciones
					 });	

					 //Luego que se muestre la tabla y los demas elementos completamente, entonces se aplican los widgets del tablesorter para que de esta forma tengan efecto los cambios
					$(".show-element").delay(800).fadeIn("", function(){
						//$('table')[0].config.widgets = [ "uitheme", "filter", "zebra", "columnSelector", "stickyHeaders" ];
						$(this).trigger('applyWidgets');
						$('#list-source-documents-sticky').show();
						$('.tablesorter-pager').css({'background-color': '#EEEEEE', 'text-align': 'center'});
						$('.tablesorter-pager select').css({'padding': '4px 6px'});
						$('#list-source-documents').css({'margin-bottom': '0px'});
					});									
			}			
			
			
			function tablestoreOptions(arrayHeaders){	
				
						/***** Disable header actions ****/
						
						var dataHeader = {};
						dataHeader[$('#list-source-documents thead tr th:last').index()] = {sorter: false, filter: false};
						
						
						/***** Disable colums ****/
						
						/*var dataColumns = {};	
						var cont=0;
						$.each(arrayHeaders, function( index, value ) {				 
							 if(index != ("v2" || "v18" || "v20" || "v30" || "v91")){
								 dataColumns[cont] = "false";								 
							 }			
							 cont++;
						 });*/
												
						
						//inner2[$('.disableSorter').index()] = 'disable';
						
					
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
						$(".tablesorter").tablesorter({
							// this will apply the bootstrap theme if "uitheme" widget is included
							// the widgetOptions.uitheme is no longer required to be set
							theme : "bootstrap",

							widthFixed : false,

							headerTemplate : '{content} {icon}', // new in v2.7. Needed to add
																	// the bootstrap icon!
																	
							headers: dataHeader, 

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
							
								//columnSelector_columns : dataColumns,	
								
								columnSelector_saveColumns: false,
								
								columnSelector_breakpoints: [ "1000px", "1100px", "1200px", "1300px", "1700px", "5000px" ],
								
								columnSelector_mediaqueryState: true,
								
								columnSelector_mediaquery: true,
								
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
						
						$('.tablesorter thead td input[disabled]').css("display", "none"); //Se oculta el input de filtracion de la columna de acciones
			}
			
			
			// Despliega el slide con las columnas a filtrar
			$('#collapseOne').collapse({
				toggle: false
			}).on('shown.bs.collapse', function () {
			
				var colSel, indx, $popup = $('#columns');
				if ($popup.length && $('.tablesorter')[0].config) {
					if (!$popup.find('.tablesorter-column-selector').length) {
						// add a wrapper to add the selector into, in case the popup has other content
						$popup.append('<span class="tablesorter-column-selector"></span>');
					}
					colSel = $('.tablesorter')[0].config.selector;
					
					$popup.find('.tablesorter-column-selector')
						.html( colSel.$container.html() )
						.find('input').each(function(){
							var indx = $(this).attr('data-column');
							$(this).prop( 'checked', indx === 'auto' ? colSel.auto : colSel.states[indx] );
						});
					
					colSel.$popup = $popup.on('change', 'input', function(){
						// data input
						indx = $(this).attr('data-column');
						// update original popup
						colSel.$container.find('input[data-column="' + indx + '"]')
							.prop('checked', this.checked)
							.trigger('change');
						
						if(indx=="auto"){
						   fullSliderColumns();  //LLena el slide con las columnas a filtrar 
						}
						
					});
					
					fullSliderColumns();	//LLena el slide con las columnas a filtrar 
				}
			});				
			 			
			
			function fullSliderColumns(){	
				
				if($('#columns-default').children().length > 0){
					$('#columns-default').empty();					
				}		
				$('.tablesorter-column-selector').find("label").has("input[data-column='auto']").appendTo($('#columns-default'));
				
				var slider = $('.bxslider').clone();			
				var cont=0;
				$('.tablesorter-column-selector').find("label").each(function(){					
					if(cont==5){
						cont = 0;
					}					
					if(cont<5){
						if(cont==0){
						  slider.append("<li></li>");
						}	
						slider.find('li:last').append($(this));											
					}					
					cont++;																			
				});
									
				slider.appendTo('.tablesorter-column-selector');
				slider.addClass('active');				
				slider.show().bxSlider({
					slideWidth: 6000 ,
				    minSlides: 3,
				    maxSlides: 3,
				    moveSlides: 3,
				    responsive: true,
				    controls: false
				});
				
				slider.find('label').addClass('checkbox');
				$('#columns-default').find('label').addClass('checkbox');
				
				$('.bx-wrapper').css({
					"margin-bottom": "40px",
					"box-shadow":"0 0 1px #CCCCCC"
				});
				
				$('.bx-viewport').css({
					"padding-bottom": "30px",
					"box-shadow":"0 0 1px #CCCCCC"
				});
				
				slider.css({
					"margin-left": "50px",
					"margin-top": "20px"
				});			
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
					
					$('.tablesorter').trigger('update');				
				     
					$("#modal-confirmation-delete").modal('hide');
					
					if(jsonObj['rows'].length == 0){//Arreglar
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
