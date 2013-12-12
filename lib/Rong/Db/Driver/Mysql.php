<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Db/Abstract.php';

class Rong_Db_Driver_Mysql extends Rong_DB_Abstract
{

    public $conn = null;
    public $result;
	private $sql = "";
	
    public function __construct($config)
    {
        $this->fieldEscapeLeft = "`";
        $this->fieldEscapeRight = "`";
        if (!isset($config["port"]))
        {
            $config["port"] = 3306;
        }
        $this->conn = @mysql_connect($config["host"] . ":" . $config["port"], $config["username"], $config["password"]);

        if ($this->conn)
        {
            mysql_select_db($config["dbname"], $this->conn);
            $this->query("set names " . $config["charset"]);
        } else
        {
            echo $this->error();
        }
        
        $this->setConfig( $config );
    }

    public function call($sql)
    {
        $rows = array();
        $sqlArr = explode(";", $sql);
        for ($i = 0; $i < count($sqlArr); $i++)
        {
            if (strlen(trim($sqlArr[$i])) > 3)
            {
                $rows[] = $this->fetchAll($sqlArr[$i]);
            }
        }
        return $rows;
    }

    public function query($sql)
    {
    	$this->sql = $sql;
        $this->result = @mysql_query($sql, $this->conn);
        if (isset($GLOBALS["debug"]))
        {
            echo "<div>" . $sql  . "   --------";
            echo "\n<br />error:<span style=\"color:red\">" . mysql_error() . "</span>";
            echo "\n<br />insert id:<span style=\"color:green\">" . $this->insertId() . "</span>";
            echo "\n<br />affected rows:<span style=\"color:green\">" . $this->affectedRows() . "</span></div>";
        }
        return $this->result;
    }

    public function fetchAll($sql)
    {

        $this->result = $result = $this->query($sql);
        $rows = array();
        while ($row = @mysql_fetch_assoc($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    public function insertId()
    {
        return mysql_insert_id($this->conn);
    }

    public function affectedRows()
    {
        return mysql_affected_rows($this->conn);
    }

    public function error()
    {
        return mysql_error($this->conn);
    }

    public function escape($str)
    {
       // $str = $this->antiSqlInjection( $str );
        return mysql_real_escape_string($str);
    }

    public function numFields()
    {
        return mysql_num_fields($this->result);
    }

    public function numRows()
    {
        return mysql_num_rows($this->result);
    }

	public function getSql()
	{
		return $this->sql;
	}
	
}

?>
