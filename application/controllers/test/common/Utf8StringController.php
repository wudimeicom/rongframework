<?php
require_once   'Rong/Common/Utf8String.php';
class Utf8StringController extends Rong_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function indexAction()
    {
        //http://127.0.0.9/index.php/test/common/Utf8String
        
        $utf8 = new Rong_Text_Utf8String("rong framework是一款框架_分隔_这是rong utf8 string_分隔_子串");
        echo "字符串的值是：" . $utf8 . "<br />";
        echo "子串：" . $utf8->subString(0, 2 )  . "<br />";
        
        $arr = $utf8->explodeString( "_分隔_");
        echo "arr的值是：<br />" ;
        for( $i=0; $i <count( $arr ); $i++ )
        {
            echo $arr[$i]  . "<br />";
        }
        echo "添加abc: " . $utf8->append("abc") . "<br />";
        $cmdStr = new Rong_Common_String("abc老杨");
        echo "添加Rong_Common_String:" . $utf8->append( $cmdStr ) . "<br />";
        $cmdUtf8String = new Rong_Text_Utf8String("张三四") . "<br />";
        echo "添加Rong_Text_Utf8String: " . $utf8->append( $cmdUtf8String ) . "<br />";
        
    }
}
?>
