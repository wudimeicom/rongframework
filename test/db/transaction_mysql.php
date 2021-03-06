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

 
$GLOBALS["debug"] =1;//debug the sql if is set
//transaction of Rong_Db support these drivers:Mysql,Mysqli,Pg(postgre sql),Oci8
$db = Rong_Db::factory("Mysqli", array(
            "host" => "localhost", //db host name
            "username" => "root",  //db username
            "password" => "123456", //db password
            "dbname" => "rong_db", //mysql database name
            "charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));
 
						


$sql = "
CREATE TABLE IF NOT EXISTS `w_friends` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default ' ',
  `tel` varchar(20) NOT NULL default ' ',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

echo $db->error();
$db->query($sql);


$db->beginTransaction();
$db->query("insert into w_friends(name,tel) value('yqr','13714715608');");
$db->rollback();

$db->beginTransaction();
$db->query("insert into w_friends(name,tel) value('yqr2','13714715608');");
$db->commit();

 
