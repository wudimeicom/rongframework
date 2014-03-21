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
 

$db = Rong_Db::factory("Pg", array(
            "host" => "127.0.0.1", //db host name
            "port" => 5432,
            "username" => "postgres",  //db username
            "password" => "123456", //db password
            "dbname" => "rong_db", //mysql database name
            "charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));
						


$sql = "CREATE TABLE w_friends (
    id        integer CONSTRAINT firstkey PRIMARY KEY,
    name       varchar(30) NOT NULL,
    tel       varchar(30) NOT NULL
);";

echo $db->error();
$db->query($sql);


$db->beginTransaction();
$db->query("insert into w_friends(id,name,tel) values(4,'yqr','13714715608');");
$db->rollback();

$db->beginTransaction();
$db->query("insert into w_friends(id,name,tel) values(5,'yqr2','13714715608');");
$db->commit();

$dt = $db->fetchAll("select * from  w_friends");
print_r( $dt );
