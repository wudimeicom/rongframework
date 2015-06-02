<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
class Rong_Import extends Rong_Object 
{
	public $modelsDirectory;
	
	/**
	 * @return the $modelsDirectory
	 */
	public function getModelsDirectory() {
		return $this->modelsDirectory;
	}

	/**
	 * @param field_type $modelsDirectory
	 */
	public function setModelsDirectory($modelsDirectory) {
		$this->modelsDirectory = $modelsDirectory;
	}

	public function __construct( )
	{
		parent::__construct();
	}
	
	/**
	 * import rong model
	 *
	 * @param string $ModelName
	 * @return  Rong_Db_Model
	 */
	public function model( $ModelName )
	{
		return $this->load( $this->getModelsDirectory() , $ModelName );
	}
	
	public function load( $modelsDirectory , $ClassName  )
	{
		 
		$fileName = $modelsDirectory . "/" . $ClassName . ".php" ;
		require_once $fileName;
		list( $class , $ext ) = explode( "." , basename( $fileName ) );
		$obj = new $class();
		return $obj;
	}
}
?>