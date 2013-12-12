<?php
class Rong_Gd_Image extends Rong_Object 
{
	
	public function __construct( )
	{
		
	}
	
	function resizeToFile( $ImageFile , $Width ) 
	{
	   list($ImageFileWidth , $ImageFileHeight ) = getimagesize( $ImageFile );
	   $Height = (int) (( $Width / $ImageFileWidth ) * $ImageFileHeight );
      
       
	   $ImageNewFile = imagecreatetruecolor($Width, $Height);
	  $image = $this->getImageHandle($ImageFile);
	   
	   imagecopyresampled($ImageNewFile, $image, 0, 0, 0, 0, $Width, $Height, $ImageFileWidth, $ImageFileHeight );
	   $DistFile = dirname( $ImageFile ) . "/samll_" . basename( $ImageFile );
	   imagejpeg( $ImageNewFile, $DistFile, 100);
	   return $DistFile;
	}

        public  function getImageHandle( $ImageFile )
        {
            $strImageFile = new Rong_Text_String($ImageFile );
             $ImageFileExt = $strImageFile->getFileExt(  );
             switch ( $ImageFileExt )
	   {
	   	case "jpg":
	   	case "jpeg":
	   		$image = imagecreatefromjpeg( $ImageFile );
	   		break;
	   	case "gif":
	   		$image = imagecreatefromgif( $ImageFile );
	   		break;
	   	case "png":
	   		$image = imagecreatefrompng( $ImageFile );
	   }
           return $image;
        }
}
?>