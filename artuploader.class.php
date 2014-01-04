<?php


// TODO:
// - finish constructor for BaseObject
// - finish toJSON() for BaseObject
// - Decide objects
//



class BaseObject 
{
	protected $fields=array(); 
	protected $all_fields;
	protected $required_fields;
	protected $fields_defaults;
//	protected $attributes;
	protected $children=array(); // Child Objects
	protected $content; // Content of object (that is not a child object)

	public function __construct($array) {

		foreach($properties as $key => $value){
		        $this->{$key} = $value;
		}
	}
}

class Section extends BaseObject 
{
	protected $fields;
	protected $all_fields=array('Article', 'name');
	protected $required_fields=array('Article');
	protected $fields_defaults=array("Article"=>null, "name"=>"News");
	
	public function __construct($array){
		foreach($array as $key =>$value){
			echo "key";
			var_dump($key);
			echo "calue";
			var_dump($value);
		}
	}


}
class Article extends BaseObject
{
//	protected $fields;
	protected $all_fields=array('Headline', 'Subheadline', 'Author', 'Date', 'Image', 'Text', 'Blockquote');
	protected $required_fields=array('Headline', 'Text');
//	protected $fields_defaults=array('Headline'=>null, 'Subdheadline'=>'blah blah blah', 'Author'=>'felix', 'Date'=>str(strtotime("now")), 'Image'=>null, 'Text'=>null, 'Blockquote'=>null);
//	protected $attributes=null;
	protected $children;

	public function __construct($array) {
		foreach($array as $key=> $value){
		if(!array_key_exists($key, $this->fields))
		{
		$this->fields["$key"]=$value;
		
		}
		var_dump($this->fields);

		}


	}

}



?>
