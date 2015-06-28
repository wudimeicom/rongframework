<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
ini_set("display_errors",1);
error_reporting(E_ALL|E_NOTICE|E_ERROR|E_WARNING);


$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";

//assing var msg to template

$wudimei->display("hello/set.html");

