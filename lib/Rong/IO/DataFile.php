<?php

class Rong_IO_DataFile{
	public $filePath;
	public  function __construct( $filePath1 )
	{
		$this->filePath = $filePath1;
	}
	
	
	public function save( $data )
	{
		$content = '<?php return ' . var_export( $data , true ) . '; ?>';
		file_put_contents( $this->filePath , $content );
	}
	
	
	public function read()
	{
		return include $this->filePath;
	}
	
	
}
