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

echo "<h1>test database pg</h1>";
$GLOBALS["debug"] =1;//debug the sql if is set
//sql: create database rong_db
$db = Rong_Db::factory("Pg", array(
            "host" => "127.0.0.1", //db host name
            "port" => 5432,
            "username" => "postgres",  //db username
            "password" => "123456", //db password
            "dbname" => "rong_db", //mysql database name
            "charset" => "utf8" ,//db default charset
            "table_prefix" => "w_" //table prefix
        ));
		
echo $db->error();



$sql = "CREATE TABLE w_friends (
    id        integer CONSTRAINT firstkey PRIMARY KEY,
    name       varchar(30) NOT NULL,
    tel       varchar(30) NOT NULL
);";

$db->query($sql);
//exit(); 

echo "1.insert data into table `w_friends` ... (向数据库插入数据,执行sql语解码器)<br />";
$db->query("insert into w_friends( id,name,tel) values(1,'yqr','13714715608' )");
echo "Last Insert id:" . $db->insertId() ."<br />";
echo $db->error()."<br />";



   
echo '2.insert array to database 以数组的方式插入到数据库中。 <br /> ';
$lastInsertId = $db->insert( "w_friends" ,
     array(
     	 "id" => 2,
         "name" => "my god",
         "tel" => "what a pitty" 
      )
);
echo 'last insert id(最后插入编号):' . $lastInsertId . '<br />';



echo '3.update database. 以数组的方式(字段名=>字段值)更新数据<br />';
$affectedRows = $db->update( "w_friends",
     array(
        "tel"=>"abc"
     ),
  "id=2" );
echo 'affected rows:' . $affectedRows . '<br />';



echo '4.delete data.(删除数据)<br />'; 
$affectedRows = $db->delete("w_friends", "id=1");//parameter table name ,condition sql statement
echo 'affected rows:' . $affectedRows . '<br />';



echo "5.show all data from w_article table:(打印出数据库中的所有数据)<br />";
$rows = $db->fetchAll("select * from w_friends");
echo '<pre>';
print_r($rows);
echo '</pre>';



echo "6.Querying muliple sql. (查询多条sql语句)<br />";
$r2 = $db->call( "select * from w_friends;select now();select * from w_friends;select now();" );
echo '<pre>';
print_r( $r2 );
echo '</pre>';

 
