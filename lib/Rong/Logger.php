<?php
class Rong_Logger{
	
	/**
	 * 
	  array(
	   "logging_appender" => "FILE" ,  // FILE or ECHO
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
		
		$logText = $this->getLogText($type, $string);
		
		if( self::$config["logging_enable"] == true )
		{
			if( self::$config["logging_appender"] == "FILE" )
			{
				$log_file_path = self::$config["log_file_path"];
			 
				$fp = fopen( $log_file_path , "a+" );
				fwrite($fp , $logText);
				fclose( $fp );
			 
			}
			elseif( self::$config["logging_appender"] == "ECHO" ){
				echo $logText;
			}
		}
		
	}
	
	protected function getLogText( $type,$string ){
		$dbt = debug_backtrace();
		
		
		$logText = date("Y-m-d H:i:s"). " [" . $type . "] " . $string . "\r\n";
		//$i=0,1  method in this class
		for( $i=2; $i< count( $dbt);$i++ )
		{
			$logText .= "  at ". $dbt[$i]["file"] . " line:" . $dbt[$i]["line"]  . " ";
			
			$args = $dbt[$i]["args"];
			for($j=0;$j<count( $args);$j++ )
			{
				$args[$j] = var_export($args[$j],true);
			}
			$class = "";
			if( isset( $dbt[$i]["class"]))
			{
				$class = $dbt[$i]["class"]."_instance";
			} 
			$logText .= $class. $dbt[$i]["type"]."".$dbt[$i]["function"]."(". implode( ",", $args ) . " );";
			 
			$logText .= "\r\n";
		}
		return $logText; 
	}
	
}
