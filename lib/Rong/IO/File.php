<?php
require_once 'Rong/IO/Abstract.php';
class Rong_IO_File extends Rong_IO_Abstract 
{
	public $filename;
	public function __construct( $filename )
	{
		$this->filename = $filename;
	}
	
	public function getExt(  )
	{
		$arr = explode( "." , $this->filename );
		$ext = strtolower( $arr[ count( $arr ) -1 ] );
		return $ext;
	}

    public function removeTree( $dir = "" )
    {
        if( $dir == "" ) $dir = $this->filename;
        if( !is_dir( $dir ) ) return false;
        $dirObj = dir( $dir );
        while( $file = $dirObj->read() )
        {
            if( $file != "." && $file != ".." )
            {
                $curPath = $dir . "/" . $file;
                if(is_dir( $curPath ) )
                {
                    $this->removeTree( $curPath);
                }
                else
                {
                   // chmod($curPath, 0777 );
                  // echo  system("sudo chmod 777 " . $curPath . " -R");
                    unlink( $curPath );
                }
            }
        }
    }
	/**
	 * @return Rong_IO_File array
	 */
	public function listFiles()
	{
		$dir = dir( $this->filename );
		$fileArr = array();
		while( ($file= $dir->read()) !== false )
		{
			if( $file != "." && $file != ".." )
			{
				$path = $this->filename . "/" . $file;
				$fileObj = new Rong_IO_File( $path );
				$fileArr[] = $fileObj;
			}
		}
		$dir->close();
		return $fileArr;
	}
	
	public function isDirectory()
	{
		return is_dir( $this->filename );
	}
	
	public function isFile(){
		return is_file( $this->filename );
	}
	
	public function exists()
	{
		return file_exists( $this->filename );
	}
	
	public function baseName(){
		return basename( $this->filename );
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
}