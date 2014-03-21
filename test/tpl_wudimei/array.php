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

$wudimei->forceCompile = true;
$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";

//assing var msg to template
$member = array(
  "username" => "Yang Qing-rong",
  "id" => "2",
  "birthday" => "1985-04-23",
  "number.home" => "13714715608",
  "other" => array("name.a"=> array("test")) 
);
$wudimei->assign("member", $member);

$fruits = array(
  array( "id"=>1, "name" => "orange" ),
  array( "id"=>2, "name" => "banana" ),
  array( "id"=>3, "name" => "apple" ),
  array( "id"=>4, "name" => "pear" )
);

$wudimei->assign("fruits" , $fruits);

$ArrayReturned = array( 
				"Data" => array( 
						array( "id" => 1, "name" => "Yang Qing-rong")
					)
			);	
			$wudimei->assign("config", array("SITE.URL_PREFIX" => "http://"));
$wudimei->assign("ArrayReturned", $ArrayReturned );
$wudimei->assign("emptyArray", array() );
$wudimei->display("hello/array.html");

