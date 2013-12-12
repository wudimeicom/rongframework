<?php

class PhpViewController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    //url: http://127.0.0.9/index.php/test/phpview/PhpView
    //url: http://127.0.0.9/test/phpview/PhpView
    public function indexAction(){
        $data["title"] = "hello,world";
        $data["content"] = "are you there ";
        $data["friends"] = array( 
                                     array( "id" =>"1" , "name"=>"Lucy" ),
                                    array( "id"=>2 , "name"=>"Jim" ) 
                                 );

         $this->view->display( "test/phpview/PhpView_index.php" , $data , false );
    }
}
?>
