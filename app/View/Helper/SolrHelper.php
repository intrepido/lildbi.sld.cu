<?php
class SolrHelper extends AppHelper{
	
	function title($text = null){
		if(isset($text)){
			$trans = array("<i>" => "(", "</i>" => ")");
			$text = strtr($text, $trans);
			return $text;
		}
		return null;
	}
	
	function author($arr = null){
		$text = '';
		foreach($arr as $item){
			$text = $text.$this->getTagContent($item, '*').'; ';
		}
		return substr($text,0,(strlen($text)-2));
	}
	
	function summary($text = null){
		$trans = array("<i>" => "(", "</i>" => ")");
		$text = strtr($text, $trans);
		return $text;
	}
	
	function desc($arr = null){
		$trans = array("<d>" => "", "</d>" => "","<s>" => " / ", "</s>" => "");
		$text = null;
		foreach($arr as $i){
			$text[] = strtr($i, $trans);
		}
		return $text;
	}
	
	function authKeyWords($arr = null){
		$trans = array("<i>" => " (", "</i>" => ")","<s>" => " / ","</s>" => " ");
		$text = null;
		foreach($arr as $i){
			$text[] = strtr($i, $trans);
		}
		return $text;
	}
	
	function localization($arr = null){
		$trans = array("<a>" => " ", "</a>" => ". ","<b>" => " ", "</b>" => ". ","<c>" => " ", "</c>" => ". ","<t>" => " ", "</t>" => ". ");
		foreach($arr as $i){
			$text[] = strtr($i, $trans);
		}
		return $text;
	}
	
	function url($text = null, $full = false){
		if(isset($text)){
			return $this->getTagContent($text,'u');
		}
		return null;
	}
	
	function authorAf($text = null){
		if(isset($text)){
			$arr = explode(";", $text);
			$text = '';
			$temp1 = null;
			$temp2 = null;
			foreach($arr as $item){
				if(trim($item) != ''){
						$text = $text.$this->getTagContent($item, '*').'; ';
				}
			}
			return substr($text,0,(strlen($text)-2));
		}
		return null;
	}
	
	function typeDoc($text = null){
		$types = array(
		  "S" => 'Documento publicado en una serie periódica',
		  "SC" => 'Documento de conferencia en una serie periódica',
		  "SCP" => 'Documento de proyecto y conferencia en una serie periódica',
		  "SP" => 'Documento de proyecto en una serie periódica',
		  "M" => 'Documento publicado en una monografía',
		  "MC" => 'Documento de conferencia en una monografía',
		  "MCP" => 'Documento de proyecto y conferencia en una monografía',
		  "MP" => 'Documento de proyecto en una monografía',
		  "MS" => 'Documento publicado en una serie monográfica',
		  "MSC" => 'Documento de conferencia en una serie monográfica',
		  "MSP" => 'Documento de proyecto en una serie monográfica',
		  "T" => 'Tesis, Disertación',
		  "TS" => 'Tesis, Disertación que pertenece a una serie monográfica',
		  "N" => 'Documento no convencional',
		  "NC" => 'Documento de conferencia en forma no convencional',
		  "NP" => 'Documento de proyecto en forma no convencional',
		);    
		return $types[$text];
	}
	
	function getTagContent($text = null, $tag = null){
		if(isset($text)){
			if($tag == '*'){
				$result = strstr($text, '<', true); 
				if($result == ''){
					return trim($text);
				}
				return trim($result);
			}else{
				$text = strstr($text, '<'.$tag.'>');
				$text = strstr($text, '</'.$tag.'>', true); 
				$text = strtr($text, array(('<'.$tag.'>') => '' ));
				
				return trim($text);
			}
		}
		return null;
	}
	
	function getFieldName($field = null){
		$fields = array('v1'=>'Código del Centro' , 'v2'=>'ID' , 'v4'=>'Base de Datos' , 'v40'=>'Idioma');
		return $fields[$field];	
	}
}
?>