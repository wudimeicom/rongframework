<?php
require_once "Rong/Db/Model.php";
class RentModel extends Rong_Db_Model 
{
    public $_name = ""; 
    public function __construct( )
    {       
        $this->setNameWithDefaultTablePrefix("rent"); //init table name
        parent::__construct();
    }


   /**
    @return int last insert id
   */
    public function insert( $stu_id,$book_id,$date)
    {
        $data = array(
            "stu_id" => $stu_id ,
            "book_id" => $book_id ,
            "date" => $date ,
        );
        return parent::insert( $data );
    }


   /**
    @return int affected rows
   */
    public function update( $stu_id,$book_id,$date )
    {
        $data = array(
        "date" => $date ,
        );
        return parent::update( $data , "stu_id ='$stu_id' and book_id ='$book_id'");
    }


   /**
    @return array $rs = array("Data"=>array(...),"PageLink"=> "string" )
   */
    public function index( $page , $pageSize )
    {
        $sql = "select stu_id,book_id,date from " . $this->_name;
        return $this->db->limit( $sql , $page , $pageSize );
    }


   /**
    @return array $rs = array("Data"=>array(...),"PageLink"=> "string" )
   */
    public function manage(  $page , $pageSize )
    {
        $sql = "select stu_id,book_id,date from " . $this->_name;
        return $this->db->limit( $sql , $page , $pageSize );
    }


}
?>