<?php

require_once("artuploader.class.php");

$xmlDoc=getXML();
$array = json_decode(json_encode(simplexml_load_string($xmlDoc)), TRUE); //Simplest way to turn into an array :)
var_dump($array));








function getXML($resource=null) {

//Temporary xml gathering for example
	$path="examples"; // /path/to/directory
	$xml_files=array();
	$xmlHead='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$xml="";
	foreach (glob("$path/[0-9]*-[a-zA-z]*.xml") as $filepath) {
		$file=file_get_contents($filepath);
		//Tidying up the xml
		$pattern=array("/<\?xml.*?>/",'/href="file:\/\/\/.[^>]*\.[a-zA-z]{3,4}"/', "/href_fmt/", '/\x{2029}/u' );
		$replace=array("", "","href", "\n\n");
		$xml.=preg_replace($pattern, $replace, $file);
		
	}
	return $xmlHead.$xml;
}


?>
