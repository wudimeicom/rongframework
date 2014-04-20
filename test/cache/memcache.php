<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 * 
 * http://windows.php.net/downloads/pecl/releases/memcache/3.0.8/
 * php_memcache-3.0.8-[php version]-ts-vc11-x86.zip
 * 
 */
 error_reporting(E_ALL|E_WARNING|E_NOTICE);
$PathToRongFramework = dirname(__FILE__)."/../../lib";



set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");

require_once 'Rong/Cache.php';
date_default_timezone_set("Asia/Shanghai");

echo "<h3>Demo cache</h3>";

$cache = Rong_Cache::factory("Memcache", array(
    "servers" => array(
		array( "127.0.0.1",11211,33), //ip , port, weight
		array( "127.0.0.2",11212,33)
	)
));

$cache->set("rong","rong framework is a simple php framework",3600,array("php","framework","simple") );
$cache->set("cache","cache drivers:memcache,file",3600,array("cache","memcache","file") );
//$cache->delete("text2");




 //$cache->deleteByTag(array("cache","file","memcache"),"all");
//$cache->deleteByTag(array("php","simple"),"all");
//$cache->deleteByTag(array("cache","file","memcache","php"),"any");

echo "<h3>cache list</h3>";
$keys = $cache->get("__RongFramework.keys");
if( !empty( $keys ))
{
	foreach( $keys as $key )
	{
		 
		echo "<br />text:". $cache->get($key);
		echo "<br />expire time:". $cache->get("__RongFramework.{$key}.expire");
		echo "<br />tags :";
		$tag = $cache->get("__RongFramework.{$key}.tag");
		print_r( $tag );
		echo "<hr />";
	}
}
