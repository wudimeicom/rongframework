<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HighlightKeywords
 *
 * @author rong
 */
class Rong_Search_Analyzer_HighlightKeywords {
    //put your code here
    public function highlight( $text , $keywords, $color ='orange' )
    {
        if(! is_array(  $keywords ) )
        {
            $keywords = explode( " ", $keywords );
        }
        $uniqid = uniqid();
        $left_delimiter = "{" . $uniqid . "}";
        $right_delimiter = "{/" . $uniqid . "}";
        foreach ( $keywords as $k => $v )
        {
            $text = str_replace( $v , $left_delimiter. $v. $right_delimiter , $text );
        }
        $text = str_replace( $right_delimiter. $left_delimiter , "", $text );
        $text = str_replace($left_delimiter, '<span style="color:' . $color . ';font-weight:bold;">', $text );
        $text = str_replace( $right_delimiter, '</span>', $text );
        return $text;
    }

    public function highlightText( $text , $keywords, $color ='green' ,$resultTextMaxLength = 512 )
    {
        $text = strip_tags( $text );
        $textLen = strlen( $text );
        $sentenceArray = array();
        $sentenceNumber =0;
        $resultText = '';
        
        $delimiter = '，。！？——……,.!?';

        for( $i=0; $i< $textLen ; $i++ )
        {
            $ch = '';
            if( ord( $text[$i] )> 127 )
            {
                $ch = $text[$i] . $text[++$i] . $text[++$i];
            }
            else
            {
                $ch = $text[$i];
            }
            
            if( strpos( $delimiter, $ch) !== false )
            {
                @$sentenceArray[$sentenceNumber++] .= $ch;
            }
            else
            {
                 @$sentenceArray[$sentenceNumber] .= $ch;
            }  
        }
        $sentenceKeywordCountArr = array();

        
        for( $j=0; $j< count( $keywords) ; $j++ )
        {
            $kw = $keywords[$j];
            for( $k= 0; $k< count( $sentenceArray ); $k++ )
            {
                
                if( strpos( $sentenceArray[ $k] , $kw ) !== false )
                {
                    if( !isset ( $sentenceKeywordCountArr[$k] )) $sentenceKeywordCountArr[$k] =0;
                    $sentenceKeywordCountArr[$k]++;
                }
            }
        }
       // $sentenceKeywordCountArr[16]=8;
       arsort( $sentenceKeywordCountArr);
		$l =0;
        foreach( $sentenceKeywordCountArr as $l => $count )
        {
            $resultText .= $this->highlight( $sentenceArray[$l] , $keywords ) . "...";
            if( strlen( $resultText )> $resultTextMaxLength)break;
        }
        $times =0;$l2 = $l;
        while( strlen( $resultText )< $resultTextMaxLength)
        {
            $resultText.= @$sentenceArray[++$l2] ;
            if( $times>5)break;
            $times++;
        }
        $times =0;$l2 = $l;
        while( strlen( $resultText )< $resultTextMaxLength)
        {
            $resultText= @$sentenceArray[--$l2] . $resultText;
            if( $times>5)break;
            $times++;
        }
        return $resultText;
        
    }
}
?>
