<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 *
 * [url]http://windows.php.net/downloads/pecl/releases/memcache/3.0.8/[/url]
 * php_memcache-3.0.8-[php version]-ts-vc11-x86.zip
 *
 */
 error_reporting(E_ALL|E_WARNING|E_NOTICE);
//Rong Framework的路径
$PathToRongFramework = dirname(__FILE__)."/../../lib";
 
 
//把Rong framework路径放到include path中
set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );
 
header("Content-Type: text/html; charset=utf-8");
 
require_once 'Rong/Cache.php';
date_default_timezone_set("Asia/Shanghai");
 
 
 //启用log日志记录，本段用于调试
 if( true )
 {
	require_once "Rong/Logger.php";
	$config = array( 
	  "logging_appender" => "ECHO" ,  // FILE or ECHO
	  "log_file_path" => "d:/rong_framework.log",
	  "logging_enable" => true ,
	  "logging_types" => "WARN,INFO,DEBUG,ERROR,FATAL"
	);
	Rong_Logger::setConfig($config);
 }


echo "<h3>Demo cache</h3>";
//factory( 驱动名, 配置数组)
$cache = Rong_Cache::factory("Memcache", array(
    "servers" => array(
        array( "127.0.0.1",11211,33), //Memcache的ip地址 , port端口号, weight权重
        array( "127.0.0.2",11212,33)
    )
));
 
 
//set( 键名 , 要缓存的值 , 缓存多少秒, 一维标签数组)
$cache->set("rong","rong framework is a simple php framework",3600,array("php","framework","simple") );
$cache->set("cache","cache drivers:memcache,file",3600,array("cache","memcache","file") );
 
//delete(键名)
//$cache->delete("text2");
 
 
 
//all:删除标签数组包含于array("cache","file","memcache")的缓存
 //$cache->deleteByTag(array("cache","file","memcache"),"all");
//$cache->deleteByTag(array("php","simple"),"all");
 
//any:只要标签存在array("cache","file","memcache","php")中的一个，即可删除
//$cache->deleteByTag(array("cache","file","memcache","php"),"any");
 
echo "<h3>cache list</h3>";
$keys = $cache->get("__RongFramework.keys");
if( !empty( $keys ))
{
    foreach( $keys as $key )
    {
         //get(键名)
        echo "<br />text:". $cache->get($key);
        echo "<br />expire time:". $cache->get("__RongFramework.{$key}.expire");
        echo "<br />tags :";
        $tag = $cache->get("__RongFramework.{$key}.tag");
        print_r( $tag );
        echo "<hr />";
    }
}