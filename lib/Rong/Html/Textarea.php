<?php
require_once 'Rong/Html/Abstract.php';
class Rong_Html_Textarea extends Rong_Html_Abstract
{
     public $text = "";
     public function __construct( )
    {
            parent::__construct();
            $this->tagName = "textarea";
    }
    
    public function toHtml()
    {
        $html = "<" . $this->tagName .  " " . $this->attributesToHtml() ." >"  . $this->text . "</textarea>";
        return $html;
    }
}
?>
