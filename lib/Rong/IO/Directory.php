<?php
class Rong_IO_Directory{
    
    public $dir;
    public function __construct( $dir ){
        $this->dir = $dir;
    }
    
    public function list_files(){
        $arr = array();
        $dirObj = dir( $this->dir );
        while( ( $f = $dirObj->read() ) !== false ){
            if( $f != "." && $f != ".." ){
               $arr[] = $f; 
            }
        }
        $dirObj->close();
        return $arr;
    }
	
	public function getSubFolders(){
        $arr = array();
        $dirObj = dir( $this->dir );
        while( ( $f = $dirObj->read() ) !== false ){
            if( $f != "." && $f != ".." ){
			   if( is_dir( $this->dir . "/" . $f ) ){
                 $arr[] = $f; 
			   }
            }
        }
        $dirObj->close();
        return $arr;
    }
    
    public function list_images(){
        $arr = $this->list_files();
        $imageFiles = array();
        for( $i=0; $i<count( $arr ); $i++ ){
            $file = $arr[$i];
            $fileObj = new WFile( $file );
            if( $fileObj->isImage() ){
                $imageFiles[] = $file;
            }
        }
        return $imageFiles;
    }
}