<?php
class Rong_Validator_Range{
    public $subject;
    public $isValid = "NotSet";
    public $message = "";
    
    public $minValue;
    public $maxValue;
    
    public function __construct($subject = "") {
        $this->subject = $subject;
    }

    public function setSubject( $subject )
    {
        $this->subject = $subject;
    }
    
    public function isValid() {
        if( preg_match("/^([0-9]{2,4})\-([0-9]{1,2})\-([0-9]{1,2})(\s+([0-9]{2})\:([0-9]{2})\:([0-9]{2}))*$/i", $this->subject) ){
            $time = strtotime( $this->subject );
            $startTime = strtotime( $this->minValue );
            $endTime = strtotime( $this->maxValue );
            if( $startTime <= $time && $time <= $endTime )
            {
                return true;
            }
            return false;
        }
        elseif(preg_match("/^([0-9]+)$/i", $this->subject))
        {
            $num = intval( $this->subject );
            if( $this->minValue <= $num && $num <= $this->maxValue )
            {
                return true;
            }
        }
        return false;
    }
}
?>
