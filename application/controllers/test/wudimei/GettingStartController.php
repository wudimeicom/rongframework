<?php
 

class GettingStartController extends Rong_Controller
{

    public function __construct()
    {

        parent::__construct();
    }

    public function indexAction()
    {
        //initialize wudimei template enging
        require_once 'Rong/View/Wudimei.php';
        $wudimei = new Rong_View_Wudimei();
        $wudimei->compileDir = ROOT . "/data/compiled";

        $wudimei->viewsDirectory = ROOT . "/application/views";
        $wudimei->leftDelimiter = "{";
        $wudimei->rightDelimiter = "}";
        
        $wudimei->assign("msg", "Hello,World!");
        $wudimei->display("test/wudimei/GettingStart/index.html");
    }

    public function ifelseAction()
    {
         require_once 'Rong/View/Wudimei.php';
        $wudimei = new Rong_View_Wudimei();
        $wudimei->compileDir = ROOT . "/data/compiled";

        $wudimei->viewsDirectory = ROOT . "/application/views";
        $wudimei->leftDelimiter = "{";
        $wudimei->rightDelimiter = "}";
        
        $wudimei->forceCompile = true;
        
        $wudimei->assign("msg", "Hello,World!");
        $wudimei->assign("age", 16 );
        
        $man =new stdClass();
        $man->age = 20;
        
        $wudimei->assign("man" , $man );
        
       
        $wudimei->display("test/wudimei/GettingStart/ifelse.html");
    }
}

?>
