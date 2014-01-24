<?php

require_once 'Rong/Object.php';
abstract class Rong_View_Abstract extends Rong_Object
{
	public static $varArray;
	public $isCache = false;
	public $cacheFilename = "";
	public $cacheTimeout = 0;
	public $viewsDirectory;
	public $tagsDirectory;
	public $configArray = array(); 
	

	/**
	 * @return the $tagsDirectory
	 */
	public function getTagsDirectory() {
		return $this->tagsDirectory;
	}

	/**
	 * @param field_type $tagsDirectory
	 */
	public function setTagsDirectory($tagsDirectory) {
		$this->tagsDirectory = $tagsDirectory;
	}

	/**
	 * @return the $viewsDirectory
	 */
	public function getViewsDirectory() {
		return $this->viewsDirectory;
	}

	/**
	 * @param field_type $viewsDirectory
	 */
	public function setViewsDirectory($viewsDirectory) {
		$this->viewsDirectory = $viewsDirectory;
	}

	public function __construct( )
	{
		parent::__construct();
	}
	
	 
	 
	
 	public static function assign( $key , $value )
    {
             self::set( $key, $value );
    }
        
    public static function set( $key , $value )
    {
        self::$varArray[$key] = $value;	
		
    }
    
	public function setVar( $key,$value )
	{
		$this->data[$key] = $value;
	}

	public function tag( $tag )
	{
		
		require_once 'Rong/View/Tag/Tag.php';
		$tagObj = new Rong_View_Tag_Tag( );
		$tagObj->setTagsDirectory(   $this->getTagsDirectory()   );
		$tagObj->start( $tag );
	}
	
	public function cache( $filename , $timeout )
	{
		$this->cacheFilename = $filename;
		$this->cacheTimeout = $timeout;
		$this->isCache = true;

		$dir = dirname( $filename );
		if( ! is_dir( $dir ) )
    	{
    		mkdir( $dir , 0777 , true );
    	} 
    	
		$config = array(
			"cache_dir" => $dir 
		);
    	$cache = Rong_Cache::factory( "File" , $config );
    	if( $page = $cache->get(basename( $filename)))
    	{
    		echo $page;
    		exit();
    	}
	}
	
	public function saveCache( $filename , $timeout , $pageContent )
	{
		$dir = dirname( $filename );
    	 
	 
		$config = array(
			"cache_dir" => $dir 
		);
    	$cache = Rong_Cache::factory( "File" , $config );
    	$cache->set(basename( $filename ), $pageContent , $timeout , array(""));
	}
	
	public function setConfig( $configArray )
	{
		foreach ( $configArray as $k => $v )
		{
			$this->configArray[$k] = $configArray[$v];
		}
	}
	
	public function getConfig( $key )
	{
		return $this->configArray[$key];
	}
}