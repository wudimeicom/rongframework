<?php

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__) . "/../lib";

set_include_path("." . PATH_SEPARATOR . $PathToRongFramework . PATH_SEPARATOR . get_include_path());

require_once 'Rong/Search/Analyzer.php';

ini_set("memory_limit", "250M");

$analyzer = Rong_Search_Analyzer::factory("Chinese", array('dictionary_path' => dirname(__FILE__)."/data/chinese_dict-1.0.dat"));

$ks = $analyzer -> analyze('Hello,world!Rong 
Framework是杨庆荣开发的一款基于php5的开源框架,它是免费的软件框架。它简化了sql开发。
                它内置的wudimei模板引擎是模防smarty的，但更多的是自己的元素。');
				
				
echo "loading time(加载词典时间):" . $analyzer -> getLoadingTime() . " seconds<br />";
//加载时间,如果想缩短，请写一个socket server，启动时只加载一次就可以了
echo "process Time(分词时间)：" . $analyzer -> getProcessTime() . " seconds<br />";
print_r($ks);
