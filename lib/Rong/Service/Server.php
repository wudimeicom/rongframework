<?php
require_once 'Rong/Crypto/SwapBit.php';
require_once 'Rong/Controller/Request.php';

class Rong_Service_Server{
    
    public $functions;
    public $classes;
    public $password;
    /**
     * 
     * @param string $functon_name
	 * @return UTF-8 string
     */
    public function addFunction( $functon_name )
    {
        $this->functions[$functon_name] = $functon_name;
    }
    /**
     * 
     * @param string $className
     * @param string|mixed $classNameOrInstance
	 * @return UTF-8 string
     */
    
    public function addClass( $className , $classNameOrInstance )
    {
        $this->classes[ $className ] = $classNameOrInstance;
    }
    
    public function start(){
    	
		$msg = "";
		
		$reqObj = new Rong_Controller_Request();
		$reqObj->removeMagicQuotes();
		
        $json_data =  @$_REQUEST["json_data"]  ;
        
        if( !isset( $_REQUEST["json_data"] ) )
		{
			if( isset( $_POST["json_data"]))
			{
				$json_data = $_POST["json_data"];
			}
		}
		
        $swapBit = new Rong_Crypto_SwapBit();
        if( trim( $this->password ) != "" )
        {
            $json_data = $swapBit->decrypt( $json_data , $this->password );
        }
		
        $request = json_decode( $json_data  , true  );
		if( empty( $request) )
		{
			$msg .= "007,request empty,please remove magic_quotes on the server side.";
		} 
		 
        $function =  $request["function"];
        $arguments = $request["arguments"];
        $class =  trim( @$request["class"] );
		
		
        $return = null;
		 
		
		
        if(function_exists( $function ) && isset( $this->functions[ $function ]) && $class == "" )
        {
    
            $return = call_user_func_array( $function ,  $arguments  );
			
        }
		elseif( !function_exists( $function ) && !isset( $this->functions[ $function ]) && $class == "")
		{
			 
            if( !empty( $this->classes )){
            	$found = false;
                foreach( $this->classes as $className => $instance )
                {
                    if(method_exists( $instance , $function ))
                    {
                        $return = call_user_func_array( array( $instance , $function), $arguments );
                        $found = true;
                    }
					
                }
				if( $found == false ) $msg .= "002,method not found!";
            }
			else{
				$msg .="003,no instances,try \$server->addClass('className',\$instance ); ";
			} 
		}
        else{
        	
			if( isset( $this->classes[ $class ] ) )
			{
	            $instance = $this->classes[ $class ];
			    if(method_exists( $instance , $function ))
		        {
		            $return = call_user_func_array( array( $instance , $function), $arguments );
		            
		        }
				else{
					$msg .= "004,method not found! ";
				}
			}
			else{
				$msg .= "005,class '$class' not found! ";
			}
        }
		if( isset( $this->functions[ $function ]) == false )
		{
			$msg .= "008,function or method '$function(...)' does not exists in functions list.";
		}
		
		if( $return == null )
		{
			$msg .= "006,return null";
		}
		$returnJsonArr = array();
		$returnJsonArr["msg"] = $msg;
		$returnJsonArr["return"] = $return;
		
		
		$returnJson = json_encode( $returnJsonArr );
		
        if( trim( $this->password ) != "" )
        {
            echo $swapBit->encrypt( $returnJson, $this->password );
        }
        else{
            echo $returnJson;
        }
    }
}
?>
