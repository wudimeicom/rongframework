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
                    "encryption_key" => "password1" ,
                    "table_prefix" => "w_"
                ));
		
echo $db->error();


$db->query('CREATE TABLE  w_article( 
		id   integer PRIMARY KEY  , 
		title varchar(255) ,
		content varchar(255)
		 )');
        echo $db->error();
	

require_once 'Rong/Db/Model.php';
Rong_Db_Model::setDefaultDb( $db );

require_once dirname(__FILE__) . "/models/ArticleModel.php";
$articleModel = new ArticleModel();

/*
$lastInsertId = $articleModel->insert(array(
  "title" => "good good study",
  "content" => "day day up"
));
echo "last insert id:" . $lastInsertId ."<br />";

*/

/*
$affectedRows = $articleModel->update(
            array(
                "title" => "new title"// db field name => value
            ), "id=" . 2
        );
echo "update affected rows:".$affectedRows . "<br />";
*/

/*
$affectedRows = $articleModel->delete("id=" . 3);
echo "Deletion affected rows:".$affectedRows . "<br />";		
*/
$record = $articleModel->fetchRow("id=1" );
echo "fetch a record:";
print_r( $record );
echo "<br />";

$records = $articleModel->fetchAll("id>0");
echo "fetch all records:<pre>";
print_r( $records );
echo "</pre>";


