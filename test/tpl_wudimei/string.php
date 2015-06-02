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

//assing var msg to template
$wudimei->assign("msg", "Hello,World!");

$wudimei->assign("name", "    Yang Qing-rong  "); //trim
$wudimei->assign("list" , "orange\napple\nbanana");
$wudimei->assign("url","http://rong.wudimei.com");
$wudimei->assign("url2", "http%3A%2F%2Frong.wudimei.com" );
$wudimei->assign("b64","aHR0cDovL3Jvbmcud3VkaW1laS5jb20=" );
$wudimei->assign("html","<p>hello,world</p><p>yqr</p><table><tr><td>hello</td><td>world</td></tr></table>");
$wudimei->assign("utf8String","你好，我叫杨庆荣！");

$wudimei->display("hello/string.html");

