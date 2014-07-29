<?php


define( "ROOT" , dirname( __FILE__ ) . "/../../../" );

set_include_path( "." . PATH_SEPARATOR .
				  ROOT."/lib". PATH_SEPARATOR.
				  get_include_path() 
				); 

require_once "Rong/Search/Analyzer/CS/Client.php";
		$client = new Rong_Search_Analyzer_CS_Client();
		$ret =$client->segment($text="杨庆荣你好,how are you yang qing rong?");
		print_r( $ret );
