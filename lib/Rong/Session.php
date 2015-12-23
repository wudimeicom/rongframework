<?php
class Rong_Session{
	
	public static function factory( $adapter, $config ){
		
		
		require_once 'Rong/Session/File.php';
		$session = new Rong_Session_File($config);
		session_set_save_handler(
				array($session,"open"), 
				array($session,"close"),
				array($session,"read"),
				array($session,"write"),
				array($session,"destroy"),
				array($session,"gc"),
				array($session,"create_sid")
		);
		register_shutdown_function('session_write_close');
		
		ini_set("session.gc_maxlifetime",$config["gc_maxlifetime"]);
		
		ini_set('session.cookie_path', $config["cookie_path"]);
		ini_set("session.cookie_domain",$config["cookie_domain"]);
		ini_set('session.cookie_lifetime', $config["cookie_lifetime"]);
			
		session_set_cookie_params ( $config["cookie_lifetime"], $config["cookie_path"], $config["cookie_domain"], $secure = false  ,  $httponly = false  );
		
		
		
		
	}
	
	public static function start(){
		session_start();
	}
}