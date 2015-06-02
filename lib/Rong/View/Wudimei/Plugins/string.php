<?php
require_once 'Rong/Text/Utf8String.php';
/**
 * 
 * trim blanks from a string
 * usage: <!--{$name|trim}-->
 * @param string $string
 * @return string
 */
function wudimei_trim( $string )
{
	return trim( $string );
}

/**
 * 
 * sub string
 * usage: <!--{$name|substr:0:5}-->
 * @param int $srart
 * @param int $length
 * @return string
 */
function wudimei_substr( $string ,  $start , $length  )
{
	return substr($string, $start , $length );
}

/**
 * 
 * sub string
 * usage: <!--{$name|strlen}-->
 * @return int
 */
function wudimei_strlen( $string )
{
	return strlen($string);
}

function wudimei_replace( $string , $search, $replace )
{
	return str_replace($search, $replace, $string );
}


function wudimei_repeat( $string , $multiplier )
{
    return str_repeat( $string, $multiplier);
}

function wudimei_concat( $string, $string2 )
{
    return $string. $string2;
}

function wudimei_append( $string, $string2 )
{
    return $string. $string2;
}

function wudimei_cat( $string, $string2 )
{
    return $string. $string2;
}

function wudimei_nl2br( $string )
{
    return nl2br($string);
}

function wudimei_urlencode( $string )
{
    return urlencode( $string );
}

function wudimei_urldecode( $string )
{
    return urldecode( $string );
}

function wudimei_base64_encode( $string )
{
    return base64_encode( $string );
}

function wudimei_base64_decode( $string )
{
    return base64_decode( $string );
}

function wudimei_strpos( $string, $needle, $offset = null )
{
    return strpos( $string , $needle, $offset);
}

function wudimei_strip_tags($str, $allowable_tags="")
{
   return strip_tags($str, $allowable_tags);
}

function wudimei_utf8SubString( $str , $start , $length = 4096 )
{
    $uStr = new RUtf8String( $str );
    return $uStr->subString($start, $length);
    
}

function wudimei_utf8Length( $str   )
{
    $uStr = new RUtf8String( $str );
    return $uStr->length();
    
}

function wudimei_highlight( $string , $keyword  , $color = "#DD4B39" )
{
      
    $string = str_replace( $keyword , "<{" . $keyword . "}>" , $string );
    $string = str_replace("<{", "<span style=\"color:".$color."\">", $string );
    $string = str_replace("}>", "</span>", $string );

    return $string;
}