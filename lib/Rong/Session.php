<?php
/**
 * $config = array(
	"save_path" => "d:/tmp/session",
	"gc_maxlifetime" => 500 ,//seconds
	"cookie_path" => "/",
	"cookie_domain" => "wudimei.com2",
	"cookie_lifetime" => 3,
	'session_name' => '__wudimeisid',
	'cookie_secure' => null,
	'cookie_httponly' => null
);
require_once 'Rong/Session.php';
Rong_Session::factory("File", $config); //File | CookieFile
Rong_Session::start();

$_SESSION["name"] = "yqr";
//unset($_SESSION["name"]);
 * 
 * @author rong
 *
 */
class Rong_Session{
	public static $session;
	public static function factory( $adapter, $config ){
		$adapter_lower = strtolower( $adapter );
		if( $adapter_lower == "file"){
			require_once 'Rong/Session/File.php';
			$session = new Rong_Session_File($config);
		}
		elseif( $adapter_lower == "cookiefile" ){
			require_once 'Rong/Session/CookieFile.php';
			$session = new Rong_Session_CookieFile($config);
		}
		else{
			
			$class = "Rong_Session_". $adapter;
			if( class_exists( $class)){
				require_once 'Rong/Session/'.$adapter.'.php';
				$session = new $class($config);
			}
			elseif( class_exists( $adapter )){
				$session = new $adapter($config);
			}
		}
		self::$session = $session;
		
		
	}
	
	public static function start(){
		//session_start();
		self::$session->start();
	}
	
	public static function put( $name,$value ){
		return self::$session->put( $name,$value );
	}
	
	public static function get( $name ,$default = null ){
		$value = self::$session->get( $name  );
		if( is_null( $value) || !isset( $value)){
			return $default;
		}
		return $value;
	}
	
	public static function all(){
		//session_start();
		return self::$session->all();
	}
	
	public static function delete( $name ){
		return self::$session->delete( $name );
	}
			
}