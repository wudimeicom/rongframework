<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2011 Yang Qing-rong
 * This is a free software.
 */

require_once 'Rong/Controller/Abstract.php';
require_once 'Rong/Controller.php';
require_once 'Rong/Exception.php';
require_once 'Rong/URI.php';
class Rong_Controller_Engine extends Rong_Controller_Abstract 
{
	public $controllersDirectory;
	public $viewsDirectory;
	public $modelsDirectory;
	
	/**
	 * Enter description here...
	 *
	 * @var Rong_URI
	 */
	public $uri;
	/**
	 * 
	 * Enter description here ...
	 * @var Rong_Controller_Route
	 */
	public $route;
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
	 * @return the $modelsDirectory
	 */
	public function getModelsDirectory() {
		return $this->modelsDirectory;
	}

	/**
	 * @param field_type $modelsDirectory
	 */
	public function setModelsDirectory($modelsDirectory) {
		$this->modelsDirectory = $modelsDirectory;
	}

	public function __construct(  )
	{
		$this->uri = new Rong_URI(  ); //the only one instance
	
		parent::__construct(  );
	}
	//remove uri prefix
	/*
	public function removeURLPrefix( $prefix )
	{
		$this->uri->removePrefix($prefix);
	}*/
	
	public function setRoute( $route )
	{
		$this->route = $route;	
	}
	
	public function setControllersDirectory( $newControllersDirectory )
	{
		$this->controllersDirectory = $newControllersDirectory;
		
	}
	
	private function runRoute()
	{
		if( isset( $this->route ) )
		{
			$this->uri = $this->route->replace( $this->uri );
		}
	}
	
	public function start(  )
	{
		$this->runRoute();
		 
		$path = $this->uri->getPathWithoutQueryString();
		
		$pathArr = explode( "/" , $path );
		// print_r( $pathArr );
		$dir = $this->controllersDirectory;
		for( $i=1; $i< count( $pathArr ); $i++ )
		{
			//echo $dir ;
			$curItem = $pathArr[$i];
			if( is_dir( $dir . "/" . $curItem  ) )
			{
				//echo "dir:" . $dir . "/". $curItem;
				$dir .= "/" . $curItem;
				$nextItem = @$pathArr[$i+1];
				if( trim( $nextItem ) == "" )
				{
					$controllerName =  "Index"  ;
					$controllerName .= "Controller";
					$actionName =  "index" ;
					$actionName .= "Action";
					
					$controllerFileName = $dir . "/" . $controllerName . ".php";
					if( file_exists( $controllerFileName ) )
					{
						require_once $controllerFileName;					
						$this->runController($controllerName, $actionName, $i);
						return true;
					}
					else 
					{
						$this->callErrorController( $controllerName  );
					}
				}
			}
			elseif( is_file( $dir . "/" . $curItem . "Controller.php" ) )
			{
				require_once( $dir . "/" . $curItem . "Controller.php" );
				$controllerName = $curItem . "Controller";
				$actionName = @$pathArr[$i+1];
				if( $actionName == "") $actionName = "index";
				$actionName .= "Action";
				
				$this->runController($controllerName, $actionName, $i);
				 
				return true;
			}
			else 
			{
				// this item is no a controller or a folder
				$this->callErrorController( $curItem  );
				break;
			}
			
		}//end for
	
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

	public function runController( $controllerName, $actionName, $controllerNameIndex )
	{
		/**
		 * 
		 * Enter description here ...
		 * @var Rong_Controller
		 */
		$controllerObj  = new $controllerName();
		$this->uri->setControllerNameIndex( $controllerNameIndex );
		if( method_exists( $controllerObj, "setUri" ) )
		{
			$controllerObj->setUri( $this->uri );
		}
		
		if( method_exists( $controllerObj , "setControllersDirectory" ) )
		{
			$controllerObj->setControllersDirectory( $this->getControllersDirectory() );;
		}
		
		if( method_exists( $controllerObj , "setModelsDirectory" ) )
		{
			$controllerObj->setModelsDirectory( $this->getModelsDirectory() );
		}
		
		if( method_exists( $controllerObj , "setViewsDirectory" ) )
		{
			$controllerObj->setViewsDirectory( $this->getViewsDirectory() );
			 
		}
		if( method_exists( $controllerObj , "setTagsDirectory" ) )
		{
			$controllerObj->setTagsDirectory( $this->getTagsDirectory() );
			 
		}
		
		if( method_exists( $controllerObj , "init" ) )
		{
			$controllerObj->init();
		}
		
		$controllerObj->$actionName();
		return $controllerObj;
	}
	
	/**
	 * @return the $controllersDirectory
	 */
	public function getControllersDirectory() {
		return $this->controllersDirectory;
	}

	public function callErrorController( $controllerName )
	{
		$controllerFileName = $this->controllersDirectory . "/ErrorController.php";
		
		if( file_exists( $controllerFileName ))
		{
			require_once $controllerFileName;
			$ex= new Rong_Exception( "Controller \"" . $controllerName . "\" Not Found.");
			//$this->setObject( "Error" , $ex );
			
			$this->runController("ErrorController" , "indexAction", 0 );
			//$errorController = new ErrorController();
			//if( method_exists( $errorController , "init" ) )
			//{
			//	$errorController->init();
			//}
			// echo "helo";
			// print_r( $errorController );
			//$errorController->indexAction();	
		}
		else 
		{
			throw new Rong_Exception( "Controller \"" . $controllerName . "\" Not Found.need ErrorController.php!");
		}
	}
}
?>