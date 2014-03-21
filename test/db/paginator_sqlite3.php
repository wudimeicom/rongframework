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
$GLOBALS["debug"] =1;//debug the sql if is set

$db = Rong_Db::factory("Sqlite3", array(
                    "filename" => dirname(__FILE__)."/data/test_sqlite3.db",
                    "flags" => SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE,
                    "encryption_key" => "password1" ,//table prefix
                    "table_prefix" => "w_"
                ));
		
echo $db->error();


$page = intval( @$_GET["page"] );
$urlTemplate = "paginator_sqlite3.php?page={Page}";
$rows = $db->getPaginator("select * from w_article", $page , $pageSize=2, $urlTemplate);

print_r( $rows );
