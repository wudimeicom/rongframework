<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/template_wudimei/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/template_wudimei";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";

//assing var msg to template
$wudimei->assign("msg", "Hello,World!");

$wudimei->assign("age", 16 );

$man =new stdClass();
$man->age = 20;

$wudimei->assign("man" , $man );


$wudimei->display("hello/if_else.html");

