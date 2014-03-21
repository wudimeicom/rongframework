<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");
//require the Rong_Db from the include path

require_once 'Rong/Db.php';

echo "<h1>test database mysqli (测试mysqli)</h1>";
$GLOBALS["debug"] =1;//debug the sql if is set

$db = Rong_Db::factory("Oci8", array(
            "host" => "127.0.0.1", //db host name
            "port" => 1521,
            "username" => "yqr2",  //db username
            "password" => "123456", //db password
            "sid" => "XE", //mysql database name
            //"charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));
		
echo $db->error();



$page = intval( @$_GET["page"] );
$urlTemplate = "paginator_oci8.php?page={Page}";
$rows = $db->getPaginator("select * from w_article", $page , $pageSize=2, $urlTemplate);

print_r( $rows );