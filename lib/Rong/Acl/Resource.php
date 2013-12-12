<?php
class Rong_Acl_Resource extends Rong_Acl_Abstract 
{
	public function __construct( $id , $name , $parentArray  = "" )
	{
		parent::__construct( $id , $name );
		$this->_parentArray  = $parentArray  ;
	}
}
?>