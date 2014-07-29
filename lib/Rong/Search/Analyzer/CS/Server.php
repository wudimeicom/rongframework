<?php
require_once "Rong/Search/Analyzer.php";

class Rong_Search_Analyzer_CS_Server{
	public $host;
	public $port;
	public $driver;
	public $config;
	public function __construct($host="127.0.0.1", $port=5050){
		$this->host = $host;
		$this->port = $port;	
		$this->init();
	}
	
	public function init(){  
	    $commonProtocol = getprotobyname("tcp");  
	    $socket = socket_create(AF_INET, SOCK_STREAM, $commonProtocol);  
	    socket_bind($socket, $this->host, $this->port );   
	    socket_listen($socket);  
	    $this->socket = $socket;
		
		
	}
	
	public function start(){  
	    //初始化buffer  
	   
	    static $analyzer;
	  	if( !is_object( $analyzer ) )
		{
		    $analyzer = Rong_Search_Analyzer::factory( $this->driver, $this->config );
		} 
			 
	    while(true) {  
	        //接受一个Socket连接  
	        $connection = socket_accept($this->socket);  
	        printf("Socket connected\r\n");  
	      
	          
	      	$txt = "";
	       
	        while($data = socket_read($connection, 4096, PHP_BINARY_READ))  
	        {  
				$txt .= $data."";
				 break;
	        }  
			$ks = $analyzer->analyze( $txt );
	           
	           
			$res= json_encode( $ks);
			$res = base64_encode( $res );
			$res .= "\r\n";
	        socket_write($connection,$res ,strlen( $res ));  
	           
	        socket_close($connection);  
	        printf("Closed the socket\r\n\r\n");  
	    }  
	}
	

}
