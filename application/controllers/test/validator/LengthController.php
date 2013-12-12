<?php
require_once 'Rong/Validator/Length.php';
class LengthController  extends Rong_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //url: http://127.0.0.9/index.php/test/validator/Length/index
    public function indexAction()
    {
        $lenObj = new Rong_Validator_Length("abcde");
        $lenObj->maxLength = 5;
        if( $lenObj->isValid() )
        {
            echo "valid string length<br />";
        }
        
        $lenObj = new Rong_Validator_Length("abcdef");
        $lenObj->minLength = 5;
        if( $lenObj->isValid() )
        {
            echo "valid string length<br />";
        }
        
        $lenObj = new Rong_Validator_Length("ab");
        $lenObj->minLength = 2;
        $lenObj->maxLength = 5;
        if( $lenObj->isValid() )
        {
            echo "valid string length<br />";
        }
    }
}
?>
