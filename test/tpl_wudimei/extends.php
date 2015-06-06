<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
ini_set("display_errors",1);
error_reporting(E_ALL|E_NOTICE|E_WARNING|E_ERROR|E_COMPILE_ERROR);

$PathToRongFramework = dirname(__FILE__)."/../../lib";

$PathToRongFrameworkDev = dirname(__FILE__)."/../../../../www.wudimei.com/lib";
if( is_dir( $PathToRongFrameworkDev )){    $PathToRongFramework = $PathToRongFrameworkDev; }

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "<!--{";
$wudimei->rightDelimiter = "}-->";
$wudimei->forceCompile = true;



//assing var msg to template
$wudimei->assign("keyword", "WuDiMei.com");


$wudimei->display("extends/3.html");

//print_r( $wudimei->viewBlocks  );

