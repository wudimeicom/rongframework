<?php

/**
 *      $select = new Rong_Html_Select();
        $select->set("name", "friends" );
        $select->set("id", "id_friends");
        $select->set("onchange","friends_onchange(this)");
        $select->setOptions( array( 1=> "Jim", 2=>"LiLei", 3=> "HanMeiMei"));
        $select->setSelectedValue( 2 );
        echo $select->toHtml();
 */
require_once 'Rong/Html/Abstract.php';

class Rong_Html_Select extends Rong_Html_Abstract {

    public $options;
    public $selectedValue;
    public function __construct() {
        parent::__construct();
        $this->tagName = "select";
        
    }
    
    public function setOptions( $options )
    {
        $this->options = $options;
    }
    
	public function addOption(  $value  , $text)
	{
		$this->options[ $value ] = $text;
	}
	
    public function setSelectedValue( $selectedValue )
    {
        $this->selectedValue = $selectedValue;
    }
    
    public function getOptions($row, $selectedValue) {
        $html = '';
        foreach ($row as $value => $text) {
            $html .= "<option value=\"{$value}\" ";
            if ($value == $selectedValue) {
                $html .= " selected=\"selected\" ";
            }
            $html .= ">" . $text . "</option>";
        }
        return $html;
    }

    public function toHtml() {
        $html = "<" . $this->tagName . " " . $this->attributesToHtml() . ">" .
        $this->getOptions( $this->options , $this->selectedValue) .
        "</select>";
        return $html;
    }

}