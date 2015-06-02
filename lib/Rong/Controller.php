<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://wudimei.com/yangqingrong
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Object.php';
require_once 'Rong/Import.php';
require_once 'Rong/View.php';
require_once 'Rong/Controller/Request.php';

class Rong_Controller extends Rong_Object 
{   
	/**
	 * Rong URI
	 *
	 * @var  Rong_URI
	 */
	public $uri;
	/**
	 * Rong Import
	 *
	 * @var Rong_Import
	 */
	public $import = null;
	/**
	 * Rong view object
	 *
	 * @var Rong_View
	 */
	public $view = null;
	
	/**
	 * Rong Controller Request
	 *
	 * @var Rong_Controller_Request
	 */
	public $request;

	public $controllersDirectory;
	public $viewsDirectory;
	public $modelsDirectory; 
	public $tagsDirectory;
	
	public function setTagsDirectory($tagsDirectory)
	{
		$this->tagsDirectory = $tagsDirectory;
	}
	
	public function getTagsDirectory()
	{
		return $this->tagsDirectory;
	}
	
	/**
	 * @return the $viewsDirectory
	 */
	public function getViewsDirectory() {
		return $this->viewsDirectory;
	}

	/**
	 * @return the $modelsDirectory
	 */
	public function getModelsDirectory() {
		return $this->modelsDirectory;
	}

	/**
	 * @param field_type $viewsDirectory
	 */
	public function setViewsDirectory($viewsDirectory) {
		$this->viewsDirectory = $viewsDirectory;
	}

	/**
	 * @param field_type $modelsDirectory
	 */
	public function setModelsDirectory($modelsDirectory) {
		$this->modelsDirectory = $modelsDirectory;
	}

	/**
	 * @return the $controllersDirectory
	 */
	public function getControllersDirectory() {
		return $this->controllersDirectory;
	}

	/**
	 * @param field_type $controllersDirectory
	 */
	public function setControllersDirectory($controllersDirectory) {
		$this->controllersDirectory = $controllersDirectory;
	}

	public function __construct( )
	{
		parent::__construct();
		$this->request = new Rong_Controller_Request(); 
                $this->request->removeMagicQuotes();
		
	}
	
	public function init()
	{
		if( $this->getViewsDirectory()  == "" )
		{
			$this->setViewsDirectory( dirname( $this->getControllersDirectory() ) . "/views" );
		}
		
		$this->view   = Rong_View::factory("PHP"); 
		 
		$this->view->setViewsDirectory( $this->getViewsDirectory() );
		
		if( trim( $this->getTagsDirectory() ) == "" )
		{
			$this->setTagsDirectory( dirname( $this->getControllersDirectory() ) . "/tags"  );
		}
		$this->view->setTagsDirectory( $this->getTagsDirectory() );
		
		
		
		$this->import = new Rong_Import();
		if( $this->getModelsDirectory() == "" )
		{
			$this->setModelsDirectory( dirname( $this->getControllersDirectory() ) . "/models" );
			
		}
		$this->import->setModelsDirectory( $this->getModelsDirectory() );
	}
	/**
	 * 
	 * Enter description here ...
	 * @param Rong_URI $uri
	 */
	public function setUri( $uri )
	{
		$this->uri = $uri;	
	}
	
	public function __call( $name , $args )
	{
		
		throw new Rong_Exception( "Action \"". str_replace( "Action", "", $name ) . "\" not found." );
			
	}
}
?>