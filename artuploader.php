<?php

require_once("artuploader.class.php");

$xmlDoc=getXML();
$array = json_decode(json_encode(simplexml_load_string($xmlDoc)), TRUE); //Simplest way to turn into an array :)
//var_dump($array);
$Articles=array();
// Since this is a POC and the xml is variable to change, we're gonna hack it :)

foreach($array as $key =>$value){
	if($key=="Article"){
		$Articles=$value;
		//$Articles[$key]["section"]=$array["@attributes"]["name"];

	}
}

//file_put_contents("articles.txt",print($Articles));
//file_put_contents("articles-inner.txt",print($Articles[0]));

	var_dump($Articles);
foreach($Articles as $k => &$v){

//echo "ARTICLE\n";		
	foreach($v as $key=>&$value){
//echo "value";		
//		var_dump( $value) ;
//		var_dump($value['authors']);
		//Change Author Field
		if($key=="authors"){		
			if(is_string($value)){//If there is only one author we need to JSONify by adding an "author" key
				$auth_name=$value;
				$value=array(array("author"=>$auth_name));
			} elseif(is_array($value)) {// If author has a list of names we want to jsonify by giving them an "author" key
				$author_array=array();
				foreach($value as $name){	
					$author_array[]=array("author"=>$name);
				}
				$value=$author_array;
			}

		}
		//Change image field to base64 for api and nest
		if($key=="images"){
			if(array_has_key_attributes) //then must only be one image

		


		}
	}	
unset($value);	

}	
var_dump($Articles);
file_put_contents("output.json",json_encode($Articles));





function getXML($resource=null) {

//Temporary xml gathering for example
	$path="examples"; // /path/to/directory
	$xml_files=array();
	$xmlHead='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$xml="";
	foreach (glob("$path/[0-9]*-[a-zA-z]*.xml") as $filepath) {
		$file=file_get_contents($filepath);
		//Tidying up the xml
		$pattern=array("/<\?xml.*?>/",'/href="file:\/\/\/.[^>]*\.[a-zA-z]{3,4}"/', "/href_fmt/", '/\x{2029}/u', "/Text>/", "/Headline>/", "/Subheadline>/", "/Author>/", "/Image>/", "/<Image/" );
		$replace=array("", "","href", "\n\n", "content>", "title>", "teaser>", "authors>", "images>", "<images");
		$xml.=preg_replace($pattern, $replace, $file);
		
	}
	return $xmlHead.$xml;
}


?>
