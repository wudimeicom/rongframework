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
//$wudimei->forceCompile = true;

function  wudimei_tag_loop( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromText($strAttributes, "from,item");
    $from = Rong_View_Wudimei::compileExpression($attrs["from"]);
    $item = Rong_View_Wudimei::compileExpression($attrs["item"]);  
	$from = trim( $from,'@ ');  
	$item = trim( $item,'@ ');
	
    return ' foreach( ' . $from . ' as ' .   $item  . ' ){';
	 
}

function wudimei_tag_loop_end(){
	return '}';
}


$goods = array(
 array("id"=>1,"name"=>"apple"),
 array("id"=>2,"name"=>"banana"),
 array("id"=>3,"name"=>"pear"),
 array("id"=>4,"name"=>"book"),
); 
$wudimei->assign("goods", $goods );
 
$wudimei->display("hello/customize_tag.html");

