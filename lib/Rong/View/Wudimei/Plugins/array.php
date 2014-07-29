<?php
function wudimei_count( $array )
{
	return count( $array );
}

function wudimei_empty( $array )
{
    return empty( $array );
}

function wudimei_search( $array, $needle )
{
    return array_search($needle, $array );
}

function wudimei_is_array( $array ){
	
	return is_array( $array );
}
