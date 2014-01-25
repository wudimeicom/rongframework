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
$wudimei->assign("site_name", "wudimei shop");
$wudimei->assign("welcome", "hello,welcome to wudimei shop!");


$wudimei->display("hello/include_sample.html");

