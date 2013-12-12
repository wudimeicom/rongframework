<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2010 Yang Qing-rong
 * This is a free software.  entity
 */
ini_set("display_errors", "1");
 
class IndexController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }

    public function indexAction() {
        $data = array();
        //MessagePanel::show("你好", "google.com", 10 );exit();
        
        $this->view->display("index/index.phtml", $data);
    }
    
    public function testingAction() {
        $data = array();
        //MessagePanel::show("你好", "google.com", 10 );exit();
        
        $this->view->display("index/testing.php", $data);
    }
   

}

?>