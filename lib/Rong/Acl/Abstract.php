<?php

require_once 'Rong/Object.php';
abstract class Rong_Acl_Abstract extends Rong_Object
{
	protected  $_id ;
	protected  $_name;
	protected  $_parentArray ;
	public function __construct( $id , $name )
	{
		$this->_id = $id ; 
		$this->_name = $name ;
	}
	public function getName()
	{
		return $this->_name ;
	}
	
	public function getId()
	{
		return $this->_id ;
	}
	
	public function getParentArray()
	{
		return $this->_parentArray ;
	}
}
?>