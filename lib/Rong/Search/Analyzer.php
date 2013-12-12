<?php
require_once 'Rong/Object.php';

class Rong_Search_Analyzer extends Rong_Object
{
    public static function factory( $adapter, $config )
    {
        require_once 'Rong/Search/Analyzer/Driver/' . ucfirst( $adapter  ) . '.php';
		$className = 'Rong_Search_Analyzer_Driver_' . ucfirst( $adapter );
		$obj = new $className( $config );
		return $obj;
    }
}