<?php

class StudentsController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    /**
     * http://127.0.0.9/test/wudimei/Students
     */
     public function indexAction() {
        
        require_once 'Rong/View/Wudimei.php';
        $wudimei = new Rong_View_Wudimei();
        $wudimei->compileDir = ROOT . "/data/compiled";

        $wudimei->viewsDirectory = ROOT . "/application/views";
        $wudimei->leftDelimiter = "{";
        $wudimei->rightDelimiter = "}";
        
        $class = "one";
        $grade = 2;
        
        $students = array(
            array("id" => 1, "name" => "Yang Qing-rong", "age" => 25),
            array("id" => 2, "name" => "Yang 2", "age" => 28, "phones" => array("08613714715608", "298333")),
            array("id" => 3, "name" => "yang 3", "age" => 28),
            array("id" => 4, "name" => "yang 4", "age" => 28),
            array("id" => 5, "name" => "jim", "age" => 29,"nicks" => array(array("nick_name" => "baby"), array("nick_name" => "baby2")))
        );
        
        $wudimei->set("class", $class );
        $wudimei->set("grade", $grade );
        $wudimei->set("students", $students );
        
        $wudimei->display("test/wudimei/Students/index.tpl");
    }
    
}
?>
