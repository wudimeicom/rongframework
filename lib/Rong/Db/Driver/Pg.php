<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 $config: host,port,dbname,username,password
!!no test!!
 */
require_once 'Rong/Db/Abstract.php';
class Rong_Db_Driver_Pg extends Rong_DB_Abstract 
{
	public $conn = null;
	public $result = null;
	public function __construct( $config )
	{
		//"host=sheep port=5432 dbname=test user=lamb password=bar";
	    if( !isset( $config["port"] ) )
		{
			$config["port"] = 5432 ;
		}
		
		$this->conn = pg_connect( "host=" .$config["host"] . 
		" port=" .$config["port"] . " dbname=" .$config["dbname"] . " user=" .$config["username"] . 
		" password=" .$config["password"] ); 
		
		 
		 if( $this->conn )
		 {
		}
		else
		{
			echo $this->error();
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
		return $this->result = pg_query( $this->conn , $sql );
	}
	
	public function fetchAll( $sql )
	{
		$this->result = $result = pg_query( $this->conn , $sql );
		$rows = array( );
		while( $row = pg_fetch_assoc( $result ) )
		{
			$rows[]  = $row;
		}
		return $rows;
	}
	
	public function insertId( )
	{
		return -1;
	}
	public function affectedRows( )
	{
		return -1;
	}
	public function error( )
	{
		return pg_result_error( pg_get_result( $this->conn ) );
	}
	
	public function escape( $str )
	{
		return mysql_escape_string( $str );
	}
	
	public function numFields()
	{
		return pg_num_fields( $this->result  );
	}
	
	public function numRows()
	{
		return pg_num_rows( $this->result  );
	}
	
	public function beginTransaction()
	{
		$this->query("start transaction");
	}
	
	public function commit()
	{
		$this->query("commit");
	}
	
	public function rollback(){
		$this->query("rollback");
	}
	// savepoint rollbackto savepoint...pending
}
?>