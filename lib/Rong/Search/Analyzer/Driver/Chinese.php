<?php
/**
 * rong framework source code
 * 
 */
require_once 'Rong/Search/Analyzer/Interface.php';
class Rong_Search_Analyzer_Driver_Chinese implements Rong_Search_Analyzer_Interface
{
    public $dictionary_path;
    public $max_word_count = 409600;
    public $max_keyword_length=5;//cn
    public $max_en_length =12;
    public $keywords = array();
    public $processTime =0;
    public $loadingTime =0;

    public function __construct( $config )
    {
        $this->loadConfig($config);
        $this->loadDictionary();
    }

    private function loadConfig( $config )
    {
        foreach ( $config as $k => $v )
        {
            $this->$k = $v;
        }
    }

    private function loadDictionary()
    {
        $startTime = microtime(true );
        $arr  = file( $this->dictionary_path );
        foreach ( $arr as   $k => $v )
        {
            $v = trim( $v );
            $v = str_replace("\n", "", $v );
            $this->keywords[$v] =1;
        }
        $this->loadingTime = microtime( true ) - $startTime;
        unset( $arr );
    }

    /**
     *
     * @param string $text  the utf8 encoding
     * @return array $keywords
     */
    public function analyze( $text )
    {
        $timeStart = microtime(true );
       $sep =  ' 　，；。？、！……（）——+|￥%,.?!《》()' ;
       
        $charArray = array(array());
        $charArrayIndex =0;
        $len =strlen( $text );
        for( $i=0; $i < $len ; $i++ )
        {
            $ord = ord( $text[$i]);
            $ch = "";
            if( $ord > 127 )
            {
                $ch = $text[$i]. $text[++$i]. $text[++$i];
            }
            else
            {
                $ch = $text[$i];
            }
            if(strpos( $sep , $ch ) !== false )
            {
                $charArray[++$charArrayIndex] = array();
            }
             else {
                $charArray[$charArrayIndex][] = $ch;
            }
        }
        //filter
        for( $j=0; $j< count( $charArray ); $j++ )
        {
            for( $k=0; $k < count( $charArray[$j] ); $k++ )
            {
                if( trim( $charArray[$j][$k]) == "" )
                {
                    $charArray[$j][$k] =false;
                }
            }
            $charArray[$j] = array_filter( $charArray[$j] );
            $tmpArr = array();
            foreach ( $charArray[$j] as $item )
            {
                $tmpArr[] = $item;
            }
            $charArray[$j] = $tmpArr;
        }
        $charArray = array_filter( $charArray );
        
        $rsArray = array();
       
        foreach(   $charArray as $sentence )
        {
             
            $kwArr = $this->splitChinese( $sentence );
            $rsArray = array_merge( $rsArray, $kwArr );
        }
        $this->processTime = microtime(true ) - $timeStart;
        //echo "[" . $this->processTime . "]";
        
        return $rsArray;
    }

    public function getProcessTime()
    {
        return $this->processTime;
    }

    public function getLoadingTime()
    {
        return $this->loadingTime;
    }
    
    protected  function splitChinese( $charArray )
    {
        if( empty( $charArray ) ) return array();
        $keywordsArray = array();
        $end = count( $charArray) -1;
        $start = $end - $this->max_keyword_length;
        if( $start<0) $start=0;

        $cnt =0;
        while(  $end>=0 )
        {
            $word = $this->getString( $charArray, $start, $end );
            $isEnWord = $this->isEnWord($word );

             $preChar = $this->getString( $charArray, $start-1, $start-1 );
           // echo "[". $preChar. "]";
            $isPreCharEnword = $this->isEnWord( $preChar );
            while( $isEnWord == true && $isPreCharEnword == true )
            {
                $start --;
                //$start = $start - ( $this->max_en_length - $this->max_keyword_length );
                if( $start<0) $start=0;
                $word = $this->getString( $charArray, $start, $end );
                $isEnWord = $this->isEnWord($word );
                $preChar = $this->getString( $charArray, $start-1, $start-1 );
                 // echo "[". $preChar. "]";
                 $isPreCharEnword = $this->isEnWord( $preChar );
            }
            
            
            if( isset ( $this->keywords[ $word ] ) || ( strlen( $word ) == 3 && ord( $word[0]) >127)
                    || $isEnWord == true)
            {
		if( $isEnWord == true ) $word = strtolower( $word );
                $keywordsArray[] = $word;
                $end = $start -1;
                $start =  $end - $this->max_keyword_length;
                if( $start<0) $start=0;
            }
            elseif( $start == $end )
            {
                 $keywordsArray[] = $word;
                $end = $start -1;
                $start =  $end - $this->max_keyword_length;
                if( $start<0) $start=0;
            }
            else
            {
                $start++;
            }
            if( $cnt > $this->max_word_count ) break;
        }
        $keywordsArray = array_reverse( $keywordsArray );
        return $keywordsArray;
    }

    private function isEnWord( $str )
    {
        return preg_match("/^[a-zA-Z0-9\_]+$/i", $str );
    }

    private function getString( $charArray , $start, $end )
    {
        $str = "";
        for( $i=$start; $i<=$end; $i++ )
        {
            $str .= @$charArray[$i];
        }
        return $str;
    }

    public function setMaxWordCount( $newCount )
    {
        $this->max_word_count = $newCount;
    }
}
