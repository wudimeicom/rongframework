<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */

class Rong_URI extends Rong_Object 
{
	public  $path;
	public $type = "";
	public $baseUrl;
	public $paramsArray;
	public $controllerNameIndex = 0;
	public function __construct(   )
	{
		$type = "";
		$items = array();

		$baseUrl = dirname( str_replace( $_SERVER["DOCUMENT_ROOT"] , "", $_SERVER["SCRIPT_FILENAME"] ) ); 
		$baseUrl = str_replace("\\", "/", $baseUrl );
	    
		if( $baseUrl == "/" ) // fix the bug in the linux enviroment
	    {
	    	$baseUrl = "";
	    }
	    
	    
	    // echo $baseUrl;
	    $this->baseUrl = $baseUrl;
		if( isset( $_GET["do"] ) )
		{
			$this->path = @$_GET["do"];
			$type = "\$_GET['do']";
			 
		}
		elseif( isset( $_SERVER["ORIG_PATH_INFO"] ) && $_SERVER["ORIG_PATH_INFO"] != "" )
		{
			$this->path = $_SERVER['ORIG_PATH_INFO'];			
			$type = "\$_SERVER['ORIG_PATH_INFO']=" . $_SERVER['ORIG_PATH_INFO'];
		}
		elseif( isset( $_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !="" )
		{		
		    $uri = $_SERVER['REQUEST_URI'];	
		    // remove index.php of index.php/Controller/action
		    if( strpos( $uri  , $_SERVER["SCRIPT_NAME"] ) !== false &&
				strpos( $_SERVER["SCRIPT_NAME"] , ".php" ) !== false
		    )
		    {
		    	$uri = str_replace( $_SERVER["SCRIPT_NAME"] , "" , $uri );
		    }
		   // echo strlen( $baseUrl ) . "[$baseUrl]";
		   if( substr( $uri , 0 , strlen( $baseUrl ) ) == $baseUrl )
		   {
		 	   $uri = substr( $uri , strlen( $baseUrl ) );   
	       }
		    
			$this->path = $uri;
		   
			$type = "\$_SERVER['REQUEST_URI']=" . $_SERVER['REQUEST_URI'];
		}
		elseif( isset( $_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !="" )
		{			
			$this->path = $_SERVER['PATH_INFO'];			
			$type = "\$_SERVER['PATH_INFO']=" . $_SERVER['PATH_INFO'];
		}
		
		elseif( isset( $_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] !="" )
		{
			$this->path = $_SERVER['REDIRECT_URL'];
			$type = "\$_SERVER['REDIRECT_URL']=" . $_SERVER['REDIRECT_URL'];
		}
		
		elseif( isset( $_GET ) && key( $_GET )!="" )
		{
			$this->path = key( $_GET );
			$type = "\$_GET=" . key( $_GET );
		}
		 
		if( trim( $this->path ) == "" )
		{
			$this->path = "/";
		}
		//echo $this->path;
		//echo $type;
		// print_r( $_SERVER );
		$this->type = $type;
		
	}
	/*
	public function removePrefix( $prefix )
	{
		//echo $this->path . "<br />";
		if( $prefix != "" )
	    {
	    	//$this->path = substr( $this->path , strlen( $prefix ) );
	    }
	    //echo $this->path . "<br />";
	}*/
	
	public function setControllerNameIndex($index)
	{
		$this->controllerNameIndex = $index;
	}
	
	public function getPath( )
	{
		return $this->path;
	}
	
	public function getPathWithoutQueryString()
	{
		$uri = $this->path;
	    if( strpos( $uri , "?" ) !== false )
	    {
	    	$uArr = explode( "?" , $uri );
	    	$uri = @$uArr[0];
	    }
	    return $uri;
	}
	
	public function getType( )
	{
		return $this->type;
	}
	
	public function item( $index )
	{
		$uri = $this->path;
		$uriArr = explode( "?" , $uri );
		$arr = explode( "/" , $uriArr[0] );
		return @$arr[$index];
	}
	/*
	 * sample uri: /folder/Controller/action/paramName/paramValue/param2/value2
	 * if key is param2,so we return the string value2
	 */
	public function getParam( $key )
	{
		if( empty( $this->paramsArray ) )
		{
			$uri = $this->path;
			$uriArr = explode( "?" , $uri );
			$arr = explode( "/" , $uriArr[0] );
			for( $i= $this->controllerNameIndex +2; $i< count( $arr );  $i+=2 )
			{
				$this->paramsArray[$arr[ $i] ] = @$arr[ $i +1 ];
			}
		}
		
		return $this->paramsArray[$key];
		
	}
	/**
	 * 
	 * parse query string from $uri to $_GET Array,this function called by Rong_Controller_Route
	 * @param string $uri 
	 */
	public function uriToGET( $uri )
	{
		$urlArr = explode( "?" , $uri );
		if( isset( $urlArr[1] ) )
		{
			$qryStr = $urlArr[1];
			$kvArr = explode( "&" , $qryStr );
			for( $i=0; $i< count( $kvArr ); $i++ )
			{
				$kv = explode( "=" ,$kvArr[$i ] );
				$_GET[ $kv[0] ] = @$kv[1];
			}
		}
	}
}
?>