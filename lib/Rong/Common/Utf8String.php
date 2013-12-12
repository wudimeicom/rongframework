<?php


require_once 'Rong/Common/String.php';

class Rong_Common_Utf8String extends Rong_Common_String
{

    /**
     * 
     * @param type $string charset utf-8
     * @return type array
     */
    public $utf8CharArray;
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

    public function getCharArray()
    {
        return $this->utf8CharArray;
    }
    
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
     * @param Rong_Common_Utf8String|string $glude
     * @param int $limit
     * @return type
     */
    public function explodeString($glude, $limit = 0)
    {
        $gludeArr = array();
        if (is_string($glude))
        {
            $gludeArr = $this->toCharArray($glude);
        } elseif ($glude instanceof Rong_Common_Utf8String)
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
                    $rsArr[$rsIndex] = "";
                }
                $rsArr[$rsIndex] .= $this->utf8CharArray[$i];
            }
        }
        return $rsArr;
    }

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
        return $str;
    }
    
    public function toString()
    {
        return $this->subString(0);
    }

}

class RUtf8String extends Rong_Common_Utf8String
{
    public function __construct( $utf8String ){
        parent::__construct($utf8String);
    }
}
?>
