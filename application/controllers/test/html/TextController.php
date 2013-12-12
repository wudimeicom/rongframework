<?php
require_once 'Rong/Html/TextField.php';
require_once 'Rong/Html/Textarea.php';
class TextController extends Rong_Controller{
    public function __construct()
    {
        parent::__construct();
    }
    
    //url: http://127.0.0.9/index.php/test/html/Text/index
    public function indexAction()
    {
        echo "enter title:";
        $tf = new Rong_Html_TextField();
        $tf->set("id","title")->set("name","title")->set("value","Hello,world");
        echo $tf->toHtml();
        
        echo "<br />enter content:";
        $ta = new Rong_Html_Textarea();
        $ta->set("id","content")->set("name","content");
        $ta->set("cols",60)->set("rows",5);
        $ta->text = "&lt;hr&gt;hello,world";
        echo $ta->toHtml();
        
    }
}
?>
