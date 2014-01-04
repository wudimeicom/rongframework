<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
 ini_set("display_errors",1);
 error_reporting(E_ALL|E_NOTICE|E_WARNING|E_COMPILE_ERROR|E_CORE_ERROR);
 
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";


$cart = array(
  array("id"=>1,"name"=>"banana","qty"=>1),
  array("id"=>2,"name"=>"apple","qty"=>2)
);

$wudimei->assign("cart", $cart );

 
 
$wudimei->display("hello/call_function.html");


function call_display_product( $arr )
{
	//print_r( $arr );
	$html = "<b>product name:</b>".$arr["name"] . "<br /><b>qty:</b>" . $arr["qty"];
	return $html;
}
