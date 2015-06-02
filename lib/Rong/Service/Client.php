<?php
require_once 'Rong/Object.php';
require_once 'Rong/Net/HttpClient.php';
require_once 'Rong/Crypto/SwapBit.php';
require_once "Rong/Logger.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Rong_Service_Client{
    
    public $cookie_directory;
    public $server_url;
    public $password;
	public $postArray;
	public $class;
	public $content;//content returned
	public $server_message;
	public $logger;
    public function __construct( $server_url ) {
        $this->server_url = $server_url;
		$this->logger =  Rong_Logger::getLogger();
    }
    
	
	
    public function __call($name, $arguments) {
        return $this->request($name, $arguments);
    }
    
	public function setClass( $cls )
	{
		$this->class = $cls;
	}
	
	/**
	 * @param array $arguments array($arg1,$arg2,$arg3,...)
	 */
    public function request( $function ,$arguments  ){
    	
        $httpClient = new Rong_Net_HttpClient();
        if( trim( $this->cookie_directory ) != "" )
        {
            $httpClient->cookieDir = $this->cookie_directory;
        }
        
        $requestArray = array(
            "function" => $function  ,
            "arguments" => $arguments  ,
            "class" => $this->class
        );
        // print_r( $requestArray );
        $requestJson = json_encode($requestArray  );
       
        $swapBit = new Rong_Crypto_SwapBit();
        if( trim( $this->password ) != "" )
        {
            $requestJson = $swapBit->encrypt( $requestJson , $this->password );
        }
        $postArray = array("json_data" => $requestJson  );
		if( !empty( $this->postArray ))
		{
			foreach(  $this->postArray as $k => $v )
			{
				$postArray[$k] = $v;
			}
		}
		
		//print_r( $postArray );
        $response = $httpClient->request($this->server_url, "POST", $postArray);
       
        $content = $httpClient->getContent();
       
        if( isset( $GLOBALS["debug"]))
        {
            echo "<br />----{Rong_Service_Client \$content}---------start<br />";
            echo $content;
            echo "<br />----{/Rong_Service_Client \$content}---------end<br />";
        }
        
        $gc_tag_s = "[Rong.Service.Server@wudimei.com]";
        $gc_tag_e = "[/Rong.Service.Server@wudimei.com]";
        $gc_pos_s = strpos( $content , $gc_tag_s);
        $gc_pos_e =  strpos( $content , $gc_tag_e);
        if( $gc_pos_s !== false && $gc_pos_e !== false){
        	$content = substr($content,$gc_pos_s+strlen($gc_tag_s),$gc_pos_e-$gc_pos_s-strlen($gc_tag_s));
        	
        }
        
        $this->content = $content;
       
        if( trim( $this->password ) != "" ){
            $content = $swapBit->decrypt( $content , $this->password );
        }
        $returnArr = json_decode( $content , true );
       	// print_r( $returnArr );
		if( !is_array( $returnArr ) )
		{
			$this->logger->error("can not decode the content,may be password incorrect");
		}
       	$this->server_message = $returnArr["msg"];
       	
        return $returnArr["return"];
    }

	public function getServerMessage()
	{
		return $this->server_message;
	}
}
?>
