<?php


class Rong_Session_File implements SessionHandlerInterface
{
	private $config;
	
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
			//$this->gc( $this->config["gc_maxlifetime"]);
			$hasClean = true;
			
		}
		return (string)@file_get_contents( $this->config["save_path"]."/sess_".$id );
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
		return md5( uniqid("").rand(1,10000). microtime(true) );
	}
	
	public function start(){
		$session = $this;
		$config = $this->config;
		session_set_save_handler(
				array(&$session,"open"), 
				array(&$session,"close"),
				array(&$session,"read"),
				array(&$session,"write"),
				array(&$session,"destroy"),
				array(&$session,"gc"),
				array(&$session,"create_sid")
		);
		 
		//session_set_save_handler($session, true);
		
		 register_shutdown_function('session_write_close');
		
		ini_set("session.gc_maxlifetime",$config["gc_maxlifetime"]);
		ini_set('session.use_cookies',   1);
		ini_set('session.cookie_path', $config["cookie_path"]);
		ini_set("session.cookie_domain",$config["cookie_domain"]);
		ini_set('session.cookie_lifetime', $config["cookie_lifetime"]);
			
		session_set_cookie_params ( $config["cookie_lifetime"], $config["cookie_path"], $config["cookie_domain"], $secure = false  ,  $httponly = false  );
		session_start();
	}
	
	public function put( $name,$value ){
		@$_SESSION[$name] = $value;
	}
	
	public function get( $name  ){
		return @$_SESSION[$name];
	}
	
	public function all(  ){
		return @$_SESSION;
	}
	
	public function delete( $name ){
		unset( $_SESSION[$name] );
	}
}
