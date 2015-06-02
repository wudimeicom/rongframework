<?php
require_once 'Rong/View/Interface.php';
require_once 'Rong/View/Abstract.php';
require_once 'Rong/Cache.php';

class Rong_View_PHP extends Rong_View_Abstract implements Rong_View_Interface
{
	public function __construct( )
	{
		parent::__construct();
	}
	
	public function fetch( $Rong_View_File , $Rong_View_Data =array() )
	{
		$Rong_View_Content = "";
		
		if( is_array( $Rong_View_Data ) )
		{
			if( is_array( self::$varArray ) )
			{
				$Rong_View_Data = array_merge( $Rong_View_Data , self::$varArray );
			}
			//print_r( $Rong_View_Data );
			foreach ( $Rong_View_Data as $Rong_View_VarName => $Rong_View_VarValue )
			{
				$Rong_View_VarName = strval( $Rong_View_VarName );
				$$Rong_View_VarName = $Rong_View_VarValue ;
                                 
			}
			
		}
		
		 ob_start( );
		include(  $this->getViewsDirectory()  . "/" . $Rong_View_File );
               
		$Rong_View_Content = ob_get_contents();
	
		ob_end_clean();
                // echo $Rong_View_Content;
		return $Rong_View_Content;
	}
	
	public function display( $Rong_View_File , $Rong_View_Data = array() , $Rong_View_Return = false )
	{
            
                if (count(self::$varArray) > 0)
                {
                    foreach (self::$varArray as $saKey => $saValue)
                    {
                        $this->data[$saKey] = $saValue;
                    }
                }
		$Rong_View_Content = $this->fetch($Rong_View_File, $Rong_View_Data);
                
		if( $Rong_View_Return )
		{
			return $Rong_View_Content;
		}
		else 
		{
			if( $this->isCache )
			{
				$this->saveCache( $this->cacheFilename, $this->cacheTimeout , $Rong_View_Content );
			}
			echo $Rong_View_Content;
		}
		
	}
} 