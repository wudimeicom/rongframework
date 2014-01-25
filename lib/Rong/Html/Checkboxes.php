<?php

//pending...
require_once 'Rong/Html/Abstract.php';

class Rong_Html_Checkboxes extends Rong_Html_Abstract {

    public $options;
    public $checkedValues;
	public $separator="";
	
    public function __construct() {
        parent::__construct();
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function setCheckedValues($checkedValues) {
        $this->checkedValues = $checkedValues;
    }
	
	public function setSeparator($separator)
	{
		$this->separator = $separator;
	}

    public function toHtml() {
        $html = "";
        $checkedArray = array();
        if (is_string($this->checkedValues)) {
            $checkedArray = explode(",", $this->checkedValues);
        } else {
            $checkedArray = $this->checkedValues;
        }
        foreach ($this->options  as $value => $text) {
            $this->set("type","checkbox");
            $this->set("value" , $value );
            if(in_array( $value , $checkedArray ) == true )
            {
                $this->set("checked", "checked");
           }
           else{
               $this->remove("checked");
           }
            $html .= "<input ". $this->attributesToHtml() . " />"  . $text . "  " .$this->separator;
        }
        return $html;
    }

}
