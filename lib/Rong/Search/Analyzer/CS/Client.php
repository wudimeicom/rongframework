<?php
class Rong_Search_Analyzer_CS_Client{
	public $server;
	public $port;
	public function __construct($server = "127.0.0.1",$port=5050){
		$this->server = $server;
		$this->port = $port;
	}
	public function segment($text){
		// 创建 socket  
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
		  
		//链接 socket  
		$connection = socket_connect($socket,$this->server, $this->port);  
	 
		  
		
		//写数据到socket缓存  
		if(!socket_write($socket, $text."\r\n")){  
		    printf("Write failed");  
		}  
		  
		//读取指定长度的数据  
		while($buffer = socket_read($socket, 4096, PHP_BINARY_READ)){  
		    
			break;
		}  
		
		socket_close($socket);
		$buffer = base64_decode($buffer);
		$arr = json_decode( $buffer,true );
		return $arr;
	}
}
