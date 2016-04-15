<?php

spl_autoload_register(function ($class) {
	
	if( strpos($class,"Rong_") === 0 ){
		$file = dirname(__DIR__) . "/" . str_replace("_","/", $class) . ".php";
		 //echo $file;
		if( file_exists( $file ) ){
			require_once $file;
		}
	}
	
});


