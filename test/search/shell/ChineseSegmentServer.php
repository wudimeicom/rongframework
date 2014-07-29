<?php
ini_set("display_errors",1);
error_reporting(E_ALL |E_NOTICE|E_ERROR|E_WARNING);

echo "abc";

define( "ROOT" , dirname(dirname(dirname(dirname( __FILE__ ))))   );

set_include_path( "." . PATH_SEPARATOR .
				  ROOT."/lib". PATH_SEPARATOR.
				  get_include_path() 
				);
				
				ini_set("memory_limit","256M");
require_once "Rong/Search/Analyzer/CS/Server.php";

$server = new Rong_Search_Analyzer_CS_Server("127.0.0.1",5050);
$server->driver ="Chinese";
$server->config = array('dictionary_path' => dirname(__FILE__) . "/../data/chinese_dict-1.0.dat");
$server->start();

