<?php

/**
 * @author Fidel Santana Morell
 * @copyright 2013
 */

App::uses('CakeTime', 'Utility');

class Utils {

	function file_get_contents_curl($url) {
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
	
		$data = curl_exec($ch);
		curl_close($ch);
	
		return $data;
	}
	
	function http_response($url, $json)
	{
		$ch = curl_init();

		$arr = array();
		array_push($arr, "Content-Type: application/json; charset=UTF-8");
		array_push($arr, "Content-Length: ".strval(strlen($json)));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
		curl_setopt($ch, CURLOPT_URL, $url);

		//Bulk imports to CouchDB use POSTS instead of PUTS
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		$out = curl_exec($ch);
		curl_close($ch);

		//Some *very* simple error detection, just in case CouchDB throws an error our way.
		//Don’t rely on this at all!
		if (preg_match("/error/",$out)!=0)
		{
			//echo $out;
			echo "Error: ".$out;

		}
	}

	function subtractHours($interval1, $interval2){
		$horai=substr($interval1,0,2);
		$mini=substr($interval1,3,2);
		$segi=substr($interval1,6,2);

		$horaf=substr($interval2,0,2);
		$minf=substr($interval2,3,2);
		$segf=substr($interval2,6,2);

		$ini=((($horai*60)*60)+($mini*60)+$segi);
		$fin=((($horaf*60)*60)+($minf*60)+$segf);

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=floor(($dif-($difh*3600))/60);
		$difs=$dif-($difm*60)-($difh*3600);
		return CakeTime::format("H:i:s", mktime($difh,$difm,$difs));
	}
}