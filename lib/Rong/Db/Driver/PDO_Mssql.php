<?php
require_once 'Rong/Db/Abstract.php';

class Rong_Db_Driver_PDO_Mssql extends Rong_DB_Abstract {

	public $conn = null;
	public $result = null;

	public function __construct($config) {
		$this->setConfig($config);
		$this->conn = new PDO( "sqlsrv:server=".$config["host"]." ; Database = ".$config["dbname"]."", $config["username"], $config["password"]);
	}
	public function call( $sql ){
		
	}
	public function query( $sql ){
		
	}
	public function fetchAll( $sql ){

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$dt = array();
		//$stmt->bindColumn('EmailAddress', $email);
		while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
			// echo "$email\n";
			//print_r( $row );
			$dt[] = $row;
		}
		return $dt;
	}
	public function limit( $sql, $page , $pageSize ){
		
	}
	public function delete( $table , $where ){
		
	}
	public function update( $table , $data, $where ){
		
	}
	public function insert( $table , $data  ){
		
	}
	public function insertId( ){
		
	}
	public function affectedRows( ){
		
	}
	public function numFields(){
		
	}
	public function numRows(){
		
	}
	
	public function getTableNames(){
		$dt = $this->fetchAll("SELECT Name FROM SysObjects Where XType='U' ORDER BY Name");
		$tables = array();
		for( $i=0;$i< count( $dt); $i++ ){
			$item = $dt[$i];
			$keys =array_keys($item);
			$tbl = $item[$keys[0]];
			$tables[] = $tbl;
		}
		return $tables;
	}
	
	public function getTableComment( $table ){
		$sql = "SELECT
A.name AS table_name,
B.name AS column_name,
C.value AS column_description
FROM sys.tables A
INNER JOIN sys.columns B ON B.object_id = A.object_id
LEFT JOIN sys.extended_properties C ON C.major_id = B.object_id AND C.minor_id = B.column_id
WHERE A.name = '$table'";
		//echo $sql;
		$row = $this->fetchRow($sql);
		echo mysql_error();
		return @$row["Comment"];
	}
	
	public function getColumns( $table ){
		$sql = "Select Name as Field,xtype,isnullable,length FROM SysColumns Where id=Object_Id('".$table."')"  ;
		//echo $sql;
		$dt = $this->fetchAll($sql);
		echo mysql_error();
		return $dt;
	}
	
	public function getPrimaryKeys(){
		
	}
}