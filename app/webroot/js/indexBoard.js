// JavaScript Document

$(document).ready(function() {
	
	$(".index-btn").click(function() {
		//Seleccionamos la fila con la que estamos trabajando
		var row = $(this).parent().parent().parent();
		var baseName = $.trim(row.children().eq(0).html());
		
		//Cantidad de Documentos a indexar
		var totalDocs = row.children('.info').children('.count-docs').html();
		
		//Sustituimos la info por la barra de prog
		row.children('.info').html('<div id="'+ baseName +'-prog" class="progress progress-striped active" style="margin-bottom: 5px; margin-top: 5px; height: 20px;"><div  style="float: left; width:0%;" class="bar"></div></div>');
		
		//Borramos los botones de accion
		$('.btn').fadeOut(500);
		
		
		var cont = 0;
		
		var progress = setInterval(function() {
			if(cont >= totalDocs){
				clearInterval(progress);
				$('#'+baseName+'-prog .bar').css('width', 100 + '%');
				window.location.reload();
				
			}else{
				if((cont+20)>=totalDocs){
					$.post("/index_bases/toindex", {base : baseName, skip : cont , limit : 20, commit: "true" });
				}else{
					$.post("/index_bases/toindex", {base : baseName, skip : cont , limit : 20, commit: "false" });
				}
				$('#'+baseName+'-prog .bar').css('width', (cont/totalDocs)*100 + '%');
				cont = cont+20;
			}
		},1000);
	
	});

});