<?php
require_once 'Rong/Db/Model.php';
class ArticleModel extends Rong_Db_Model{
    public function __construct($db = null) {
        parent::__construct($db);
        $this->setName("article");
    }
    
    public function pg($page, $pageSize, $urlTemplate)
    {
        $sql = "select * from " . $this->getName() . " order by id desc";
        $pg = $this->db->getPaginator($sql, $page, $pageSize, $urlTemplate);
        return $pg;
    }
}
?>
