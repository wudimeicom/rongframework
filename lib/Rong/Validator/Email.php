<?php
 class Rong_Validator_Email {

    public $subject;
    public $isValid = "NotSet";
    public $errorMessage = "";
    
    public function __construct($subject = "") {
        $this->subject = $subject;
        
    }
    
    public function setSubject( $subject )
    {
        $this->subject = $subject;
    }
    
    public function isValid() {
        if(preg_match("/^([a-zA-Z0-9\.\-\_]+)@([a-zA-Z0-9\-]+)(\.([a-zA-Z]{2,3}))*$/i", $this->subject))
        {
            $this->isValid = true;
        }
        else
        {
            $this->isValid = FALSE;
        }
        return $this->isValid;
    }
 }
?>
