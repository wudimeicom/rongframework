<?php 
require_once  "Rong/Controller.php";
require_once ROOT . "/application/models/TaskModel.php"; 
class TaskController  extends Rong_Controller 
{
    /**
    *@function : Display a interface for input
    */
    public function addAction()
    {
        $data = array();
        $this->view->display( "task/add.phtml" , $data );
    }


    
    /**
    *@function : save data to database what the user have added
    */
    public function saveAddAction()
    {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $db = load_database();
        $taskModel = new TaskModel();
        $lastId = $taskModel->insert( $id,$title,$content );
        $msg = "task was save successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />last insert id:" . $lastId . "<br />mysql error:" . $taskModel->db->error() );
        MessagePanel::show( $msg , url("/task/manage"), 5000 );
    }


    /**
    *@function : Display a interface for edit
    */
    public function editAction()
    {
        $data = array();
        $id = $_GET["id"];
        $db = load_database();
        $taskModel = new TaskModel();
        $data["row"] = $row = $taskModel->fetchRow( "id ='$id'" );
        $this->view->display( "task/edit.phtml" , $data );
    }


    /**
    *@function : save data to database what the user have edited
    */
    public function saveEditAction()
    {
        $db = load_database();
        $id = $_POST["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $taskModel = new TaskModel();
        $affectedRows = $taskModel->update( $id,$title,$content );
        $msg = "task was updated successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />affected rows:" . $affectedRows . "<br />mysql error:" . $taskModel->db->error() );
        MessagePanel::show( $msg , url("/task/manage"), 5000 );
    }


    public function manageAction()
    {
        require_once "Rong/Html/PageLink.php";
        $page = @$_GET["Page"];
        $pageSize = @$_GET["PageSize"] ;
        $id = $_GET["id"];
        $title = $_GET["title"];
        $content = $_GET["content"];
        $urlTemplate = config("url_prefix_of_controller") . "/Task/index?Page={Page}&PageSize={PageSize}&id=" . $_GET["id"] ."&title=" . $_GET["title"] ."&content=" . $_GET["content"] ."";
        $db = load_database();
        $taskModel = new TaskModel();
        $data = $result = $taskModel->manage( $id , $title , $content ,  $page , $pageSize ,$urlTemplate );
        $data["pagebar"] =$data["PaginatorHtml"];  
        $this->view->display( "task/manage.phtml" , $data );
    }


    public function indexAction()
    {
        require_once "Rong/Html/PageLink.php";
        $page = @$_GET["Page"];
        $pageSize = @$_GET["PageSize"] ;
        $id = $_GET["id"];
        $title = $_GET["title"];
        $content = $_GET["content"];
        $urlTemplate = config("url_prefix_of_controller") . "/Task/index?Page={Page}&PageSize={PageSize}&id=" . $_GET["id"] ."&title=" . $_GET["title"] ."&content=" . $_GET["content"] ."";
        $db = load_database();
        $taskModel = new TaskModel();
        $data = $result = $taskModel->index( $id , $title , $content , $page , $pageSize ,$urlTemplate );
        $data["pagebar"] = $data["PaginatorHtml"];
        $this->view->display( "task/index.phtml" , $data );
    }


    public function showAction()
    {
        $data = array();
        $id = $_GET["id"];
        $db = load_database();
        $taskModel = new TaskModel();
        $data["row"] = $row = $taskModel->fetchRow( "id ='$id'" );
        $this->view->display( "task/show.phtml" , $data );
    }


    public function deleteAction()
    {
        $id = $_GET["id"];
        $db = load_database();
        $taskModel = new TaskModel();
        $affectedRows = $taskModel->delete( "id ='$id'" );
        $msg = "task was deleted successfully!";
        $msg .= db_debug("<br /><b>sql debug</b><br />affected rows:" . $affectedRows . "<br />mysql error:" . $taskModel->db->error() );
        MessagePanel::show( $msg , url("/task/manage"), 5000 );
    }


}
?>
