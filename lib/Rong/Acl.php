<?php
require_once 'Rong/Acl/Abstract.php';
require_once 'Rong/Acl/Role.php';
require_once 'Rong/Acl/Resource.php';
require_once 'Rong/Acl/Account.php';

class Rong_Acl extends Rong_Object 
{
	private $roles = array();
	private $resources = array();
	private $accounts = array();
	private $acl = array();
	public  $parentRolesLine = "";
	public $parentResourcesLine = "";
	
	public function addAbstract( $abstractArrayName , Rong_Acl_Abstract $abstract )
	{
		$arr = & $this->$abstractArrayName;
		$found = false;
		for( $i=0; $i< count( $arr ) ; $i++ )
		{
			if( $arr[$i]->getId() == $abstract->getId() )
			{
				$found = true;
				break;
			}
		}
		
		if( $found )
		{
			return false;
		}
		else
		{
			
			$arr[] = $abstract ;
			return true ;
		}
	}
	
	public function addRole( Rong_Acl_Role $role )
	{
		 $this->addAbstract( "roles" , $role );
		 return $this;
	}
	
	public function addResource( Rong_Acl_Resource $resource )
	{
		$this->addAbstract( "resources" , $resource );
		return $this;
	}
	
	public function addAccount( Rong_Acl_Account $account )
	{
		$this->addAbstract( "accounts" , $account );
		return $this;
	}
	public function allow( $roleId , $resourceId , $operationsArray )
	{
		return $this->determine( $roleId , $resourceId , $operationsArray , "allowed" );
	}
	
	public function buildOperationsArray(  $oldOperationsArray , $operationsArray , $determine )
	{
		$operationsArrayNew = array();
		if( $operationsArray == "ALL" )
		{
			$operationsArrayNew["ALL"] =  $determine ;
		}
		else 
		{
			if( !empty( $oldOperationsArray ) )
			{
			    foreach ( $oldOperationsArray as $key => $value )
				{
					$operationsArrayNew[ $key ]= $value ;
				}
			}
			for( $i=0; $i< count( $operationsArray ); $i++ )
			{
				$operationsArrayNew[ $operationsArray[$i] ] =  $determine ;
			}
		}
		return $operationsArrayNew ;
	}
	
	public function deny( $roleId , $resourceId , $operationsArray )
	{
		return $this->determine( $roleId , $resourceId , $operationsArray , "denied" );
	}
	/**
	 * Revoke operation from role
	 *
	 * @param String $roleId
	 * @param String $ResourceId
	 * @param Array $operationArray  "ALL" revoke all
	 */
	public function determine( $roleId , $resourceId , $operationsArray , $determine )
	{
		$isFound = false ;
		for( $i=0; $i< count( $this->acl ) ; $i++ )
		{
			if( $this->acl[$i][0] == $roleId && $this->acl[$i][1] == $resourceId )
			{
				$isFound = true ;
				$opArr = & $this->acl[$i][2] ;
				$operationsArrayNew = $this->buildOperationsArray( $opArr , $operationsArray , $determine );
				$opArr = $operationsArrayNew ;
			}
		}
		
		if( ! $isFound )
		{
			$operationsArrayNew = $this->buildOperationsArray( null , $operationsArray , $determine );
			$this->acl[] = array( $roleId , $resourceId , $operationsArrayNew );
		}
		return $this;
	}
	/*
	 * return $this->parentRolesLine   eg: news_admin,national_news_admin,guest,haha,hehe,
	 */
	public function getParentRoles( $roleId )
	{
		if( trim( $roleId ) == "" )
		{
			return false;
		}
		$this->parentRolesLine .= $roleId . "," ;
		// echo $roleId . "<br />"; static $i; $i++; if( $i>20 ){ exit(); }
		//print_r( $this->roles ); exit();
		for( $i=0; $i< count( $this->roles ); $i++ )
		{
			if( $this->roles[$i]->getId() == $roleId )
			{
			
				$arr = $this->roles[$i]->getParentArray() ;	
				
				if( !empty( $arr ))
				{
					if( array_search( $roleId , $arr ) !== false ) //id in the parentArray
					{
						return false;
					}
					for( $j=0; $j< count( $arr ); $j++ )
					{
						$this->getParentRoles( $arr[$j ] );
					}
				}
			}
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $entityId
	 * @result $this->parentPropertiesLine
	 */
	public function getParentResources( $entityId )
	{
		$this->parentResourcesLine .= $entityId . ",";
		for( $i=0; $i< count( $this->resources ); $i++ )
		{
			if( $this->resources[$i]->getId() == $entityId )
			{
				$arr = $this->resources[$i]->getParentArray();
				if( !empty( $arr ) )
				{
					for( $j=0; $j< count( $arr ); $j++ )
					{
						$this->getParentResources( $arr[$j ] );
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * 
	 */
	public function isCurrentRoleAllowed(  $roleId , $ResourceId , $operation )
	{
		
		for( $i=0; $i< count( $this->acl ) ; $i++ )
		{
			if( $this->acl[$i][0] == $roleId  && $this->acl[$i][1] == $ResourceId  )
			{
				if(  @$this->acl[ $i ] [ 2 ][ "ALL" ]  == "allowed" )
				 {
				 	  return true ;
				 }
				 elseif(  @$this->acl[ $i ] [ 2 ][ "ALL" ]  == "denied"  )
				 {
				 	return false;
				 }
				 
				 if(  @$this->acl[ $i ] [ 2 ][ $operation ]  == "denied" )
				 {
				 	  return false ;
				 }
				 elseif(  @$this->acl[ $i ] [ 2 ][ $operation ]  == "allowed"  )
				 {
				 	return  true;
				 }
				 else 
				 {
				 	return "EMPTY"; 
				 }
			}
		}
		
		return "EMPTY";
	}
	
	public function isAllowed( $roleId , $ResourceId , $operation )
	{
		$this->parentRolesLine = "";
		$this->parentResourcesLine  = "" ;
		$this->getParentRoles( $roleId );
		$this->getParentResources( $ResourceId );
     
		$rolesArray = explode( "," , $this->parentRolesLine );
		$resourcesArray = explode( "," , $this->parentResourcesLine );
	    $result  = "" ;
	    
		for( $i= 0; $i< count( $rolesArray ); $i++ )
		{
			$roleItem = $rolesArray[$i];
			
			if( trim( $roleItem ) != "" )
			{
				
				for( $j=0; $j< count( $resourcesArray ); $j++ )
				{
					$ResourceItem = $resourcesArray[$j];
					if( trim( $ResourceItem ) != "" )
					{
						$result = $this->isCurrentRoleAllowed( $roleItem , $ResourceItem , $operation );
						if(  $result !== "EMPTY"  )
						{
							return  $result ;	
						}
					}
				}
			}
		}
		return false;
	}
	
	public function output( )
	{
		print_r( $this->roles );
		print_r( $this->resources );
		print_r( $this->accounts );
		print_r( $this->acl );
	}
	
	public function __sleep()
	{
		return array("roles","resources" , "accounts" , "acl");
	}
	
}
?>