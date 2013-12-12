<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
  !! i will test it one or more days !!
 */
require_once 'Rong/Db/Abstract.php';

class Rong_Db_Driver_Mssql extends Rong_DB_Abstract {

    public $conn = null;
    public $result = null;

    public function __construct($config) {
        $this->fieldEscapeLeft = "[";
        $this->fieldEscapeRight = "]";
        if (!isset($config["port"])) {
            $config["port"] = 1433;
        }
        $this->conn = mssql_connect($config["host"] . ":" . $config["port"], $config["username"], $config["password"]);

        if ($this->conn) {
            mssql_select_db($config["dbname"], $this->conn);
            //$this->query( "set names " . $config["charset"]);
        } else {
            echo $this->error();
        }
        $this->setConfig($config);
    }

    public function call($sql) {
        $rows = array();
        $sqlArr = explode(";", $sql);
        for ($i = 0; $i < count($sqlArr); $i++) {
            if (strlen(trim($sqlArr[$i])) > 3) {
                $rows[] = $this->fetchAll($sqlArr[$i]);
            }
        }
        return $rows;
    }

    public function query($sql) {
        return $this->result = @mssql_query($sql, $this->conn);
    }

    public function fetchAll($sql) {
        $this->result = $result = @mssql_query($sql, $this->conn);
        $rows = array();
        while ($row = @mssql_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function insertId() {
        return -1;
    }

    public function affectedRows() {
        return mssql_affected_rows($this->conn);
    }

    public function error() {
        return "";
    }

    public function escape($str) {
        return mysql_escape_string($str);
    }

    public function numFields() {
        return mssql_num_fields($this->result);
    }

    public function numRows() {
        
    }

}

?>