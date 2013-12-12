<?php
require_once 'Rong/Db.php';
require_once 'Rong/Db/Model.php';
//require dirname(__FILE__) . "/../MyController.php";
require_once 'Rong/View/PHP.php';

class IndexController extends Rong_Controller {

    public $config = array();

    public function __construct() {

        parent::__construct();
        
        
        if (! config( "enable_dev" ) ) {
            echo "The config parram 'enable_dev' has been setted to 'false'; to enable dev mode , set it to 'true' in   /application/configs/config.php.	";
            exit();
        }
    }

    public function getDb() {
        $db = Rong_Db::factory( config("database.default.adapter"), config("database.default") );
        Rong_Db_Model::setDefaultDb( $db );
        return $db;
    }

    public function init() {
        parent::init();
        $this->view->viewsDirectory = ( dirname(__FILE__) . "/templates");
    }

    public function indexAction() {
        $data = array();
        $db = $this->getDb();
        $tables = $db->fetchAll("show tables");
        $dbname = config("database.default.dbname")  ;

        $tableArray = array();
        $key = "Tables_in_" . $dbname;
        for ($i = 0; $i < count($tables); $i++) {
            $tableArray[] = $tables[$i][$key];
        }
        $data["tableArray"] = $tableArray;
        $this->view->display("Index/index.phtml", $data);
    }

    public function fieldsAction() {

        $data["table_name"] = $table_name = $_POST["table_name"];
        $data["model_name"] = $_POST["model_name"];
        if( trim($_POST["model_name"]) == "" )
        {
            //echo "blank";echo $this->config["table_prefix"]; print_r( $this->config );
            $data["model_name"] = substr( $table_name, strlen( config("database.default.table_prefix") ));
        }
        $has_error = false;
        $msg = "";
        if( substr( $table_name,0, strlen( config("database.default.table_prefix") ) ) != config("database.default.table_prefix")  )
        {
            $has_error = true;
            $msg .= "wrong table prefix! the table prefix is:" . config("database.default.table_prefix") . ",please change table `" . $table_name . "` to `" .config("database.default.table_prefix") . $table_name . "` <br />" ;
        }
        $db = $this->getDb();
        $data["fields"] = $fields = $db->fetchAll("show full columns from " . $table_name);
        if (count($fields) == 0) {
            $msg .= "The table does not exists,please go back and choose one!";
            $msg .= "<br /><a href=\"/index.php/dev\">back</a>";
            $has_error = true;
        }
        $this->view->set("msg" , $msg );
        $this->view->set("has_error" , $has_error );
        $this->view->display("Index/fields.phtml", $data);
    }

    public function writeAction() {

        $data = $_POST;
        $data["post"] = $_POST;
        $table_name = $_POST["table_name"];
        $table_prefix = config("database.default.table_prefix")   ;
        $tableNameWithoutPrefix = "";
        if ($table_prefix != "" && strpos($table_name, $table_prefix) == 0) {
            $tableNameWithoutPrefix = substr( $table_name, strlen( $table_prefix));
        }
        $data["class"] = $class = $tableNameWithoutPrefix;
        //echo $table_name; echo ","; echo $table_prefix; echo ","; echo $tableNameWithoutPrefix; exit();
        $db = $this->getDb();
        $data["fields"] = $fields = $db->fetchAll("show full columns from " . $table_name);
        $commonFields = $priFields = array();


        $paramList = "";
        $priStr = "";
        $priArr = array();
        $sqlFields = "";
        $priQueryStr = "";

        for ($i = 0; $i < count($fields); $i++) {
            $paramList .= ( $i == 0 ) ? "" : ",";
            $paramList .= "\$" . $fields[$i]["Field"];
            $sqlFields .= ( $i == 0 ) ? "" : ",";
            $sqlFields .= $fields[$i]["Field"];
            if ($fields[$i]["Key"] == "PRI") {
                $priFields[] = $fields[$i];
                $priArr[] =   $fields[$i]["Field"] . " ='$" . $fields[$i]["Field"] . "'";
                $priQueryStr .= ( $i == 0 ) ? "" : "&";
                $priQueryStr .= $fields[$i]["Field"] . "=<?=\$Data[\$i][\"" . $fields[$i]["Field"] . "\"]?>";
            } else {
                $commonFields[] = $fields[$i];
            }
        }
        $priStr = implode(" and ", $priArr);
        $data["priQueryStr"] = $priQueryStr;
        $data["commonFields"] = $commonFields;
        $data["priStr"] = $priStr;
        $data["paramList"] = $paramList;
        $data["priFields"] = $priFields;
        $data["sqlFields"] = $sqlFields;
        //print_r( $data["fields"] );
        if (strtolower($tableNameWithoutPrefix) == "dev") {
            throw new Rong_Exception("can not use \"dev\" as table name! ");
            exit();
        }
        //check if the CRUD has been checked or not
        $functions = $_POST["functions"];
        for ($i = 0; $i < count($functions); $i++) {
            $data["need_" . $functions[$i]] = "TRUE";
        }
        //create the view folder if it's not exists
        $viewDir = $this->getViewsDirectory() . "/" . strtolower($tableNameWithoutPrefix);
        if (!is_dir($viewDir)) {
            mkdir($viewDir);
        }
        //controller
        $controllerDir = $this->getControllersDirectory();
        $this->saveFile($controllerDir . "/" . ucfirst($tableNameWithoutPrefix) . "Controller.php", "code/TplController.phtml", $data);
        //model
        $modelDir = $this->getModelsDirectory();
        $this->saveFile($modelDir . "/" . ucfirst($class) . "Model.php", "code/TplModel.phtml", $data);
        //view add.phtml
        $this->saveFile($viewDir . "/add.phtml", "code/view/add.phtml", $data);
        $this->saveFile($viewDir . "/edit.phtml", "code/view/edit.phtml", $data);
        $this->saveFile($viewDir . "/manage.phtml", "code/view/manage.phtml", $data);
        $this->saveFile($viewDir . "/index.phtml", "code/view/index.phtml", $data);
        $this->saveFile($viewDir . "/show.phtml", "code/view/show.phtml", $data);
        
        $this->view->set("generatedFiles", $this->generatedFiles );
        $this->view->display("Index/write.phtml", $data);
    }
    public $generatedFiles = "";
    public function saveFile($realFile, $tplFile, $data) {
        $content = $this->view->display($tplFile, $data, true);
        file_put_contents($realFile, $content);
        $this->generatedFiles .= "Generate file:" . $realFile . "<br />";
    }

   

}

?>