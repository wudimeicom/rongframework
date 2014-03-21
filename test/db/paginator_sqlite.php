<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");
//require the Rong_Db from the include path

ini_set("display_errors", 1 );
error_reporting(E_ALL|E_WARNING);
require_once 'Rong/Db.php';

echo "<h1>test database model (测试数据库模型)</h1>";
//$GLOBALS["debug"] =1;//debug the sql if is set

$db = Rong_Db::factory("Sqlite", array(
                    "filename" => dirname(__FILE__)."/data/test_sqlite.db",
                    "mode" => 0777,
                    "table_prefix" => "w_" //table prefix
                ));
		
echo $db->error();

 

$page = intval( @$_GET["page"] );
$urlTemplate = "paginator_sqlite.php?page={Page}";
$rows = $db->getPaginator("select * from w_article", $page , $pageSize=1, $urlTemplate);

print_r( $rows );
