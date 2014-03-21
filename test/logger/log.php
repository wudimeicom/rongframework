<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once "Rong/Logger.php";
$config = array( 
  "logging_appender" => "FILE" ,  // FILE or ECHO
  "log_file_path" => "d:/rong_framework.log",
  "logging_enable" => true ,
  "logging_types" => "WARN,INFO,DEBUG,ERROR,FATAL"
);
Rong_Logger::setConfig($config);


class A{
	public $logger;
	public function __construct(){
		$this->logger =  Rong_Logger::getLogger();
	}
	
	public function test(){
		$this->logger->error("cause error!");
		
		$this->logger->warn("test warn");
		$this->logger->fatal("fatal");
		$this->logger->info("infomation");
		$this->logger->debug("debug");
	}
}



$a = new A();
$a->test();
