<?php


class Rong_Session_CookieFile implements SessionHandlerInterface
{
	private $config;
	public static $sessionId;
	public function __construct($config){
		$this->config = $config;
		
		
	}
	
	function open($savePath, $sessionName)
	{ 
		//if( is_dir( $savePath ) ){
			//$this->config["save_path"] = $savePath;
		//}
		if (!is_dir($this->config["save_path"])) {
			mkdir($this->config["save_path"], 0777,true);
		}
		
		return true;
	}

	function close()
	{
		
		return true;
	}

	function read($id)
	{
		static $hasClean = false;
		if( $hasClean == false ){
			$this->gc( $this->config["gc_maxlifetime"]);
			$hasClean = true;
			
		}
		$file = $this->config["save_path"]."/sess_".$id;
		$gc_maxlifetime =  $this->config["gc_maxlifetime"];
		if (@filemtime($file) + $gc_maxlifetime < time() && file_exists($file)) {
			unlink($file);
		}
		return (string)@file_get_contents( $file );
	}

	function write($id, $data)
	{
		return file_put_contents($this->config["save_path"]."/sess_".$id, $data) === false ? false : true;
	}

	function destroy($id)
	{
		$file = $this->config["save_path"]."/sess_".$id;
		if (file_exists($file)) {
			unlink($file);
		}

		return true;
	}

	function gc($maxlifetime)
	{
		foreach (glob($this->config["save_path"]."/sess_*") as $file) {
			if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
				unlink($file);
			}
		}

		return true;
	}
	
	
	function create_sid(){
		return md5( uniqid("").rand(1,10000) . microtime(true) );
	}
	
	
	public function start(){
		
		$session_name = @$this->config["session_name"];
		if( trim( $session_name ) == "" ){
			$session_name = "__WudimeiSessionID";
		}
		$sessionId = @$_COOKIE[$session_name];
		$secure = @$this->config['cookie_secure'];
		$httponly = @$this->config['cookie_httponly'];
		if( !isset( $sessionId) ){
			$sessionId = $this->create_sid();
			$expire = 0;
			$cookie_lifetime = $this->config["cookie_lifetime"];
			if(  $cookie_lifetime >0 ){
				$expire = time()+ $cookie_lifetime;
			}
			
			setcookie($session_name, $sessionId, $expire, $this->config["cookie_path"],$this->config["cookie_domain"],$secure,$httponly);
		}
		self::$sessionId = $sessionId;
	}
	
	public function put( $name,$value ){
		$data = $this->read( self::$sessionId );
		$data = unserialize( $data );
		$data[$name] = $value;
		$dataStr = serialize( $data);
		$this->write(self::$sessionId, $dataStr );
	}
	
	public function get( $name  ){
		$data = $this->all();
		return @$data[$name];
	}
	public function all(  ){
		$data_str = $this->read( self::$sessionId );
		$data = unserialize( $data_str );
		return $data;
	}
	
	public function delete( $name ){
		$data = $this->read( self::$sessionId );
		$data = unserialize( $data );
		unset( $data[$name]);
		$dataStr = serialize( $data);
		$this->write(self::$sessionId, $dataStr );
	}
	
}
