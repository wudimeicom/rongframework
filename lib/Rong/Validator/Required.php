<?php

class Rong_Validator_Required {

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
        if (is_array($this->subject) && !empty($this->subject) && count($this->subject) > 0) {
            $this->isValid = true;
        } elseif (isset($this->subject) && trim($this->subject) != "") {
            $this->isValid = true;
        } else {
            $this->isValid = FALSE;
        }
        return $this->isValid;
    }

}

?>
