<?php
class Rong_Acl_Account extends Rong_Acl_Abstract 
{
	public $roles = array();
	public function __construct( $id , $name , $rolesArray =array() )
	{
		parent::__construct( $id , $name ) ;
		$this->roles = $rolesArray ;
	}
	
}
?>