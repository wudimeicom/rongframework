<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");

require_once 'Rong/Cache.php';
date_default_timezone_set("Asia/Shanghai");

echo "<h3>Demo cache</h3>";

$cache = Rong_Cache::factory("File", array(
    "cache_dir" => dirname(__FILE__) . "/data/file_cache"
));



echo '1.save data to cache as the name of "color" , with tags "color" and "basic_color"(保存数据“green","orange"到名为"color"的缓存，标签是："color"和"basic_color") <br />';

$cache->set("color", array("green", "orange"), 30, array("color", "basic_color"));



echo '2.get the cache by the name "color"  以"color"为缓存名取得缓存<br />';
$val = $cache->get("color");
print_r($val);


$cache->update("color", array("blue"), array("new_tag"));
echo '<br /> 3.update the cache with new value and new tag:更新缓存的值和标签<br />';
$val = $cache->get("color");
print_r($val);


/*
echo '<br />delete tag "color" and then output it\'s value: 删除缓存后输出结果<br />';
$val = $cache->delete("color");
$val = $cache->get("color");
var_dump($val);
*/

/*
echo '<br />delte old caches:删除过去的缓存<br />';
$cache->deleteOld();
*/

/*
echo '<br />delete by tag name,it maths any tag name of "color" or "basic_color":按标签名删除缓存<br />';
$cache->deleteByTag(array("color", "new_tag"), "any");
*/



