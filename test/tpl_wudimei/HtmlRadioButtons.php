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
$wudimei->forceCompile = true;

 
 

$goods = array(
  1 =>"apple" ,
  2 =>"banana" ,
  3 =>"pear" ,
  4 =>"book" ,
); 
$wudimei->assign("goods", $goods );
 
$wudimei->display("hello/HtmlRadioButtons.html");

