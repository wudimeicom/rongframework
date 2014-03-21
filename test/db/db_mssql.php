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
//$GLOBALS["debug"] =1;//debug the sql if is set

$db = Rong_Db::factory("Mssql", array(
            "server_name" => "127.0.0.1,1433",//  "RONG-PC\\SQLEXPRESS", //db host name
            "port" => 1433,
            "username" => "sa",  //db username
            "password" => "123456", //db password
            "dbname" => "rong_db", //mysql database name
            //"charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));
		
echo $db->error();

exit();
/*
CREATE TABLE IF NOT EXISTS `w_article` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default ' ',
  `content` text NOT NULL,
  `add_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;
 **/

echo "1.insert data into table `w_article` ... (向数据库插入数据,执行sql语解码器)<br />";
$db->query("insert into w_article( title ,content) values('hello','world' )");
echo "Last Insert id:" . $db->insertId() ."<br />";
echo $db->error()."<br />";



   
echo '2.insert array to database 以数组的方式插入到数据库中。 <br /> ';
$lastInsertId = $db->insert( "w_article" ,
     array(
         "title" => "my god",
         "content" => "what a pitty" 
      )
);
echo 'last insert id(最后插入编号):' . $lastInsertId . '<br />';



echo '3.update database. 以数组的方式(字段名=>字段值)更新数据<br />';
$affectedRows = $db->update( "w_article",
     array(
        "content"=>"new content"
     ),
  "id=1" );
echo 'affected rows:' . $affectedRows . '<br />';



echo '4.delete data.(删除数据)<br />'; 
$affectedRows = $db->delete("w_article", "id=1");//parameter table name ,condition sql statement
echo 'affected rows:' . $affectedRows . '<br />';



echo "5.show all data from w_article table:(打印出数据库中的所有数据)<br />";
$rows = $db->fetchAll("select * from w_article");
echo '<pre>';
var_dump($rows);
echo '</pre>';



echo "6.Querying muliple sql. (查询多条sql语句)<br />";
$r2 = $db->call( "select * from w_article;select now();select * from w_article;select now();" );
echo '<pre>';
print_r( $r2 );
echo '</pre>';


