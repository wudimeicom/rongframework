<?php
require_once ROOT . '/application/includes/load.php';
class ForController extends Rong_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //url: http://127.0.0.9/index.php/test/wudimei/For/index
    public function indexAction()
    {
        $wudimei = load_wudimei();
        $wudimei->forceCompile = true;
        $friends = array("Jim","HanMeimei","LiLei");
        $wudimei->assign("friends", $friends);
        
        $languages = array(
            array("name" => "java", "company" => "oracle"),
            array("name" => "c#", "company" => "microsoft" ),
            array("name" => "php" , "company" => "zend")
        );
        $wudimei->assign("languages", $languages );
        
        $wudimei->display("test/wudimei/For/index.html");
    }
}
?>
