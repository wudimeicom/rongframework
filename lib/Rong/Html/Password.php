<?php

require_once 'Rong/Html/Abstract.php';
class Rong_Html_Password extends Rong_Html_Abstract {
    
    
    public function __construct( )
    {
            parent::__construct();
            $this->tagName = "input";
            $this->set("type","password");
            
    }
    
    public function toHtml()
    {
        $html = "<" . $this->tagName .  " " . $this->attributesToHtml() ." />";
        return $html;
    }
}
?>
