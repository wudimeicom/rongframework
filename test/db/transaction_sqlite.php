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

 
//$GLOBALS["debug"] =1;//debug the sql if is set
 

$db = Rong_Db::factory("Sqlite", array(
                    "filename" => dirname(__FILE__)."/data/test_sqlite_transaction.db",
                    "mode" => 0777,
                    "table_prefix" => "w_" //table prefix
                ));
						


$sql = "CREATE TABLE  w_friends( 
		id   integer PRIMARY KEY  , 
		name varchar(255) ,
		tel varchar(255)
	   )";

echo $db->error();
$db->query($sql);


$db->beginTransaction();
$db->query("insert into w_friends(name,tel) values('yqr','13714715608');");
$db->rollback();

$db->beginTransaction();
$db->query("insert into w_friends(name,tel) values('yqr2','13714715608');");
$db->commit();

$dt = $db->fetchAll("select * from  w_friends");
print_r( $dt );
