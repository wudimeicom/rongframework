<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/View.php';
$view =  Rong_View::factory("PHP",array());
$view->setViewsDirectory( dirname(__FILE__) . "/template_php");

//cache the view for 30 seconds
/*
$view->cache(  dirname(__FILE__) ."/template_php/view_cache/cache1.php" , 30  );
*/		
$view->assign("name", "Yang Qing-rong");

$friends = array(
 array(
 	"id" =>1,
 	"name" => "sun wu kong"
 ),
 array(
 	"id" =>2,
 	"name" => "zhu ba jie"
 ),
 
);
$view->assign("friends", $friends);

/*
$viewContent = $view->fetch( "article/index.php");
echo $viewContent;
 */
 
$view->display("article/index.php");

