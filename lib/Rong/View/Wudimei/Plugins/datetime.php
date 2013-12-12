<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function wudimei_date( $datetimeString , $format )
{
    if(preg_match("/^([0-9]+)$/", $datetimeString ) )
    {
        return date( $format ,   $datetimeString  );
    }
    else{
        return date( $format , strtotime( $datetimeString ));
    }
}
?>
