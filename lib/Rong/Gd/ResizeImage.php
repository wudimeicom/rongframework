<?php

require_once 'Rong/Object.php';

class Rong_Gd_ResizeImage extends Rong_Object
{

   

    const TYPE_FILL_BLANK = 'fill_blank';
    const TYPE_CROP = 'crop';

    public $type = self::TYPE_FILL_BLANK;
    public $dest_width = 100;
    public $dest_height = 100;
    public $dest_im;
    public $bg_color = array( 255,255,255);
    public function __construct()
    {
        
    }

     
    function resizeImage($ImageFile)
    {
        list($ImageFileWidth, $ImageFileHeight ) = getimagesize($ImageFile);
        //$Height = (int) (( $Width / $ImageFileWidth ) * $ImageFileHeight );
        $size = $this->resize($ImageFileWidth, $ImageFileHeight, $this->dest_width, $this->dest_height);

        $this->dest_im = imagecreatetruecolor($this->dest_width, $this->dest_height);
        $bgColor = imagecolorallocate( $this->dest_im, $this->bg_color[0], $this->bg_color[1] , $this->bg_color[2] );
        imagefill( $this->dest_im , 0, 0, $bgColor );
        
        $image = $this->getImageHandle($ImageFile);

        imagecopyresampled($this->dest_im, $image, $size["dest_left"], $size["dest_top"], $size["src_left"], $size["src_top"], $size["dest_width"], $size["dest_height"], $size["src_width"], $size["src_height"]);
    }

    public function save($path, $quality = 100)
    {
        //$DistFile = dirname( $ImageFile ) . "/samll_" . basename( $ImageFile );
        imagejpeg($this->dest_im, $path, $quality);
    }
    
    public function display( $quality )
    {
        header("content-type:image/jpeg");
        imagejpeg( $this->dest_im );
    }

    /**
     * 
     * @param type $srcWidth
     * @param type $srcHeight
     * @param type $distWidth
     * @param type $distHeight
     * @param type $type fill_blank crop
     */
    function resize($srcWidth, $srcHeight, $destWidth, $destHeight)
    {
        $newHeight = 0;
        $newWidth = 0;
        $srcLeft = 0;
        $srcTop = 0;
        $destLeft = 0;
        $destTop = 0;
        if ($this->type == self::TYPE_FILL_BLANK)
        {
            $rate = $destHeight / $srcHeight;
            $newHeight = $destHeight;
            $newWidth = $srcWidth * $rate;
            if ($newWidth > $destWidth)
            {

                $newHeight = $newHeight * ( $destWidth / $newWidth);
                $newWidth = $destWidth;
            }
            $destLeft = ( $destWidth - $newWidth ) / 2;
            $destTop = ( $destHeight - $newHeight ) / 2;
        }
        elseif($this->type == self::TYPE_CROP )
        {
            $rate = $destHeight / $srcHeight;
            $newHeight = $destHeight;
            $newWidth = $srcWidth * $rate;
            if ($newWidth < $destWidth)
            {

               $newHeight = $srcHeight*($destWidth/$srcWidth) ;
               $newWidth = $destWidth;
            }
            $destLeft = ( $destWidth - $newWidth ) / 2;
            $destTop = ( $destHeight - $newHeight ) / 2;
        }
        return array(
            "src_left" => $srcLeft,
            "src_top" => $srcTop,
            "src_width" => $srcWidth,
            "src_height" => $srcHeight,
            "dest_left" => $destLeft,
            "dest_top" => $destTop,
            "dest_width" => $newWidth,
            "dest_height" => $newHeight
        );
    }

    public function getImageHandle($ImageFile)
    {
    	$extArr = explode(".", $ImageFile );
		$ImageFileExt = strtolower( $extArr[ count( $extArr)-1 ] );
        
        switch ($ImageFileExt)
        {
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($ImageFile);
                break;
            case "gif":
                $image = imagecreatefromgif($ImageFile);
                break;
            case "png":
                $image = imagecreatefrompng($ImageFile);
        }
        return $image;
    }

}

?>
