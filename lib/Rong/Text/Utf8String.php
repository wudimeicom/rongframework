<?php


require_once 'Rong/Text/String.php';

class Rong_Text_Utf8String extends Rong_Text_String
{

    /**
     * 
     * @param type $string charset utf-8
     * @return type array
     */
    public $utf8CharArray;
    /**
     *
     * @var int
     */
    public $length;
    /**
     * 
     * @param string $utf8String  charset:utf-8
     */
    public function __construct($utf8String)
    {
        parent::__construct($utf8String);
        $this->toCharArray($utf8String);
    }
    /**
     * 
     * @param string $utf8Char anscii char or utf8 char(2-4bytes)
     * @return \Rong_Text_Utf8String
     */
    public function appendChar( $utf8Char )
    {
       
        $this->utf8CharArray[] = $utf8Char;
        $this->length = count($this->utf8CharArray );
        return $this;
    }
    
    /**
     * append string to tail of this string
     * @param string|Rong_Text_Utf8String|\Rong_Text_String $utf8String
     * @return \Rong_Text_Utf8String $this
     */
    public function append( $utf8String )
    {
        if( $utf8String instanceof Rong_Text_Utf8String )
        {
            
        }
        elseif( $utf8String instanceof Rong_Text_String )
        {
            $utf8String = new Rong_Text_Utf8String( $utf8String->string );
        }
        else{
            $utf8String = new Rong_Text_Utf8String( $utf8String );
        }
        for( $i=0; $i< $utf8String->length; $i++ )
        {
            $this->appendChar( $utf8String->utf8CharArray[$i] );
        }
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function getCharArray()
    {
        return $this->utf8CharArray;
    }
    
    /**
     * 
     * @return int
     */
    public function length()
    {
        return $this->length;
    }

    /*
     *     U-00000000 - U-0000007F: 0xxxxxxx
           U-00000080 - U-000007FF: 110xxxxx 10xxxxxx
           U-00000800 - U-0000FFFF: 1110xxxx 10xxxxxx 10xxxxxx
           U-00010000 - U-001FFFFF: 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
           U-00200000 - U-03FFFFFF: 111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx
           U-04000000 - U-7FFFFFFF: 1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 
    */
    /**
     * 
     * @param string $string 
     * @return array() $charArray utf8char array
     */
    public function toCharArray($string)
    {
        $strLen = strlen($string);
        $strArray = array();
        for ($i = 0; $i < $strLen; $i++)
        {
            $ch = '';
            if (ord($string[$i]) > 127)
            {
                $binStr = decbin(ord($string[$i]));
                //echo $binStr . " \n";
                $prefixOneCount = 0;
                for( $j=0;$j<strlen( $binStr ); $j++ )
                {
                    if( $binStr[$j] == "0")
                    {
                        break;
                    }
                    else{
                        $prefixOneCount++;
                    }
                }
                $ch = "";
               
                for( $k=0; $k< $prefixOneCount; $k++ )
                {
                    $ch .= $string[$i+$k];
                }
                $i+= $prefixOneCount-1;
                //echo $ch;
            } else
            {
                $ch = $string[$i];
            }
            $strArray[] = $ch;
        }
        $this->length = count( $strArray );
        $this->utf8CharArray = $strArray;
        return $strArray;
    }

    /**
     * 
     * @param Rong_Text_Utf8String|string $glude
     * @param int $limit
     * @return array( 0=>Rong_Text_Utf8String )
     */
    public function explodeString($glude, $limit = 0)
    {
         
        $gludeArr = array();
        if (is_string($glude))
        {  
            $gludeUtf8Str = new Rong_Text_Utf8String( $glude );
            $gludeArr = $gludeUtf8Str->toCharArray($glude);
        } elseif ($glude instanceof Rong_Text_Utf8String)
        {
            $gludeArr = $glude->getCharArray();
        }
        $rsArr = array();
        $rsIndex = 0;
        
       
        
        for ($i = 0; $i < count($this->utf8CharArray); $i++)
        {
            $found = true;
            for ($j = 0; $j < count($gludeArr); $j++)
            {
                if ($this->utf8CharArray[$i + $j] != $gludeArr[$j])
                {
                    $found = false;
                }
            }
            if ($found)
            {
               
                $rsIndex++;
                $i+=$j - 1;
                if ($limit > 0 && $rsIndex >= $limit)
                    break;
            }
            else
            {
                if (!isset($rsArr[$rsIndex]))
                {
                    $rsArr[$rsIndex] =   new Rong_Text_Utf8String("");
                }
                //echo $this->utf8CharArray[$i];
                //$rsArr[$rsIndex] .= $this->utf8CharArray[$i];//  
                $rsArr[$rsIndex]->appendChar( $this->utf8CharArray[$i] );
            }
        }
        return $rsArr;
    }
    /**
     * 
     * @param type $start
     * @param type $length
     * @return \Rong_Text_Utf8String
     */
    public function subString($start, $length = 4096)
    {
        $str = "";
        $end = $start + $length;
        if( $end > $this->length )
        {
            $end = $this->length;
        }
        for ($i = $start; $i <$end ; $i++)
        {
            
            $str .= $this->utf8CharArray[$i];
        }
        return new Rong_Text_Utf8String( $str );
    }
    
    /**
     * 
     * @return string
     */
    public function toString()
    {
        $str = "";
        for( $i=0; $i < $this->length(); $i++ )
        {
            $str .= $this->utf8CharArray[$i];
        }
        return $str;
    }

    public function __toString() {
        return $this->toString();
    }
}

class RUtf8String extends Rong_Text_Utf8String
{
    public function __construct( $utf8String ){
        parent::__construct($utf8String);
    }
}
?>
