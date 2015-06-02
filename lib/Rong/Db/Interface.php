<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
interface Rong_Db_Interface
{
	public function call( $sql );
	public function query( $sql );
	public function fetchAll( $sql );
	public function limit( $sql, $page , $pageSize );
	public function delete( $table , $where );
	public function update( $table , $data, $where );
	public function insert( $table , $data  );
	public function insertId( );
	public function affectedRows( );
	public function numFields();
	public function numRows();
}
?>