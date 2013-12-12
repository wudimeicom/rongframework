<?php
require_once 'Rong/Validator/Range.php';
class RangeController extends Rong_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //url: http://127.0.0.9/index.php/test/validator/Range/index
    public function indexAction()
    {
        $range = new Rong_Validator_Range("300");
        $range->minValue = 100;
        $range->maxValue = 500;
        if( $range->isValid() )
        {
            echo "valid number<br />";
        }
        
        $rangeDt = new Rong_Validator_Range("2012-12-18 12:00:23");
        $rangeDt->minValue = "2012-11-18";
        $rangeDt->maxValue = "2013-12-18";
        if( $rangeDt->isValid() )
        {
            echo "valid date time";
        }

    }
}
?>
