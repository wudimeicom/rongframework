<?php

class DbController extends Rong_Controller {

    public function __construct() {
        parent::__construct();
    }
    //http://127.0.0.9/index.php/test/db/Db
    public function indexAction() {
        echo "-------------------------------<br/>";
        echo "test database mysqli<br/>";
        echo "-------------------------------<br/><pre>";
        require_once 'Rong/Db.php';
        $db = Rong_Db::factory("Mysql", array(
                    "host" => "localhost",
                    "username" => "root",
                    "password" => "123456",
                    "dbname" => "rong_db",
                    "charset" => "utf8"
                ));
        echo $db->error();
        echo "<br />";
        echo "Now insert into table `article` ... <br />";
        $db->query("insert into article( title ,content) values('how to learn rong?','It\'s a problem.' )");
        echo "<br />";
        echo "Last Insert id:" . $db->insertId();
        echo "<br />";
        echo $db->error();
        echo "<br />";
        echo "show all data from article table:<br />";
        $rows = $db->fetchAll("select * from article");
        var_dump($rows);

        $r2 = $db->call( "select * from article;select now();select * from article;select now();" );
        print_r( $r2 );
       
        
          echo $lastInsertId = $db->insert( "article" ,
             array(
                 "title" => "test title2222",
                 "content" => "test contennt" 
              )
          );
        
          echo $affectedRows = $db->update( "article",
             array(
                "content"=>"new content333-----------------"
             ),
          "id=4" );
         
        echo $affectedRows = $db->delete("article", "id=4");
        echo "</pre>";
    }
   // http://127.0.0.9/index.php/test/db/Db/limit
    //sqlite pagination: //http://127.0.0.9/index.php/test/db/Sqlite/list
    public function limitAction() {
        require_once 'Rong/Db.php';
        require_once "Rong/Html/PageLink.php";

        $db = Rong_Db::factory("Mysql", array(
                    "host" => "localhost",
                    "username" => "root",
                    "password" => "123456",
                    "dbname" => "rong_db",
                    "charset" => "utf8"
                ));

        $page = intval( $this->uri->getParam("page"));
        $pageSize = 2;
         
        $rows = $db->getPaginator("select * from article", $page, $pageSize, "/index.php/test/db/Db/limit/page/{Page}/size/{PageSize}");
        echo "<div class='rf_PageLink'>" . $pageBarHtml . "</div>";
        
        echo "<pre>";
        print_r($rows);
        echo "</pre>";
    }

}

?>
