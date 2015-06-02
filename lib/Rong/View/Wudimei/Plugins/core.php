<?php

function wudimei_isset( $var )
{
    if( isset( $var ))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function wudimei_toString( $var )
{
    if(is_array($var))
    {
       if( !empty( $var ) )
       {
           foreach( $var as $k=> $v )
           {
               return wudimei_toString( $var[$k] );
           }
       }
       else{
           return "";
       }
    }
    elseif(is_string($var))
    {
        return $var;
    }
    else{
        return strval($var);
    }
}
?>
