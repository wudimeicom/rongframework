<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Text/Utf8String.php';
class Rong_Text_String {

    public $string = "";
    public function __construct( $str )
    {
        $this->string = $str;
    }
    
    public function subString( $start, $length = null )
    {
        return substr( $this->string , $start, $length);
    }
    
    public function replace( $search, $replace )
    {
        return str_replace($search, $replace, $this->string );
    }
    
    public function convertEncoding( $newCharset ="UTF-8" , $fromCharset = "" ) {
        if( $fromCharset == "" )
        {
            $fromCharset =  mb_detect_encoding($this->string);
        }
        return mb_convert_encoding( $this->string, $newCharset,$fromCharset);
    }
    
   
    public function __toString() {
        return $this->string;
    }
    
}

?>
