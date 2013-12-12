<?php

class SqliteController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }

    public function indexAction() {
        // @unlink("/test.db");
        
        error_reporting(E_ALL);
        
        require_once 'Rong/Db.php';
        
        $db = Rong_Db::factory("Sqlite", array(
                    "filename" => "d:/test.db",
                    "mode" => 0777,
                ));
        echo $db->error();
       
        $db->query('CREATE TABLE  article( 
		id   integer PRIMARY KEY  , 
		title varchar(255) ,
		content varchar(255)
		 )');
        echo $db->error();
        $db->insert("article", array(
            "title" => "how to learn rf",
            "content" => "abc"
        ));
        $db->insert("article", array(
            "title" => "yang",
            "content" => "abc"
        ));
        echo "insert id:";
        echo $db->insertId();
        echo "<br />";
       
       echo  $db->delete("article", "id=4");
       echo $db->error();
       $db->update("article", array("title" => "hi杨庆荣"), "id=2");
       $rows = $db->fetchAll("select * from article");
       print_r($rows);
        
    }
    
    //http://127.0.0.9/index.php/test/db/Sqlite/list
    public function listAction(){
        
        $page = $this->uri->getParam("page");
        $pageSize = $this->uri->getParam("size");
        
        require_once 'Rong/Db.php';
        
        $db = Rong_Db::factory("Sqlite", array(
                    "filename" => "d:/test.db",
                    "mode" => 0777,
                ));
        require_once dirname( __FILE__ ).'/models/ArticleModel.php';
        Rong_Db_Model::setDefaultDb( $db );
        $am = new ArticleModel();
        $pg = $am->pg($page, $pageSize, $urlTemplate= "/index.php/test/db/Sqlite/list/page/{Page}/size/{PageSize}");
        print_r( $pg );
    }

}

?>
