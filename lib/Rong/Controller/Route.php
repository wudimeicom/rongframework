<?php
require_once 'Rong/Controller/Abstract.php';
require_once 'Rong/Exception.php';
require_once 'Rong/URI.php';
class Rong_Controller_Route extends Rong_Controller_Abstract 
{
	public $patterns = array( );
	public $replacements = array( );
	
	public function __construct( )
	{
		parent::__construct();
	}
	
	public function add( $pattern , $replacements )
	{
		$pattern = str_replace( "/" , "\/" , $pattern );
		$pattern = str_replace(":num", "(\d+)" , $pattern );
		$pattern = str_replace( ":word" , "(\w+)" , $pattern );
		$pattern = str_replace( ":any" , "(.+)" , $pattern );
		$replacements = str_replace("$" ,"\\" , $replacements );
		$this->patterns[] = "/".$pattern . "/i" ;
		$this->replacements[] = $replacements;
	}
	
	/**
	 * 
	 * thie function called by Rong_Controller_Engine
	 * @param Rong_URI $uri
	 * @return Rong_URI
	 */
	public function replace( $uri )
	{
		$uri->path = preg_replace( $this->patterns , $this->replacements , $uri->path );
		$uri->uriToGET( $uri->path );
		return $uri;
	}
	
	
}
?>