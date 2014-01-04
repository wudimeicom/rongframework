<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";

//assing var msg to template

session_start();
$_SESSION["cart"] = array(
  array("id"=>1,"name"=>"banana","qty"=>1),
  array("id"=>2,"name"=>"apple","qty"=>2)
);
$_SESSION["username"] ="Yang Qing-rong";
setcookie("token",md5(""), time()+3600*24); //refresh browser required
$GLOBALS["db_host"] = "127.0.0.1";
//echo $wudimei->fetch("hello/sysvars.html");
$wudimei->display("hello/sysvars.html");

