<?php

class Rong_Validator_Length {

    public $subject;
    public $isValid = "NotSet";
    public $message = "";
    public $minLength = -1;
    public $maxLength = -1;

    public function __construct($subject = "") {
        $this->subject = $subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function isValid() {

        $length = strlen($this->subject);
        if ($this->minLength == -1 && $this->maxLength == -1) {
            return true;
        } elseif ($this->minLength == -1 && $this->maxLength > 0) {
            if ($length <= $this->maxLength) {
                return true;
            }
        } elseif ($this->minLength > 0 && $this->maxLength == -1) {
            if ($length >= $this->minLength) {
                return true;
            }
        } elseif ($this->minLength > -1 && $this->maxLength > -1) {

            if ($this->minLength <= $length && $length <= $this->maxLength) {
                return true;
            }
        }
        return false;
    }

}

?>
