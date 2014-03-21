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

$sql = "CREATE TABLE  w_article (
  id integer NOT NULL ,
  title varchar(255) NOT NULL  ,
  content varchar(255) NOT NULL,
  add_time varchar(30) NOT NULL  ,
  PRIMARY KEY  (id)
)";
$db->query( $sql );
 

$db->beginTransaction();
$db->query("insert into w_article( id,title ,content,add_time) values(3,'hello','world','2014-02-03 22:27:00' )");
echo "Last Insert id:" . $db->insertId() ."<br />";
$db->rollback();

$db->beginTransaction();
$db->query("insert into w_article( id,title ,content,add_time) values(5,'hello','world','2014-02-03 22:27:00' )");
$db->commit();

$data = $db->fetchAll("select * from w_article");
print_r( $data );
