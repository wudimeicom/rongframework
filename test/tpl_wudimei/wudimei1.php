<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

//$PathToRongFramework = "d:/www/wudimei/wudimei.com/lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";
$wudimei->forceCompile = true;



//assing var msg to template
$wudimei->assign("msg", "Hello,World!");
$wudimei->assign("len", 6);
$wudimei->assign("info", array("len"=>7));

$info2 = array("a"=>array("b"=>array("c"=>10)));
 
$wudimei->assign("info2", $info2);
$wudimei->assign("row", array("register_url"=>"http://wudimei.com"));
$wudimei->display("hello/index.html");