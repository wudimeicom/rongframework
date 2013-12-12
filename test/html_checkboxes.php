<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/Html/Checkboxes.php';

$checkboxes = new Rong_Html_Checkboxes( );
$checkboxes->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei","foo"=>"杨庆荣"));
$checkboxes->setCheckedValues( "3,1" );
$checkboxes->setCheckedValues( array(1,2,"foo") );
$checkboxes->set("name", "friends[]" )->set("class","class1");
echo $checkboxes->toHtml();