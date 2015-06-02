<?php
require_once 'Rong/Object.php';

class Rong_Cache extends Rong_Object 
{
	/**
	 * instance a cache object
	 *
	 * @param  string $adapter
	 * @param array $config
	 * @return  Rong_Cache_Driver_File
	 */
	public static function factory( $adapter , $config )
	{
		require_once "Rong/Cache/Driver/" . ucfirst( $adapter ) . ".php";
		$className = "Rong_Cache_Driver_" . ucfirst( $adapter ) ;
		$obj = new $className( $config );
		return $obj;
	}
}
?>