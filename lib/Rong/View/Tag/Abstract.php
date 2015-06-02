<?php
abstract class Rong_View_Tag_Abstract extends Rong_Object 
{
	
	public $tagsDirectory = "" ;
	public function __construct( )
	{
		
	}
	
	
	
	/**
	 * @return the $tagsDirectory
	 */
	public function getTagsDirectory() {
		if( $this->tagsDirectory == "" )
		{
			return null;
		}
		else 
		{
			return $this->tagsDirectory;
		}
	}

	/**
	 * @param field_type $tagsDirectory
	 */
	public function setTagsDirectory($tagsDirectory) {
		$this->tagsDirectory = $tagsDirectory;
	}

	public function tagNameToArray( $tagName )
	{
		$arr = array();
		if( strpos( $tagName , "." ) !== false )
		{
			list( $arr["class"] , $arr["method"] ) = explode( "." , $tagName );
		}
		else
		{
			$arr["class"] = $tagName ;
			$arr["method" ] = "index" ;
		}
		return $arr ;
	}
	
	
	
}
?>