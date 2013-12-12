<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Db/Abstract.php';
require_once 'Rong/Exception.php';

class Rong_Db_Driver_Sqlite extends Rong_DB_Abstract 
{
	public $conn = null;
	public $result=null;
	public function __construct( $config )
	{
	    $errorMsg;
	    if( !function_exists("sqlite_open"))
	    {
	    	throw new Rong_Exception("sqlite driver is not enable,please configure php.ini");
	    }
		
	    if( $this->conn =  sqlite_open( $config["filename"] , $config["mode"] , $errorMsg ) )
	    {
	    	
	    }
	    else {
	    	throw new Rong_Exception( $errorMsg );
	    }
            $this->setConfig($config);
	}
	
	public function call( $sql )
	{
		$rows = array( );
		$sqlArr = explode( ";" , $sql );
		for( $i=0; $i< count( $sqlArr ); $i++ )
		{
			if( strlen( trim( $sqlArr[$i]) )> 3 )
			{
				$rows[] = $this->fetchAll( $sqlArr[$i] );
			}
		}
		return $rows;
	}
	
	public function query( $sql )
	{
		
		return $this->result = sqlite_query ( $sql  , $this->conn , SQLITE_ASSOC );
	}
	
	public function fetchAll( $sql )
	{
		$this->result = $result = $this->query( $sql );
		$rows = sqlite_fetch_all( $result , SQLITE_ASSOC );
		
		return $rows;
	}
	
	public function insertId( )
	{
		return sqlite_last_insert_rowid ( $this->conn );
	}
	
	public function affectedRows( )
	{
		return  1;
	}
	
	public function error( )
	{
		if( sqlite_last_error ( $this->conn ) == 0 )
		{
			return "";
		}
		else 
		{
			return sqlite_error_string ( sqlite_last_error ( $this->conn ) );
		}
	}
	
	public function escape( $str )
	{
		return sqlite_escape_string ( $str );
	}
	
	public function numFields()
	{
		return sqlite_num_fields( $this->result  );
	}
	
	public function numRows()
	{
		return sqlite_num_rows( $this->result  );
	}
	
	
}
?>