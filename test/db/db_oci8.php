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
// select "id","name" from "table_name"

/*
CREATE TABLE IF NOT EXISTS `w_article` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default ' ',
  `content` text NOT NULL,
  `add_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;
 **/
 $sql = "CREATE TABLE  w_article (
  id integer NOT NULL ,
  title varchar(255) NOT NULL  ,
  content varchar(255) NOT NULL,
  add_time varchar(30) NOT NULL  ,
  PRIMARY KEY  (id)
)";
$db->query( $sql );
 
echo "1.insert data into table `w_article` ... (向数据库插入数据,执行sql语解码器)<br />";
$db->query("insert into w_article( id,title ,content,add_time) values(1,'hello','world','2014-02-03 22:27:00' )");
echo "Last Insert id:" . $db->insertId() ."<br />";
echo $db->error()."<br />";


 
   $GLOBALS["debug"] =1;
echo '2.insert array to database 以数组的方式插入到数据库中。 <br /> ';
$lastInsertId = $db->insert( "w_article" ,
     array(
         "title" => "my god",
         "content" => "what a pitty" ,
         "id" => 2,
         "add_time" => "2014-02-03 22:28:00"
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
$affectedRows = $db->delete("w_article", "id=1222");//parameter table name ,condition sql statement
echo 'affected rows:' . $affectedRows . '<br />';

 

echo "5.show all data from w_article table:(打印出数据库中的所有数据)<br />";
$rows = $db->fetchAll("select * from w_article");
echo '<pre>';
var_dump($rows);
echo '</pre>';



echo "6.Querying muliple sql. (查询多条sql语句)<br />";
$r2 = $db->call( "select * from w_article;select * from w_article;" );
echo '<pre>';
print_r( $r2 );
echo '</pre>';


