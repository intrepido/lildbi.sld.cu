$(document).ready( function() {
	$('.overDesc').tooltip();
	
	$('#search').focus();
	
	$('#lang').children().eq(0).html('Todos');
	
	$('#country').children().eq(0).html('Todos');
	
	$('#formatText').children().eq(0).html('Todos');
	
	$('#advSearch').focus();

	
	//Resultados por paginas
	$("#checkCompletText").click(function() {
		if($("#formatText").prop("disabled") == true){
			$("#formatText").prop("disabled", false);
		}else{
			$("#formatText").prop("disabled", true);
		}
	});
	
	function enableFormat(){
		
	}
	
	//Resultados por paginas
	$("#queryRows").change(function() {
		var pages = $(this).val();
		var url = "/searches/search/" + window.urlLastSearch + pages;		
		$(location).attr("href", url);
	});
	
	//Agregar o desagregar elemento a la carpeta.
	$(".updateFolder").click(function() {
		var temp = $(this);
		$.post("/searches/updateFolder", {docID : temp.attr('id') }, function(resp) {
        	if(resp == 'add'){
				temp.children().eq(0).attr('class','icon-minus overDesc').parent().attr('data-original-title','Remover de la carpeta');
				$('.icon-folder-close').attr('class','icon-folder-open icon-white');
			}
			if(resp == 'del'){
				temp.children().eq(0).attr('class','icon-plus overDesc').parent().attr('data-original-title','Agregar a carpeta');	
			}
			if(resp == 'delAll'){
				temp.children().eq(0).attr('class','icon-plus overDesc').parent().attr('data-original-title','Agregar a carpeta');
				$('.icon-folder-open').attr('class','icon-folder-close icon-white');	
			}
		});	
	});
	
	//Borrar elemento en carpeta
	$(".removeDoc").click(function() {
		var temp = $(this);
		$.post("/searches/updateFolder", {docID : temp.attr('id') }, function(resp) {
        	if(resp == 'del'){
					temp.parent().parent().fadeOut(500);
			}
			if(resp == 'delAll'){
					temp.parent().parent().fadeOut(500,function() { 
						temp.parent().parent().html('<h5 id="msg-empty" style="margin-left:20px">La carpeta está vacía.</h5>').fadeIn(300);
						$('.btn .icon-folder-open').attr('class','icon-folder-close icon-white');
					});
			}
		});	
	});
	
	//Borrar contenido de la carpeta
	$(".removeAllDoc").click(function() {
		$.post("/searches/delFolder", function(resp) {
  			if(resp == 'delAll'){
				$('.icon-minus').attr('class','icon-plus overDesc').parent().attr('data-original-title','Agregar a carpeta');
				$('.btn .icon-folder-open').attr('class','icon-folder-close icon-white');
				
				var temp = $('.docContent');
				var temp = temp.eq((temp.length-1));
				$('.docContent').fadeOut(500,function() { 
					temp.html('<h5 id="msg-empty" style="margin-left:20px">La carpeta está vacía.</h5>').fadeIn(300);
				});
			}
		});	
	});
	
	//Mostrar detalles de un documento
	$(".viewDocBtn").click(function() {
		var idDoc = $(this).attr('id');
		$('.overDesc').tooltip();
		$('#modalSearchResult').html('<br/><center><img src="/img/loader.gif" /></center><br/>');
		$.post("/searches/view/"+idDoc, function(resp) {
				$('#modalSearchResult').html(resp);
		});	
	});
	
	//Mostrar detalles de un documento
	$(".viewDocLink").click(function() {
		var idDoc = $(this).attr('id');
		$('#modalSearchResult').html('<br/><center><img src="/img/loader.gif" /></center><br/>');
		$.post("/searches/view/"+idDoc, function(resp) {
				$('#modalSearchResult').html(resp);
		});	
	});
	
	//Autocompletamiento de los formularios de b�squeda
	var sugg = '';
	var tempo;
	$('#search').typeahead({
		source: function (query, process) {
			if(query.length>1){
				clearTimeout(tempo);
				tempo = setTimeout(function(){
					$.ajax({
						url: '/searches/suggestions/' + encodeURI(query),
						success: function(resp) {
							 if(resp != '0'){
								 sugg = eval(resp);
								 console.log(resp);
								process(sugg[1]['suggestion']);			 
							 }else{
								process('[]');
							 }
						}
					});	
				},500);
			}else{
				process('');
			}
		}
	});
	
});

//Validar formulario de busqueda.
function validate(){
	var elem = $('#search');
	if(document.getElementById('search').value.length < 3){		
		if(document.getElementById('search').value == ''){
			elem.attr('placeholder','Debe introducir términos para la búsqueda.').val('').attr('style',' border: 1px solid red;');	
		}else{
			elem.attr('placeholder','Debe introducir al menos 3 caracteres.').val('').attr('style',' border: 1px solid red;');	
		}
		elem.focus();
		return false;
	}else{
	 	return true;
	}
}

//Validar formulario de busqueda avanzado.
function validateAdv(){
	var elem = $('#advSearch');
	if(elem.val().length < 3){		
		if(elem.val() == ''){
			elem.attr('placeholder','Debe introducir términos para la búsqueda.').val('').attr('style',' border: 1px solid red;');	
		}else{
			elem.attr('placeholder','Debe introducir al menos 3 caracteres.').val('').attr('style',' border: 1px solid red;');	
		}
		elem.focus();
		return false;
	}else{
	 	return true;
	}
}
