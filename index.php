<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */	
ini_set( "display_errors" , "1" );
define( "ROOT" , dirname( __FILE__ ) );
set_include_path( 
				    "." . PATH_SEPARATOR .
				    // ROOT."/lib".
				  "d:/www/wudimei/wudimei.com/lib" .
				    PATH_SEPARATOR . get_include_path() 
			   );


include ROOT . "/application/configs/config.php";
require_once ROOT . "/application/includes/MessagePanel.php";
require_once ROOT . "/application/includes/functions.php";
require_once ROOT . "/application/includes/load.php";



require_once 'Rong/Controller/Route.php';
$route = new Rong_Controller_Route();

$route->add( "product-:num.html","test/route/Route/product/$1" );
$route->add("user/:num/:word/:any.html" , "test/route/Route/user/$1/$2/$3" );
$route->add( 'article/([0-9]{3,4})/([a-zA-Z]{1,3})\.html\?id=:num' , 'test/route/Route/article/$1/$2/$3' );

require_once 'Rong/Controller/Engine.php';
$engine = new Rong_Controller_Engine();
$engine->setRoute($route);
$engine->setControllersDirectory( ROOT . "/application/controllers");
$engine->start();				  		  
?>