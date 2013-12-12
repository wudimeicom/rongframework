<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2010 Yang Qing-rong
 * This is a free software.
 */


require_once 'Rong/Text/String.php';

class Rong_Object
{
	public static $objects;
	public function __construct( )
	{
	
	}
	
	public static  function setObject( $key , $value )
	{
		self::$objects[$key] = $value ;
	}
	
	public static function getObject( $key )
	{
		return @self::$objects[$key];
	}
	
	public function removeObject( $key )
	{
		unset( self::$objects[$key] );
	}
	
	public static function version()
	{
		return "rong framework 0.6";
	}
}
?>