<?php
require_once 'Rong/Gd/ResizeImage.php';
class ImageController extends Rong_Controller 
{
	public function __construct()
	{
		
		parent::__construct();
		 
		
	}
	
	public function indexAction()
	{
		$data = array();
		$img = new Rong_Gd_ResizeImage();
                $img->dest_width = 200;
                $img->dest_height = 500;
                $img->bg_color = array( 233,234,256 ); //r g b
                $img->type = Rong_Gd_ResizeImage::TYPE_FILL_BLANK; //缩放，两边涂白
                //$img->type = Rong_Gd_ResizeImage::TYPE_CROP;  //缩放并剪裁
                $img ->resizeImage( "E:/wudimei/doc/a1.jpg");
                //$img->display(100); //在当前窗口显示
                $img->save( "e:/a1_small.jpg",100 );
		//$this->view->display( "index/index.phtml" , $data );
	}
        
}
?>
