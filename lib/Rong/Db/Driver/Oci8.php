<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 $config : username,password,port,host,sid
 !!no test!!
 */
require_once 'Rong/Db/Abstract.php';
class Rong_Db_Driver_Oci8 extends Rong_DB_Abstract 
{
	public $conn = null;
	public $stmt;
	public function __construct( $config )
	{
	    if( !isset( $config["port"] ) )
		{
			$config["port"] = 1521 ;
		}
		$hashCode = rand( 0 , 10000000 );
		$this->conn = oci_new_connect( $config["username"] , $config["password"]  , '
		(DESCRIPTION =
		           (ADDRESS = 
		       (PROTOCOL = TCP)
		       (HOST = '.  $config["host"]  .' )
		       (PORT = '. $config["port"] . ' )
		       (HASH = '.$hashCode .')
		     )
		         (CONNECT_DATA =(SID = '. $config["sid"] . '))
		     )
		');
		
		  
		if( $this->conn )
		{
			//mysql_select_db( $config["dbname"] , $this->conn );
			//$this->query( "set names " . $config["charset"]);
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
		$stmt = oci_parse( $this->conn , $sql );
		$this->stmt = $stmt;
		return oci_execute( $stmt );
	}
	
	public function fetchAll( $sql )
	{
		$stmt = oci_parse( $this->conn , $sql );
		$this->stmt = $stmt;
		oci_execute( $stmt );
		 
		$rows = array( );
		while( $row = oci_fetch_assoc( $stmt ) )
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
		return oci_error( $this->stmt );
	}
	
	public function escape( $str )
	{
		return mysql_escape_string( $str );
	}
	
	
	public function numFields()
	{
		return oci_num_fields( $this->stmt );
	}
	
	public function numRows()
	{
		return oci_num_rows( $this->stmt );
	}
	
}
?>