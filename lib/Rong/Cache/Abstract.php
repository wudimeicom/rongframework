<?php
require_once 'Rong/Cache/Interface.php';
abstract class Rong_Cache_Abstract extends Rong_Object implements Rong_Cache_Interface 
{
	public $config = array( );
	
	public function __construct( $config )
	{
		$this->config = $config;
		parent::__construct();
		
	}
	
}
?>