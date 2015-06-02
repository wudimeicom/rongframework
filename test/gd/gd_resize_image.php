<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/Gd/ResizeImage.php';

$img = new Rong_Gd_ResizeImage();
$img->dest_width = 50;
$img->dest_height = 50;
$img->bg_color = array( 233,234,256 ); //r g b
$img->type = Rong_Gd_ResizeImage::TYPE_FILL_BLANK; //缩放，两边涂白
//$img->type = Rong_Gd_ResizeImage::TYPE_CROP;  //缩放并剪裁
$img ->resizeImage( dirname(__FILE__)."/data/Yqr.jpg");
//$img->display(100); //在当前窗口显示
$img->save( dirname(__FILE__)."/data/Yqr_small.jpg",100 );

echo 'Author of Rong framework:Yang Qing-rong <br />';
echo '<img src="data/Yqr.jpg" /> <img src="data/Yqr_small.jpg" />';
