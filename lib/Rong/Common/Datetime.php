<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
class Rong_Common_Datetime
{
	public function getDate( $strDateTime )
	{
		return date( "Y-m-d" , strtotime( $strDateTime ) );
	}
	
	public function getTime( $strDateTime )
	{
		return date( "H:i:s" , strtotime( $strDateTime ) );
	}
	public function setTimezone( $timeZone ="Asia/Shanghai" )
	{
		date_default_timezone_set( $timeZone );
	}
}
?>