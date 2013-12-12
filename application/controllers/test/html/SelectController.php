<?php
require_once 'Rong/Html/Select.php';
require_once 'Rong/Html/Radios.php';
require_once 'Rong/Html/Checkboxes.php';
class SelectController  extends Rong_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //url: http://127.0.0.9/index.php/test/html/Select/index
    public function indexAction()
    {
        
        $select = new Rong_Html_Select();
        $select->set("name", "friends" );
        $select->set("id", "id_friends");
        $select->set("onchange","friends_onchange(this)");
        $select->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
        $select->setSelectedValue( 2 );
        echo $select->toHtml();
        
    }
    
    //url: http://127.0.0.9/index.php/test/html/Select/radios
    public function radiosAction()
    {
        
        $radios = new Rong_Html_Radios( );
        $radios->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
        $radios->setCheckedValue( 3 );
        $radios->set("name", "friends" );
        echo $radios->toHtml();
    }
    
     //url: http://127.0.0.9/index.php/test/html/Select/checkboxes
    public function checkboxesAction()
    {
        
        $checkboxes = new Rong_Html_Checkboxes( );
        $checkboxes->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
        $checkboxes->setCheckedValues( "3,1" );
        $checkboxes->setCheckedValues( array(1,2) );
        $checkboxes->set("name", "friends[]" )->set("class","class1");
        echo $checkboxes->toHtml();
    }
}
?>
