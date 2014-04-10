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
	
	function localization($text = null){
		if(isset($text)){
			$trans = array("<a>" => " ", "</a>" => ". ","<b>" => " ", "</b>" => ". ","<c>" => " ", "</c>" => ". ","<t>" => " ", "</t>" => ". ");
			$text = strtr($text, $trans);
			return $text;
		}
		return null;
	}
	
	function author($text = null){
		if(isset($text)){
			$arr = explode(";", $text);
			$text = '';
			$temp1 = null;
			$temp2 = null;
			foreach($arr as $item){
				if(trim($item) != ''){
						
						$temp1 = array($this->getTagContent($item, 's1'),$this->getTagContent($item, 's2'),$this->getTagContent($item, 's3'), $this->getTagContent($item, 'c'), $this->getTagContent($item, 'p'));
						$temp2 = null;
						
						foreach($temp1 as $t){
							if($t != '' && $t != 's.af' && $t != null){
								$temp2[] = $t;
							}
						}
						if(!empty($temp2)){
							$temp1 = ' ('.implode(', ',$temp2).') ';
						}else{
							$temp1='';
						}
						$text = $text.$this->getTagContent($item, '*').$temp1.'; ';
				}
			}
			return substr($text,0,(strlen($text)-2));
		}
		return null;
	}
	
	function authorSAf($text = null){
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
	
	function summary($text = null){
		if(isset($text)){
			$trans = array("<i>" => "(", "</i>" => ")");
			$text = strtr($text, $trans);
			return $text;
		}
		return null;
	}
	
	function desc($text = null){
		if(isset($text)){
			$tokens = explode(";", $text);
			$text = null;
			$s = null;
			foreach($tokens as $token){
				if(trim($token) != ''){
					$s = $this->getTagContent($token,'s');
					if(trim($s)==''){
						$s = '';
					}else{
						$s = ' / '.$s;
					}
					$text[] = $this->getTagContent($token,'d').$s;
				}
			}
			return $text;
		}
		return null;
	}
	
	function authKeyWords($text = null){
		if(isset($text)){
			$tokens = explode(";", $text);
			$text = null;
			$i = null;
			$s = null;
			foreach($tokens as $token){
				if(trim($token) != ''){
					$s = $this->getTagContent($token,'s');
					$i = ' ('.$this->getTagContent($token,'i').')';
					if(trim($s)==''){
						$s = '';
					}else{
						$s = ' / '.$s;
					}
					$text[] = $this->getTagContent($token,'*').$s.$i;
				}
			}
			return $text;
		}
		return null;
	}
	
	function limits($text = null){
		if(isset($text)){
			$tokens = explode(";", $text);
			$text = null;
			foreach($tokens as $token){
				if(trim($token) != ''){
					$text[] = trim($token);
				}
			}
			return $text;
		}
		return null;
	}
	
	function typePub($text = null){
		if(isset($text)){
			$tokens = explode(";", $text);
			$text = null;
			foreach($tokens as $token){
				if(trim($token) != ''){
					$text[] = trim($token);
				}
			}
			return $text;
		}
		return null;
	}
	
	function url($text = null){
		if(isset($text)){
			return $this->getTagContent($text,'u');
		}
		return null;
	}
	
	function language($text = null){
		if(isset($text)){
			$text = explode(';',$text);
			return $text;
		}
		return null;
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
}
?>