<?php 
require_once  "Rong/Controller.php";
require_once ROOT . "/application/models/RentModel.php"; 
class RentController  extends Rong_Controller 
{
    /**
    *@function : Display a interface for input
    */
    public function addAction()
    {
        $data = array();
        $this->view->display( "rent/add.phtml" , $data );
    }


    
    /**
    *@function : save data to database what the user have added
    */
    public function saveAddAction()
    {
        $stu_id = $_POST["stu_id"];
        $book_id = $_POST["book_id"];
        $date = $_POST["date"];
        $db = load_database();
        $rentModel = new RentModel();
        $lastId = $rentModel->insert( $stu_id,$book_id,$date );
        $msg = "rent was save successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />last insert id:" . $lastId . "<br />mysql error:" . $rentModel->db->error() );
        MessagePanel::show( $msg , url("/rent/manage"), 5000 );
    }


    /**
    *@function : Display a interface for edit
    */
    public function editAction()
    {
        $data = array();
        $stu_id = $_GET["stu_id"];
        $book_id = $_GET["book_id"];
        $db = load_database();
        $rentModel = new RentModel();
        $data["row"] = $row = $rentModel->fetchRow( "stu_id ='$stu_id' and book_id ='$book_id'" );
        $this->view->display( "rent/edit.phtml" , $data );
    }


    /**
    *@function : save data to database what the user have edited
    */
    public function saveEditAction()
    {
        $db = load_database();
        $stu_id = $_POST["stu_id"];
        $book_id = $_POST["book_id"];
        $date = $_POST["date"];
        $rentModel = new RentModel();
        $affectedRows = $rentModel->update( $stu_id,$book_id,$date );
        $msg = "rent was updated successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />affected rows:" . $affectedRows . "<br />mysql error:" . $rentModel->db->error() );
        MessagePanel::show( $msg , url("/rent/manage"), 5000 );
    }


    public function manageAction()
    {
        require_once "Rong/Html/PageLink.php";
        $page = @$_GET["page"];
        $pageSize = @$_GET["size"] ;
        $db = load_database();
        $rentModel = new RentModel();
        $data = $result = $rentModel->manage( $page , $pageSize );
        $pageLinkObj = new Rong_Html_PageLink( $result["PageLink"] , null );
        $data["pagebar"] = $pageLinkObj->getLinks( "/index.php/Rent/manage?page=", "&size=" . $pageSize );
        $this->view->display( "rent/manage.phtml" , $data );
    }


    public function indexAction()
    {
        require_once "Rong/Html/PageLink.php";
        $page = @$_GET["page"];
        $pageSize = @$_GET["size"] ;
        $db = load_database();
        $rentModel = new RentModel();
        $data = $result = $rentModel->index( $page , $pageSize );
        $pageLinkObj = new Rong_Html_PageLink( $result["PageLink"] , null );
        $data["pagebar"] = $pageLinkObj->getLinks( "/index.php/Rent/index?page=", "&size=" . $pageSize );
        $this->view->display( "rent/index.phtml" , $data );
    }


    public function showAction()
    {
        $data = array();
        $stu_id = $_GET["stu_id"];
        $book_id = $_GET["book_id"];
        $db = load_database();
        $rentModel = new RentModel();
        $data["row"] = $row = $rentModel->fetchRow( "stu_id ='$stu_id' and book_id ='$book_id'" );
        $this->view->display( "rent/show.phtml" , $data );
    }


    public function deleteAction()
    {
        $stu_id = $_GET["stu_id"];
        $book_id = $_GET["book_id"];
        $db = load_database();
        $rentModel = new RentModel();
        $affectedRows = $rentModel->delete( "stu_id ='$stu_id' and book_id ='$book_id'" );
        $msg = "rent was deleted successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />affected rows:" . $affectedRows . "<br />mysql error:" . $rentModel->db->error() );
        MessagePanel::show( $msg , url("/rent/manage"), 5000 );
    }


}
?>
