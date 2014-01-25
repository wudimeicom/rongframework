<?php
class Rong_Logger{
	
	/**
	 * 
	  array(
	   "log_file_path" => "d:/test.log",
	   "logging_enable" => true, 
	   "logging_types" => "ERROR,WARN,INFO,DEBUG,FATAL"
	  )
	 */
	private static $config;
	
	public static function setConfig($config)
	{
		self::$config = $config;
	}
	
	public static function getLogger(){
		$logger = new Rong_Logger();
		return $logger;	
	}
	
	public function error( $string )
	{
		$this->addLog("ERROR", $string);
	}
	
	public function info( $string )
	{
		$this->addLog("INFO", $string);
	}
	
	public function warn( $string )
	{
		$this->addLog("WARN", $string);
	}
	
	public function debug( $string )
	{
		$this->addLog("DEBUG", $string);
	}
	
	public function fatal( $string )
	{
		$this->addLog("FATAL", $string);
	}
	
	public function addLog( $type, $string )
	{
		$logging_types = self::$config["logging_types"];
		if( strpos( $logging_types, $type) === false )
		{
			return false;
		}
		
		$dbt = debug_backtrace();
		
		
		$logText = date("Y-m-d H:i:s")." ". $dbt[1]["file"] . " line:" . $dbt[1]["line"]  . " " .
		 "\r\n[" . $type . "] " . $string . "\r\n";
		
		if( self::$config["logging_enable"] == true )
		{
			$log_file_path = self::$config["log_file_path"];
			if( file_exists( $log_file_path ) )
			{
				$fp = fopen( $log_file_path , "a+" );
				fwrite($fp , $logText);
				fclose( $fp );
			}
		}
		
	}
	
}
