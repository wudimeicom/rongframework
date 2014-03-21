<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

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

require_once 'Rong/Net/HttpClient.php';

$client = new Rong_Net_HttpClient();
$client->setCookieDir( dirname(__FILE__) . "/data/cookies" );

$url = "http://127.0.0.9/test/net/net_demo_page.php";
//$url = "";

//1.GET
echo "--------------request method GET-------------<br />";
$client->request( $url . "?name=YangQingRong" , "GET");
$response = $client->getContent();

echo "server response:". $response;



//2.POST
echo "<br />--------------request method POST-------------<br />";
$client->addFile("photo", dirname(__FILE__) . "/data/info.txt" );
$postData = array("title"=>"hello,world","content"=>"good good study,day day up" );
$client->request( $url . "?name=YangQingRong" , "POST",$postData);
$response = $client->getContent();

echo "server response:". $response;


 
