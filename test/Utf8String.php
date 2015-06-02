<?php

 ini_set( "display_errors" , "1" );
define( "ROOT" , dirname( __FILE__ ) );
set_include_path( 
				    "." . PATH_SEPARATOR .
				    //ROOT."/lib".
				   "d:/www/wudimei/wudimei.com/lib" .
				    PATH_SEPARATOR . get_include_path() 
			   );



require_once   'Rong/Common/Utf8String.php';
 
        $str = chr(bindec("11110001")) . chr(bindec("10011103")) . chr(bindec("10030003")). chr(bindec("10030003"));
        $str = "杨привет";
        $str = "杨გამარჯობა";
        $str = "Kaixo";
        $str = "سلام";
        $str = "안녕하세요.";
        $utf8 = new Rong_Common_Utf8String( $str );
        echo $name2= $utf8->subString(0,2  );
        file_put_contents("d:/name.txt", print_r( $utf8->getCharArray() , true ) . "  [" . $utf8->toString() . "]");
?>
