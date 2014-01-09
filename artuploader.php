<?php

$DIRPATH="examples";
$xmlDocs=getXML(null, $DIRPATH);
foreach($xmlDocs as $document)
{
	if (($document->getName())=="section"){
		$section=$document;
	} else {
		//	$section=$document->section;
		trigger_error("Incompatible file", E_USER_ERROR);
		continue;
	}
	foreach($section->article as $art) {
			//Add article category - default News
		$art->addChild('category',(isset($section->attributes()->title) ? $section->attributes()->title : "news"));
		//Add authors by username - if not username - default to felix - can be changed in before publish in engine
		//Then again= this logic might be better behind the api? Dunno.
		if( (bool) count($art->xpath("authors")) ){ // does the authors node exist?
			foreach ($art->authors->xpath('author') as $uname){
		
				//if string contains a number we assume it is a username and convert it to felix
				if (!(preg_match('#[\d]#',$uname) && $uname->getName()=="author")){
					$art->authors->addChild('author','felix');
					unset($uname);
					continue;
				}
			}
		} else {
			$art->addChild('authors');
			$art->authors->addChild('author','felix');
		}
		//Change image field to base64 for api and nest
		$images=array("img1","img2");
		foreach($images as &$value){
			if(isset($art->{$value})){
				if(isset($art->{$value}->image)){
					
					$filepath=$DIRPATH."/".$art->{$value}->image->attributes()->href;
					if(file_exists($filepath)){
						$finfo = finfo_open(FILEINFO_MIME_TYPE); //Sets finfo_open response to mime type of image
						$mime=finfo_file($finfo, $filepath);
						finfo_close($finfo);
					
						// TODO: Check to see if image is bigger than 3MB, if so, resize
						$img_data=base64_encode(file_get_contents($filepath));
						$filetype=explode(".",$filepath);
						$img_ext=end($filetype);
						$img_64='data:'.$mime.';base64,'.$img_data;
						$art->{$value}->image=$img_64;

					} else {
						unset($art->{$value});
						continue;
					}
				}
			}
		}
		// TODO: Set date to 0700 on closest friday
		$date = new DateTime();
		$art->date=$date->getTimestamp();
	}

	unset($section["title"]);
	file_put_contents("output.json",json_encode($section,JSON_PRETTY_PRINT));


}

	

function getXML($resource=null,$DIRPATH=null) {
	
//Temporary xml gathering for example - normally would check to see if handed xml or directory to files
	$path=$DIRPATH; // /path/to/directory
	$xml_files=array();
	/*$xmlHead='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';*/
	$xml=array();
	foreach (glob("$path/[0-9]*-[a-zA-z]*.xml") as $filepath) {
		$file=file_get_contents($filepath);
		//Tidying up the xml
		$pattern=array('/href="file:\/\/\/.[^>]*\.[a-zA-z]{3,4}"/', "/href_fmt/", '/\x{2029}/u', "/text>/", "/subheadline>/", "/headline>/", "/Author>/", "/Image>/", "/<Image/" );
		$replace=array( "","href", "\n\n", "content>", "teaser>", "title>", "authors>", "images>", "<images");
		$xml[]=simplexml_load_string(preg_replace($pattern, $replace, $file));
		
	}
	return $xml;
}


?>
