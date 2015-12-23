<?php

$PathToRongFramework = dirname(__FILE__) . "/../../lib";

$PathToRongFramework = "d:/www/wudimei/library";

set_include_path("." . PATH_SEPARATOR . $PathToRongFramework . PATH_SEPARATOR . get_include_path());

$config = array(
	"save_path" => "d:/tmp/session",
	"gc_maxlifetime" => 500,//seconds
	"cookie_path" => "/",
	"cookie_domain" => "swudimei.com2",
	"cookie_lifetime" => 3
);
require_once 'Rong/Session.php';
Rong_Session::factory("File", $config);
Rong_Session::start();

echo $_SESSION["name"] ;

?>

<a href="session1.php">session1</a>
