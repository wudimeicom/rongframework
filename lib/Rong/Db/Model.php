<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2010 Yang Qing-rong
 * This is a free software.
 */

class Rong_Db_Model extends Rong_Object {

    /**
     * Enter description here...
     *
     * @var Rong_Db_Driver_Mysql
     */
    public static $defaultDb;

    /**
     * Enter description here...
     *
     * @var Rong_Db_Driver_Mysql
     */
    public $db = null;
    protected $_name = "";

    public function __construct($db = null) {
        parent::__construct();
        if (isset($db)) {
            $this->db = $db;
        } else {
            $this->db = $this->getDb(); //get default db
        }
    }

    public static function setDefaultDb($defaultDb) {
        self::$defaultDb = $defaultDb;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    /**
     * Enter description here...
     *
     * @return Rong_Db_Driver_Mysql
     */
    public function getDb() {
        if (!isset($this->db)) {
            $this->db = self::$defaultDb;
        }
        return $this->db;
    }

    public function setName($newName) {
        $this->_name = $newName;
    }

    public function setNameWithDefaultTablePrefix($NameWithoutTablePrefix) {
        $config = $this->getDb()->getConfig();
        
        $this->_name = $config["table_prefix"] . $NameWithoutTablePrefix;
    }

    public function getName() {
        return $this->_name;
    }

    /*
     * @param array $data
     * @return int lastInsertId
     */

    public function insert($data) {
        return $this->db->insert($this->_name, $data);
    }

    public function update($data, $where) {
        return $this->db->update($this->_name, $data, $where);
    }

    public function delete($where) {
        return $this->db->delete($this->_name, $where);
    }

    public function fetchRow($where, $fields = "*") {
        $sql = "select " . $fields . " from " . $this->_name . " where " . $where;
        $rows = $this->db->fetchAll($sql);
        return @$rows[0];
    }

    public function fetchAll($where = "", $fields = "*") {
        if (trim($where == "")) {
            $where = " 1=1 ";
        }
        $sql = "select " . $fields . " from " . $this->_name . " where " . $where;
        $rows = $this->db->fetchAll($sql);
        return @$rows;
    }

    public function fetchCount($where = 1) {
        $sql = "select count(*) count from " . $this->_name . " where " . $where;
        $r = $this->db->fetchRow($sql);
        return @$r["count"];
    }

    public function escape($str) {

        return $this->db->escape($str);
    }

    public static function getDefaultDb() {
        return self::$defaultDb;
    }

    public function getConfig() {
        return $this->getDb()->getConfig();
    }

     

}

?>