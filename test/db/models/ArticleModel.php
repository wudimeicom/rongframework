<?php
/**
* file name: /test/models/ArticleModel.php
*/
require_once 'Rong/Db/Model.php';
class ArticleModel extends Rong_Db_Model 
{
    public $_name = "";
    public function __construct( )
    {
    	
        parent::__construct();
		$this->setNameWithDefaultTablePrefix("article"); //assign "w_article"  to $_name (table name)
    }
	
    public function m_insert( $title, $content )
    {
        $data = array(
            "title" => $title ,
            "content"    => $content 
        );
        return parent::insert( $data ); // insert()return last_insert_id, or -1
    }
}
?>

