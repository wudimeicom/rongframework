<?php
class Rong_Number extends Rong_Object 
{
	public function decimal( $number , $decimal )
	{
		$string = number_format( $number , $decimal , "." , "" );
		return $string;
	}
}
?>