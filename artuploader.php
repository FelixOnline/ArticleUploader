<?php



$xmlDoc=getXML();
$array = json_decode(json_encode(simplexml_load_string($xmlDoc)), TRUE); //Simplest way to turn into an array :)
var_dump($array);











function getXML($resource=null) {

//Temporary xml gathering for example
	
	$path="examples"; // /path/to/directory
	$xml_files=array();
	$xmlHead='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$xml="";
	foreach (glob("$path/[0-9]*-[a-zA-z]*.xml") as $filepath) {
		$file=file_get_contents($filepath);
		$xml.=preg_replace("/<\?xml.*?>/", "", $file);
		
	}
	
	return $xmlHead.$xml;
}







?>
