<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
class Rong_Exception extends Exception 
{
	public function __construct( $message , $code = 0 )
	{
		parent::__construct( $message , $code );
	}
}
?>