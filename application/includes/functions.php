<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function config( $key )
{
    global $config;
    $kArr = explode(".", $key );
    $dt = $config;
    for( $i=0; $i< count( $kArr); $i++ )
    {
      $dt = $dt[ $kArr[$i]] ; 
    }
    return $dt;
}

function db_debug( $str )
{
    if( config("enable_sql_debug") == true )
    {
        return $str;
    }
    return "";
}

function url( $url ){
    $abs_url = config("url_prefix_of_controller") . $url;
    return $abs_url;
}
?>
