<?php
class Rong_Array_TwoDimensionalArray extends Rong_Object{
	
	private $array;//2 dimensional array
	
	public function __construct( $arr )
	{
		$this->array = $arr;
	}
	
	public function setArray( $arr )
	{
		$this->array = $arr;
	}
	
	public function getArray( )
	{
		return $this->array ;
	}
	
	public function toKeyValuePairsArray( $keyName, $valueName )
	{
		$rows = array();
		if( !empty( $this->array ) )
		{
			foreach ($this->array as $i => $row ) {
				$rows[ $row[ $keyName] ] = $row[ $valueName ];
			}
			return $rows;
		}
		else{
			return false;
		}
	}
	
	public function groupBy( $keyName )
	{
		$rows = array();
		if( !empty( $this->array ) )
		{
			foreach ($this->array as $i => $row ) {
				if( !isset( $rows[ $row[ $keyName] ] ) )
				{
					$rows[ $row[ $keyName] ] = array();
				}
				$rows[ $row[ $keyName] ][] = $row;
			}
			return $rows;
		}
		else{
			return false;
		}
	}
}
