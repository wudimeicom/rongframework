<?php
require_once 'Rong/Service/Client.php';
class ClientController extends Rong_Controller{
    
    public function indexAction(){
        //$GLOBALS["debug"] =1;
        $client = new Rong_Service_Client("http://127.0.0.9/index.php/test/service/server");
        $client->password = "S0dfSl_we9*fsafs@f";
		$client->postArray = array("p" =>12);
        $ret = $client->hello("yqr",25);
        echo "callback:". $ret;
        echo "<br />";
		$client->setClass("B"); //blank to call function
        $ret = $client->helloA( array("yqr","wdm",3), "arr" );
        echo "callback:" ; 
        print_r(  $ret );
		
		echo "<br />msg:" . $client->getServerMessage();
       
    }
}
?>
