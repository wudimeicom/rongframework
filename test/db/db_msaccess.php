<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

header("Content-Type: text/html; charset=utf-8");

/*
require_once "Rong/Logger.php";
$config = array( 
  "logging_appender" => "ECHO" ,  // FILE or ECHO
  "log_file_path" => "d:/rong_framework.log",
  "logging_enable" => true ,
  "logging_types" => "WARN,INFO,DEBUG,ERROR,FATAL"
);
Rong_Logger::setConfig($config);
*/
//require the Rong_Db from the include path
require_once 'Rong/Db.php';

echo "<h1>test database ms access</h1>";
$GLOBALS["debug"] =1;//debug the sql if is set

$db = Rong_Db::factory("ADO", array(
			"connection_string"=>"Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" . dirname( __FILE__ ) . '/data/test.mdb;Jet OLEDB:Database Password=123456;Jet OLEDB:Engine Type=5',
            
            //"charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));

$db->createDatabase();
//echo $db->error();
/*
$sql = 'create table w_friends(id int,name varchar(20),tel varchar(20))';
$db->query($sql);
*/
/*
$sql = "insert into w_friends(id,name,tel) values(1,'yqr','13714715608')";
$db->query($sql);
*/
/*
$db->beginTransaction();
$sql = "insert into w_friends(id,name,tel) values(1,'yqr','13714715608')";
$db->query($sql);
$db->rollback();
*/

/*
$db->beginTransaction();
$sql = "insert into w_friends(id,name,tel) values(1,'yqr','13714715608')";
$db->query($sql);
$db->commit();
*/
/*
$sql = "insert into w_friends(id,name,tel) values(1,'yqr222','13714715608')";
$db->query($sql);		
echo $db->error();
 */
$rows = $db->fetchAll("select * from w_friends");

print_r( $rows );
$row = $db->fetchRow("select * from w_friends where name like '%yqr2%'");
print_r( $row );

$rows = $db->limit("select * from w_friends", $page=1, $pageSize=2);
print_r( $rows );

