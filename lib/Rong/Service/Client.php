<?php
require_once 'Rong/Object.php';
require_once 'Rong/Net/HttpClient.php';
require_once 'Rong/Crypto/SwapBit.php';
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
    public function __construct( $server_url ) {
        $this->server_url = $server_url;
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
        $this->content = $content = $httpClient->getContent();
        if( isset( $GLOBALS["debug"]))
        {
            echo "<br />----{Rong_Service_Client \$content}---------start<br />";
            echo $content;
            echo "<br />----{/Rong_Service_Client \$content}---------end<br />";
        }
        if( trim( $this->password ) != "" ){
            $content = $swapBit->decrypt( $content , $this->password );
        }
        $returnArr = json_decode( $content , true );
       	//print_r( $returnArr );
       	$this->server_message = $returnArr["msg"];
        return $returnArr["return"];
    }

	public function getServerMessage()
	{
		return $this->server_message;
	}
}
?>
