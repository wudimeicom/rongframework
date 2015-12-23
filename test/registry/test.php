<?php
 
/**
 * file encoding utf-8
* 文件字符编码utf-8
*/
$PathToRongFramework = dirname(__FILE__) . "/../../lib";

//$PathToRongFramework = "d:/www/wudimei/www.wudimei.com/lib";

set_include_path("." . PATH_SEPARATOR . $PathToRongFramework . PATH_SEPARATOR . get_include_path());
 

require_once 'Rong/Registry.php';

function getRegistryValue(){
	echo Rong_Registry::get("name") . " ";
	Rong_Registry::set("name","yqr2");
}
Rong_Registry::set("name","yqr");
echo Rong_Registry::get("name") . " ";
getRegistryValue();
echo Rong_Registry::get("name") . " ";
