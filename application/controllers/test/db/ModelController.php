<?php

class ModelController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    //http://127.0.0.9/index.php/test/db/Model
    public function indexAction() {
        require_once 'Rong/Db.php';
        $db = Rong_Db::factory("Mysql", array(
                    "host" => "localhost",
                    "username" => "root",
                    "password" => "123456",
                    "dbname" => "rong_db",
                    "charset" => "utf8"
                ));

        require_once 'Rong/Db/Model.php';
        Rong_Db_Model::setDefaultDb( $db );
         
        $articleModel = $this->import->model("ArticleModel");
        echo "<h3>using Rong_Db_Model</h3>";
        echo "last insert id:";
        echo $lastInsertId = $articleModel->insert(
        array("title" => "model title",
            "content" => "model content" // db field name => value
        )
        );
        echo "<br />";
        echo "update affected rows:";
        echo $affectedRows = $articleModel->update(
            array(
                "title" => "new title"// db field name => value
            ), "id=" . $lastInsertId
        );
        echo "<br />delete one row:";
        echo $affectedRows = $articleModel->delete("id=12");
    }

}

?>
