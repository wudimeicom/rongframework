<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/Html/Radios.php';

$radios = new Rong_Html_Radios( );
$radios->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
$radios->setCheckedValue( 3 );
$radios->set("name", "friends" );

header("Content-Type: text/html; charset=utf-8");
echo $radios->toHtml();