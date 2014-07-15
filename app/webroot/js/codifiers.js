$(document).ready(function() {
	
	$("#tipo_registro").change(function() {
		
		if($("#tipo_registro option:selected").text() != "")
		{
			$.post('/Codifiers/getById', {
				value : $("#tipo_registro option:selected").text()
			}, showOtherCombos);
		}
		else{
			$("tr:has(select[id~='dynamic'])").remove();
			cacheComboBox = Array();
		}

	});
});

var cacheComboBox = Array();

function showOtherCombos(json, callback) {		
	var arrayCodifiers = $.parseJSON(json);		
	var selectInitBody= "";
	var selectBody = "";
	var selectEndBody= "";		
	var existCodifierCache = false;
	var copyCacheComboBox = cacheComboBox;			
	cacheComboBox = Array(); //limpio el cache
	
	
	
	for (var key in arrayCodifiers) {	
		// util para ver que tiene un Object "alert(copyCacheComboBox.toSource());"			
		for ( var typeCodifier in arrayCodifiers[key]['Codifier']) {	
			
			for ( var int = 0; int < copyCacheComboBox.length; int++ ) { //busca en los codificadores del cache, los codificadores que coincidan con los nuevos codificadores encontrados
				if(copyCacheComboBox[int] == typeCodifier){
					existCodifierCache = true;
					copyCacheComboBox[int] = "*" + copyCacheComboBox[int]; //los codificadores del cache que coincidan, se marcan con "*" para no borrarlos
					cacheComboBox.unshift(typeCodifier);
				}
			}
			
			if(!existCodifierCache){ //si el nuevo codificador no se encuentra entre los codificadores del cache entonces lo agrego
				var convertion = convertNamesCodes(typeCodifier);				
				selectInitBody = "<tr><td>" + convertion['name'] + "</td><td><div class='control-group'><label class='control-label' for='Document'> </label><div class='controls'><select id='" + typeCodifier + " dynamic" + "' class='span6' name='data[Document][v" + convertion['code'] + "][" + convertion['name'] + "]'>";

				for ( var value in arrayCodifiers[key]['Codifier'][typeCodifier] ) {
					var temp2 = arrayCodifiers[key]['Codifier'][typeCodifier][value];
					if(convertion['code'] == 110 || convertion['code'] == 111 || convertion['code'] == 112 || convertion['code'] == 114 || convertion['code'] == 115){
						selectBody = selectBody + "<option value='" + temp2 + "'>" + (temp2 != null ? temp2 : "")  + "</option>";							
					}
					else{
						selectBody = selectBody + "<option value='" + value + "'>" + (temp2 != null ? temp2 : "")  + "</option>";
					}										
				}
				
				selectEndBody = "</select></div></div></td><td>[" + convertion['code'] + "]</td></tr>";
				
				if (copyCacheComboBox.length == 0) {//si es la primera vez que se selecciona un codificador en el combobox
					$("tr:has(select[id='tipo_registro'])").after(selectInitBody + selectBody + selectEndBody);						
				}else if((($("tr:has(select[id~='dynamic'])").last().find("select").attr("id") == 'designacion_especifica_material dynamic') && (copyCacheComboBox.length == 1 && copyCacheComboBox[0] == 'forma_item')) 
						|| (($("tr:has(select[id~='dynamic'])").last().prev().find("select").attr("id") == 'tipo_material_cartografico dynamic') && (copyCacheComboBox.length == 2))){						
					$("tr:has(select[id~='dynamic'])").last().before(selectInitBody + selectBody + selectEndBody);											
				}else if(($("tr:has(select[id~='dynamic'])").last().find("select").attr("id") == 'designacion_especifica_material dynamic') && (copyCacheComboBox.length == 1 && copyCacheComboBox[0] == 'tipo_archivo_computador')) {						
					if($("tr:has(select[id~='tipo_material_visual'])").length == 0){
						$("tr:has(select[id~='dynamic'])").last().before(selectInitBody + selectBody + selectEndBody);
					}
					else{
						$("tr:has(select[id~='tipo_material_visual'])").before(selectInitBody + selectBody + selectEndBody);
					}						
				}else if(($("tr:has(select[id~='dynamic'])").last().find("select").attr("id") == 'tipo_material_visual dynamic') && (copyCacheComboBox.length == 1 && copyCacheComboBox[0] == 'tipo_archivo_computador')) {
					$("tr:has(select[id~='dynamic'])").last().before(selectInitBody + selectBody + selectEndBody);												
				}else{						
					$("tr:has(select[id~='dynamic'])").last().after(selectInitBody + selectBody + selectEndBody);						
				}					
			}else{
				existCodifierCache = false;
			}
		}
		
		selectInitBody = "";
		selectBody = "";
		selectEndBody = "";			
	}
	
	for ( var key in copyCacheComboBox) { //elimino del cache los codificadores que no coincidan con los nuevos codificadores o sea que no tengan la marca "*"			
		if(copyCacheComboBox[key].charAt(0) != '*'){					
			$("tr:has(select[id~='" + copyCacheComboBox[key] + "'])").remove();
		}
	}
	
	callback();
}

function convertNamesCodes (key)
{
	var names = {'pais':'Pais', 'lenguaje':'Lenguaje', 'tipo_archivo_computador':'Tipo de Archivo de Computador', 'forma_item':'Forma del Item', 'tipo_material_cartografico':'Tipo de Material Cartogr&aacute;fico', 'tipo_material_visual':'Tipo de Material Visual', 'designacion_especifica_material':'Designaci&oacute;n Espec&iacute;fica del Material (Material No Proyectable)'};
	var codes = {'pais': 67, 'lenguaje': 40, 'tipo_archivo_computador': 111, 'forma_item': 110, 'tipo_material_cartografico': 112, 'tipo_material_visual': 114, 'designacion_especifica_material': 115};
	var result = Array();
	
	$.each(names, function(keyConvertion, valConvertion) {						
		if (key == keyConvertion) {	
			cacheComboBox.unshift(key);
			result['name'] = valConvertion;
			result['code'] = codes[keyConvertion];
			return false;
		}
	});
	
	return result;		
}
