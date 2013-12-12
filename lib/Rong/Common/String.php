<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Common/Utf8String.php';
class Rong_Common_String {

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
    
    /**
     * Do not use this function again,please!user convertEncoding for instead
     * @param string $newCharset
     * @param string $fromCharset
     * @return type
     */
    public function convCharset( $newCharset ="UTF-8",   $fromCharset = "") {
        return $this->convertEncoding( $newCharset  , $fromCharset   );
    }

    public function formatName() {
        return preg_replace("/([^a-z0-9A-Z_])/", "", $this->string );
    }
    public function removeBlanks(){
        return preg_replace("/(\s+)/", " ", $this->string );
    }
    /**
     * do not use this function,use removeBlanks() for instead
     * @return type
     */
    public function removeMultiBlank( ) {
        return $this->removeBlanks();
    }

    /**
     * will be deleted
     * Enter description here ...
     * @param unknown_type $filename
     */
    public function getFileExt( ) {
        $arr = explode(".", $this->string );
        $ext = strtolower($arr[count($arr) - 1]);
        return $ext;
    }

    public function checkExt(  $allowExt) {
        $ext = $this->getFileExt( $this->string );
        return in_array($ext, $allowExt);
    }

    public function getImgs( ) {
        preg_match_all('/src=[\"|\']([^\"|\']+)[\"|\']/is',$this->string, $Match);
        $imgs = $Match[0];
        for ($i = 0; $i < count($imgs); $i++) {
            $imgs[$i] = preg_replace('/src=[\"|\']([^\"|\']+)[\"|\']/is', "\\1", $imgs[$i]);
        }
        return $imgs;
    }

    /**
     * 
     * @param type $string charset utf-8
     * @return type array
     */
    public function toCJKCharArray( ) {
        $str = new Rong_Common_Utf8String( $this->string );
        return $str->getCharArray(  );
    }

    public function CJKExplode( $glude,  $limit=0 )
    {
       $str = new Rong_Common_Utf8String( $this->string );
        return $str->explodeString( $glude,  $limit=0 );
    }
    
    
}

?>
