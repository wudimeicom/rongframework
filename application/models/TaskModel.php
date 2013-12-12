<?php
require_once "Rong/Db/Model.php";
class TaskModel extends Rong_Db_Model 
{
    public $_name = ""; 
    public function __construct( )
    {       
        $this->setNameWithDefaultTablePrefix("task"); //init table name
        parent::__construct();
    }


   /**
    @return int last insert id
   */
    public function insert( $id,$title,$content)
    {
        $data = array(
            "id" => $id ,
            "title" => $title ,
            "content" => $content ,
        );
        return parent::insert( $data );
    }


   /**
    @return int affected rows
   */
    public function update( $id,$title,$content )
    {
        $data = array(
        "title" => $title ,
        "content" => $content ,
        );
        return parent::update( $data , "id ='$id'");
    }


   /**
    @return array $rs = array("Data"=>array(...),"PageLink"=> "string" )
   */
    public function index( $id , $title , $content , $page , $pageSize , $urlTemplate)
    {
        $sql = "select id,title,content from " . $this->_name . " where 1 ";
        if( isset($id) || trim($id) != ""){ $sql .=" and id like '%" . $this->escape( $id ) . "%'";}
        if( isset($title) || trim($title) != ""){ $sql .=" and title like '%" . $this->escape( $title ) . "%'";}
        if( isset($content) || trim($content) != ""){ $sql .=" and content like '%" . $this->escape( $content ) . "%'";}
        return $this->db->getPaginator($sql, $page, $pageSize, $urlTemplate); 
    }


   /**
    @return array $rs = array("Data"=>array(...),"PageLink"=> "string" )
   */
    public function manage( $id , $title , $content ,   $page , $pageSize , $urlTemplate)
    {
        $sql = "select id,title,content from " . $this->_name . " where 1 ";
        if( isset($id) || trim($id) != ""){ $sql .=" and id like '%" . $this->escape( $id ) . "%'";}
        if( isset($title) || trim($title) != ""){ $sql .=" and title like '%" . $this->escape( $title ) . "%'";}
        if( isset($content) || trim($content) != ""){ $sql .=" and content like '%" . $this->escape( $content ) . "%'";}
        return $this->db->getPaginator($sql, $page, $pageSize, $urlTemplate);
    }


}
?>