<?php
require_once 'Rong/Controller/Route.php';
require_once 'Rong/URI.php';
require_once 'Rong/Html/SimpleMessage.php';

class Rong_ModuleDispatcher
{
	public $modulesDirectory = "";
	public $modules = array();
	/**
	 * Enter description here...
	 *
	 * @var Rong_URI
	 */
	public $uri;
	public $defaultPage = "";
	public function __construct(  )
	{
		$this->uri = new Rong_URI(  ); //the only one instance
		
	}
	
	public function setModulesDirectory( $dir ){
		$this->modulesDirectory = $dir;
	}
	
	public function setDefaultPage( $uri )
	{
		$this->defaultPage = $uri;
	}
	
	public function getDefaultPage(  )
	{
		return $this->defaultPage  ;
	}
	
	public function setModules( $modules )
	{
		$this->modules = $modules;
	}
	
	public function start(){
		$cfgs = array();
		$cfgs = $this->loadModuleConfigs();
		//print_r( $cfgs );
		$route = new Rong_Controller_Route();
		foreach ($cfgs as $module => $cfg ) {
			$uriArray = $cfg["uri"];
			foreach ($uriArray as $uriName => $routeArr ) {	 
				$route->add( $routeArr["pattern"] , "/". $module . "/" . $routeArr["match"] );
			}
		}
		
		$this->uri = $route->replace( $this->uri );
		$path = $this->uri->getPathWithoutQueryString();
		 
		if( $path == "/" )
		{
			$path = "/index/Index/index";//default index module
		}
		$pathArr = explode( "/" , $path );
		
		//print_r( $pathArr );
		$cur_module = $pathArr[1];
		$dir = $this->modulesDirectory . "/" . $cur_module . "/controllers"  ;
		
		if( !is_dir( $dir ) )
		{
			
			//$this->callErrorController( $cur_module );
			//exit();
		}
		define("MODULE_DIRECTORY", $this->modulesDirectory . "/" . $cur_module );
		//echo "hi";
		//echo MODULE_DIRECTORY;
		//echo $dir;
		for( $i=2; $i< count( $pathArr ); $i++ )
		{

			$curItem = $pathArr[$i];
			
			//sub folder in module's controllers dirctory,eg:/modules/guestbook/controllers/admin/FeedbackController.php
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
						$this->runController($controllerName, $actionName, $i , $cur_module );
						return true;
					}
					else 
					{
						
						$this->callErrorController( $controllerName ,__CLASS__." 001:file(".$controllerFileName.") not found!" );
					}
				}
			}
			elseif( is_dir(  dirname( $dir ) . "/" . $curItem ) ) //sub module  directory
			{
				$controllerName = @$pathArr[$i+1];
				$actionName = @$pathArr[$i+2];
				$controllerFile = dirname( $dir ) . "/" . $curItem . "/controllers/" . $controllerName . "Controller.php";
				//echo $controllerFile;
				if( file_exists( $controllerFile) )
				{
					require_once $controllerFile;
					$controllerClassName = $controllerName . "Controller";
					if( $actionName == "") $actionName = "index";
					$actionName .= "Action";
					$this->runController($controllerClassName, $actionName, $i +1 , $cur_module . "/" . $curItem );
				}
				else{
					throw  new Rong_Exception( "Rong_Module_Dispatcher(Error 1): File not found:". $controllerFile ,1 );
				}
				exit();	
			}
			elseif( is_file( $dir . "/" . $curItem . "Controller.php" ) )
			{
				require_once( $dir . "/" . $curItem . "Controller.php" );
				$controllerName = $curItem . "Controller";
				$actionName = @$pathArr[$i+1];
				if( $actionName == "") $actionName = "index";
				$actionName .= "Action";
				
				$this->runController($controllerName, $actionName, $i , $cur_module );
				 
				return true;
			}
			else 
			{
				// this item is no a controller or a folder
				$this->callErrorController( $curItem , __CLASS__." 002:other error" );
				break;
			}
			
		}//end for
		
	}
	
	
	
	public function runController( $controllerName, $actionName, $controllerNameIndex , $module )
	{
		/**
		 * 
		 * Enter description here ...
		 * @var Rong_Controller
		 */
		 
		$pathArr = explode( "/" , $this->uri->getPathWithoutQueryString() );
		 
		for( $i=$controllerNameIndex + 2; $i< count( $pathArr ); $i+=2 )
		{
			$_GET[ $pathArr[$i]] = @$pathArr[$i+1];
		}
		
		$controllerObj  = new $controllerName();
		$this->uri->setControllerNameIndex( $controllerNameIndex );
		if( method_exists( $controllerObj, "setUri" ) )
		{
			$controllerObj->setUri( $this->uri );
		}
		
		
		
		if( method_exists( $controllerObj , "setModelsDirectory" ) )
		{
			$controllerObj->setModelsDirectory( $this->modulesDirectory . "/" . $module  . "/models");
		}
		
		if( method_exists( $controllerObj , "setViewsDirectory" ) )
		{
			
			$controllerObj->setViewsDirectory( $this->modulesDirectory . "/" . $module  . "/views" );
			 
		}
		if( method_exists( $controllerObj , "setTagsDirectory" ) )
		{
			$controllerObj->setTagsDirectory( $this->modulesDirectory . "/" . $module  . "/tags"  );
			 
		}
		
		if( method_exists( $controllerObj , "init" ) )
		{
			$controllerObj->init();
		}
		
		$controllerObj->$actionName();
		return $controllerObj;
	}

	private function loadModuleConfigs()
	{
		$cfgs = array();
		
		for( $i=0; $i< count( $this->modules ); $i++ )
		{
			$module = $this->modules[$i];
			$file = $this->modulesDirectory . "/" . $module . "/config.php" ;
			if( file_exists( $file ) )
			{
				include $file;
				$cfgs[ $module ] = $CFG;
			}
		}
		return $cfgs;
	}
	
	public function callErrorController( $controllerName , $msgText = "" )
	{
		header("HTTP/1.0 404 Not Found",true ,404 ); 
		$msg = "controller '". $controllerName . "'s not found! <br />uri:" . $this->uri->path;	
		if( $msgText != "" )
		{
			$msg = $msgText .= " <br />uri:" . $this->uri->path;	
		}
		$msgBox = new Rong_Html_SimpleMessage();
		if( $this->defaultPage != "" )
		{
			$msgBox->setRedirectionUri( $this->defaultPage );
		}
		else{
			$msgBox->setRedirectionUri("javascript:history.back();");
		}
		$msgBox->show( $msg  , "Not Found");
	}
}
