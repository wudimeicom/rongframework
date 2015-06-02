<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__) . "/../../lib";
//$PathToRongFramework = "d:/www/wudimei/wudimei.com/lib";

set_include_path("." . PATH_SEPARATOR . $PathToRongFramework . PATH_SEPARATOR . get_include_path());

/*
require_once "Rong/Logger.php";
$config = array( 
  "logging_appender" => "FILE" ,  // FILE or ECHO
  "log_file_path" => "d:/rong_framework.log",
  "logging_enable" => true ,
  "logging_types" => "WARN,INFO,DEBUG,ERROR,FATAL"
);
Rong_Logger::setConfig($config);
*/
ini_set("display_errors",1);
error_reporting(E_ALL|E_WARNING|E_NOTICE|E_COMPILE_ERROR);

require_once 'Rong/Service/Server.php';

function addNumber( $num1, $num2 )
{
	$sum = $num1 + $num2;
	return $sum;
}

function welcome( $name )
{
	$text = "hello," . $name."!welcome to china";
	return $text;
}

class Person{
	public function speak( $language )
	{
		return "the person speak " . $language;
	}
}

$server = new Rong_Service_Server();
$server->password = "123456";
$server->addFunction("addNumber");
$server->addFunction("welcome");

eregi("/[0-9]+/i","1234");

$person = new Person();
$server->addClass("Person", $person );
$server->start();

