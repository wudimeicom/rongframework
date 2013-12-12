<?php

/**
 *      require_once 'Rong/Html/Radios.php';
        $radios = new Rong_Html_Radios( );
        $radios->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
        $radios->setSelectedValue( 2 );
        $radios->set("name", "friends" );
        echo $radios->toHtml();
 */
require_once 'Rong/Html/Abstract.php';

class Rong_Html_Radios extends Rong_Html_Abstract {

    
    public $options;
    public $checkedValue;
    

    public function __construct() {
        parent::__construct();
    }

    public function setOptions( $options )
    {
        $this->options = $options;
    }
    
    public function setCheckedValue( $checkedValue )
    {
        $this->checkedValue = $checkedValue;
    }
    

    public function toHtml() {
        $arr = array(1=>"yqr",2=>"lilei",3=> "hanmei");
         
        $html = "";
        foreach ( $this->options as $value => $text ) {
           $this->set("type", "radio");
           $this->set("value" , $value );
           if( $value == $this->checkedValue )
           {
               $this->set("checked", "checked");
           }
           else{
               $this->remove("checked");
           }
           $html .= "<input " . $this->attributesToHtml() . " />" . $text . "  " ;
        }
        return $html;
    }

}
