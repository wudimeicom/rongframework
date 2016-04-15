<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Db/Abstract.php';

class Rong_Db_Driver_Mysqli extends Rong_DB_Abstract {

    public $mysqli = null;
    public $result;

    public function __construct($config) {
        $this->leftQuotedIdentifier = "`";
        $this->rightQuotedIdentifier = "`";
        if (!isset($config["port"])) {
            $config["port"] = 3306;
        }
        $this->mysqli = new mysqli($config["host"], $config["username"], $config["password"], $config["dbname"], $config["port"]);
        $this->query("set names " . $config["charset"]);
        $this->setConfig($config);
    }

    public function call($sql) {
        $rows = array();
        if ($this->mysqli->multi_query($sql)) {
            while ($this->mysqli->more_results()) {
                @$this->mysqli->next_result();
                $resultRows = array();
                if ($result = $this->mysqli->store_result()) {
                    while ($row = $result->fetch_assoc()) {
                        $resultRows[] = $row;
                    }
                    $result->free();
                    $rows[] = $resultRows;
                }
            }
        }
        return $rows;
    }

    public function query($sql) {
        //echo $sql;
        $this->result = $this->mysqli->query($sql);

        if (isset($GLOBALS["debug"])) {
            echo "<div>" . $sql . "   --------";
            echo "\n<br />error:" . $this->error();
            echo "\n<br />insert id:" . $this->insertId();
            echo "\n<br />affected rows:" . $this->affectedRows() . "</div>";
        }
        return $this->result;
    }

    public function fetchAll($sql) {
        $result = $this->query($sql);
        $rows = array();
        if (is_object($result)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function escape($str) {
        //$str = $this->antiSqlInjection( $str );
        return $this->mysqli->real_escape_string($str);
    }

    public function insertId() {
        return $this->mysqli->insert_id;
    }

    public function affectedRows() {
        return $this->mysqli->affected_rows;
    }

    public function error() {
        return $this->mysqli->error;
    }

    public function numFields() {
        $this->mysqli->field_count;
    }

    public function numRows() {
        return $this->mysqli->num_rows;
    }
	/**
	 * only support innodb
	 */
	public function beginTransaction()
	{
		$this->query("set autocommit=0");
	}
	
	public function commit()
	{
		$this->query("commit");
	}
	
	public function rollback(){
		$this->query("rollback");
	}
	
	public function getTableNames(){
		$dt = $this->fetchAll("show tables");
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
		$sql = "show table status  where name='{$table}'";
		//echo $sql;
		$row = $this->fetchRow($sql);
		//echo mysql_error();
		return @$row["Comment"];
	}
	
	public function getColumns( $table ){
		$sql = "show full columns from " . $table;
		//echo $sql;
		$dt = $this->fetchAll($sql);
		//echo mysql_error();
		return $dt;
	}
}

?>