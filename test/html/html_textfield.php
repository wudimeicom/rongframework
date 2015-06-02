<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/Html/TextField.php';

$tf = new Rong_Html_TextField();
$tf->set("id","title")->set("name","title")->set("value","Hello,world");

header("Content-Type: text/html; charset=utf-8");
echo $tf->toHtml();
