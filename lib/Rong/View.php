<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2010 Yang Qing-rong
 * This is a free software.
 * 
 */
 require_once 'Rong/Object.php';
 
class Rong_View extends Rong_Object 
{
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $engine
	 * @param unknown_type $config
	 * @return Rong_View_PHP
	 */
	public static function factory( $engine = "PHP" , $config = array() )
	{
		require_once 'Rong/View/' . $engine . ".php";
		$engineClass = "Rong_View_" . $engine;
		return new $engineClass();
	}
}
?>