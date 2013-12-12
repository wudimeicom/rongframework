<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Object.php';
class Rong_Db extends Rong_Object 
{
	/**
	 * instance a db driver
	 *
	 * @param  string $adapter
	 * @param array $config
	 * @return  Rong_DB_Abstract
	 */
	public static function factory( $adapter, $config )
	{
		require_once 'Rong/Db/Driver/' . ucfirst( $adapter  ) . '.php';
		$className = 'Rong_Db_Driver_' . ucfirst( $adapter );
		$obj = new $className( $config );
		return $obj;
	}
}
?>