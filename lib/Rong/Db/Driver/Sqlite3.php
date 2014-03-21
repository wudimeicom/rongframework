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

class Rong_Db_Driver_Sqlite3 extends Rong_DB_Abstract 
{
	/**
	 * @var SQLite3
	 */
	public $conn = null;
	public $result=null;
	public function __construct( $config )
	{
	    $this->conn = new SQLite3( $config["filename"],$config["flags"],$config["encryption_key"] );
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
		
		
		 $this->result = $this->conn->query($sql);
		 
		 if (isset($GLOBALS["debug"])) {
            echo "<div>" . $sql . "   --------";
            echo "\n<br />error:" . $this->error();
            echo "\n<br />insert id:" . $this->insertId();
            echo "\n<br />affected rows:" . $this->affectedRows() . "</div>";
        }
		 return $this->result;
	}
	
	public function fetchAll( $sql )
	{
		 $result = $this->query( $sql );
		 $rows = array();
		 while( $row =$result->fetchArray(SQLITE3_ASSOC) )
		 {
		 	$rows[] = $row;
		 }
		
		return $rows;
	}
	
	public function insertId( )
	{
		return   $this->conn->lastInsertRowID( );
	}
	
	public function affectedRows( )
	{
		return  1;
	}
	
	public function error( )
	{
		 return $this->conn->lastErrorMsg();
	}
	
	public function escape( $str )
	{
		 return SQLite3::escapeString ($str);
	}
	
	public function numFields()
	{
		 return $this->result->numColumns ();
	}
	
	public function numRows()
	{
		return -1;
	}
	public function beginTransaction()
	{
		$this->query("begin transaction");
	}
	
	public function commit()
	{
		$this->query("commit transaction");
	}
	
	public function rollback(){
		$this->query("rollback transaction");
	}
	
	
}
?>