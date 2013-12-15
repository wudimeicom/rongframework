<?php
/**
 * 
 */
require_once 'Rong/Html/Abstract.php';
 
class Rong_Html_PageLink extends Rong_Html_Abstract implements Rong_Html_Interface
{
	public $PaginationData;
	public $config;
	public function __construct( $PaginationData , $config = NULL  )
	{
		if( $config != NULL )
		{
			$this->setConfig( $config );
			 
		}
		else 
		{
			$defaultConfig = array(
				"TextFirst" => "|&laquo;" ,  //&#187;&#171;  &laquo; &raquo;
				"TextPrev" =>  "&laquo;" ,
				"TextNext" =>  "&raquo;" ,
				"TextLast" => "&raquo;|" ,
				"LinkCount" => 10
			);
			$this->config = $defaultConfig;
		}
		parent::__construct();
		$this->PaginationData = $PaginationData;
	}
	public function setConfig( $config )
	{
		if( isset( $config ) )
		{
			foreach ( $config as $key => $value )
			{
				$this->config[$key] = $value  ;
			}
		}
	}
	public function getConfig( $config )
	{
		return $this->config ;
	}
	public function setPage( $page )
	{
		 $this->PaginationData["Page"] = $page ;
	}
	public function getPage( )
	{
		return  $this->PaginationData["Page"];
	}
	// HrefLeft HrefRight LinkCount=6 TextFirst="<<" TextPrev="<" TextNext TextLast 
	public function getLinks( $HrefLeft , $HrefRight )
	{
		$str = "";
		if( $this->PaginationData["PageCount"] >1 )
		{
			$str .= "<a href=\"" . $HrefLeft. "1" .$HrefRight."\">" .
			     $this->config["TextFirst"] . "</a>";
		}
		if( ( $this->PaginationData["Page"]-1 )>1 )
		{
			$str .= "<a href=\"" . $HrefLeft. ( $this->PaginationData["Page"] -1 ) .$HrefRight."\">" .
			     $this->config["TextPrev"] . "</a>";
		}
		
		$halfOfCount = ceil( $this->config["LinkCount"]/2 );
		for( $i= ( $this->PaginationData["Page"] - $halfOfCount ); $i<( $this->PaginationData["Page"] + $halfOfCount ) ;$i++ )
		{
			if( $i>0 && $i<= $this->PaginationData["PageCount"] )
			{
				if( $i== $this->PaginationData["Page"] ){ 
					
				    $str .= "<span>" . $i . "</span>"; 
				}
				else 
				{
					$str .= "<a href=\"" . $HrefLeft. $i .$HrefRight."\"";
					$str .= ">" . $i . "</a>";
				}
			}
		}
		if( ( $this->PaginationData["Page"]+ 1 )< $this->PaginationData["PageCount"] )
		{
			$str .= "<a href=\"" . $HrefLeft. ( $this->PaginationData["Page"] + 1 ) .$HrefRight."\">" .
			     $this->config["TextNext"] . "</a>";
		}
		
		if( ( $this->PaginationData["Page"] ) < $this->PaginationData["PageCount"] )
		{
			$str .= "<a href=\"" . $HrefLeft. ( $this->PaginationData["PageCount"] ) .$HrefRight."\">" .
			     $this->config["TextLast"] . "</a>";
		}
		return $str;
	}

    
     

    public function toHtml() {
        
    }

     

    
}
/*
	 *   [PaginationData] => Array
        (
            [Page] => 1
            [First] => 1
            [Last] => 1
            [Next] => 1
            [Prev] => 1
            [PageCount] => 1
            [PageSize] => 10
            [RecordCount] => 2
        )
	 */

?>