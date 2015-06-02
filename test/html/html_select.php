<?php

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/Html/Select.php';

$select = new Rong_Html_Select();
$select->set("name", "friends" );
$select->set("id", "id_friends");
$select->set("onchange","friends_onchange(this)");
$select->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
$select->setSelectedValue( 2 );

header("Content-Type: text/html; charset=utf-8");
echo $select->toHtml();



