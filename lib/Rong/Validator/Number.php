<?php
class Rong_Validator_Number {

    public $subject;
    public $isValid = "NotSet";
    public $message = "";
    

    public function __construct($subject = "") {
        $this->subject = $subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function isValid() {
        if(preg_match("/^([0-9\.,]+)$/i", $this->subject))
        {
            return true;
        }
        else{
            return false;
        }
    }
}
?>
