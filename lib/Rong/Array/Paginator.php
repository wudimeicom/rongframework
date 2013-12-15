<?php

class Rong_Array_Paginator{

    public function getPaginator( $rows  , $page , $pageSize , $urlTemplate , $paginatorSettings = array() )
	{
	        if( $page ==0 ) $page =1;
            $data = $this->limit(  $rows ,  $page , $pageSize );
			
            require_once 'Rong/Html/Paginator.php';
            $pagePaginator = new Rong_Html_Paginator( $data["PaginationData"] );
            $pagePaginator->setSettingsArray( $paginatorSettings );
            $data["PaginatorHtml"] = $pagePaginator->getPaginatorHtml( $urlTemplate );
            return $data;
    }
	
	public function limit( $rows ,  $page , $pageSize )
	{
	    $RecordCount = count( $rows );
		$PageCount = ceil( $RecordCount/ $pageSize );
		$Prev=1;
		$Next = $PageCount;
		$dt = array();
		if( $page - 1 >0 )
		{
		   $Prev = $page-1;
		}
		if( $page + 1<= $PageCount )
		{
		   $Next = $page + 1;
		}
		$start =( $page -1 ) * $pageSize;
		
	    for( $i=$start; $i < $start +$pageSize ; $i++ )
        {
			if( isset( $rows[$i] ) )
			{
			  $dt[] = $rows[$i];
			}
        }
	    $result = array( 
			"Data" => $dt,
			"PaginationData" => array(
				"Page"	=> $page ,
				"First" => 1,
				"Last"  => $PageCount ,
				"Next"	=> $Next ,
				"Prev"	=> $Prev ,
				"PageCount" => $PageCount ,
				"PageSize"  => $pageSize ,
				"RecordCount" => $RecordCount
			)
		);
		return $result;
	}

}