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

require_once 'Rong/Service/Client.php';

$server_url = "http://127.0.0.9/test/service/service_server.php";
$client = new Rong_Service_Client( $server_url );
 
//$GLOBALS["debug"]=1;
$client->password = "123456";

$sum =$client->addNumber(1.2,5.3);
echo "1.2+5.3=" . $sum;
echo "<br />";

$text = $client->welcome("moon");
echo "server return:" . $text;
echo "<br />";
echo "call Person::speak() ".  $client->speak("chinese");

echo "<br />";
echo "msg:" . $client->getServerMessage();




