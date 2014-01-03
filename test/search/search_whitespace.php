<?php


/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/Search/Analyzer.php';

$analyzer = Rong_Search_Analyzer::factory("WhiteSpace", array());
$ks = $analyzer->analyze('Rong Framework which is a php5-based framework,is developed by yangqingrong.it simplify the sql development.wudimei template engine is similar to smarty,but it has lots of itself\'s style');
var_dump($ks);