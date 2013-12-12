<?php
require_once 'Rong/Html/Abstract.php';
class Rong_Html_TextField extends Rong_Html_Abstract {
    
    
    public function __construct( )
    {
            parent::__construct();
            $this->tagName = "input";
            $this->set("type","text");
            
    }
    
    public function toHtml()
    {
        $html = "<" . $this->tagName .  " " . $this->attributesToHtml() ." />";
        return $html;
    }
}
?>
