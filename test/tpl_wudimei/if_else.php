<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

$PathToRongFrameworkDev = dirname(__FILE__)."/../../../../www.wudimei.com/lib";
if( is_dir( $PathToRongFrameworkDev )){    $PathToRongFramework = $PathToRongFrameworkDev; }
set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );
 
require_once "Rong/Logger.php";
$config = array(
        "logging_appender" => "FILE" ,  // FILE or ECHO
        "log_file_path" => "d:/wudimei_tpl.log",
        "logging_enable" => true ,
        "logging_types" => "WARN,INFO,DEBUG,ERROR,FATAL"
);
Rong_Logger::setConfig($config);


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";
$wudimei->forceCompile = true;
//assing var msg to template
$wudimei->assign("msg", "Hello,World!");

$wudimei->assign("age", 16 );

$man =new stdClass();
$man->age = 20;


$wudimei->assign("man" , $man );

$item = array("type" => "checkbox");
$wudimei->assign("item", $item);

$wudimei->display("hello/if_else.html");

