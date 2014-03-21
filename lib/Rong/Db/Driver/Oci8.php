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
	
	public $mode = OCI_COMMIT_ON_SUCCESS;
	public function __construct( $config )
	{
		$this->leftQuotedIdentifier = '"';
		$this->rightQuotedIdentifier = '"';
		
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
		$r = oci_execute( $stmt , $this->mode );
		if (isset($GLOBALS["debug"])) {
            echo "<div>" . $sql . "   --------";
            echo "\n<br />error:" . $this->error();
            echo "\n<br />insert id:" . $this->insertId();
            echo "\n<br />affected rows:" . $this->affectedRows() . "</div>";
        }
		return $r;
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
		return @oci_error( $this->stmt );
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
	
	public function beginTransaction(){
		$this->mode = OCI_NO_AUTO_COMMIT;
	}
	
	public function commit(){
		return oci_commit( $this->conn );
	}
	
	public function rollback(){
		return oci_rollback( $this->conn );
	}
	
	public function addLimitClause($sql,$rowCount,$offset)
	{
		$str = "select * from(select myview.*,rownum row_index from(". $sql.") myview where rownum<=".($offset+$rowCount).") where row_index>" . $offset;
		
		return $str;
	}
	
	
}
?>