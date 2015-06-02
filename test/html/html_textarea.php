<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/Html/Textarea.php';

$ta = new Rong_Html_Textarea();
$ta->set("id","content")->set("name","content");
$ta->set("cols",60)->set("rows",5);
$ta->text = "<hr>hello,world";

header("Content-Type: text/html; charset=utf-8");
echo $ta->toHtml();


