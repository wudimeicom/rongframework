<?php
require_once 'Rong/Service/Server.php';

function hello($name, $age){
    return $name . "," . $age . "postP:". $_POST["p"];
}

class A{
   
    function helloA( $arr , $str){
        $arr["string"] = $str;
        return $arr;
    }
}


class B{
   
    function helloA( $arr , $str){
        return "hello,b";
    }
}

class ServerController extends Rong_Controller{
     
    public function indexAction(){
		
        $server = new Rong_Service_Server();
        $server->password = "S0dfSl_we9*fsafs@f";
        $server->addFunction("hello");
        $server->addClass("A" , new A() );
		$server->addClass("B" , new B() );
        $server->start();
    }
}
?>
