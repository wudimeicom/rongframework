<?php

/**
 * 
 * Enter description here ...
 * @author rong
 *
 */
class Rong_Array_Tree extends Rong_Object
{

    public $idKeyName; //auto increment id
    public $parentIdKeyName;
    public $rowset;
    //public $resultRowset;//getRowsetTree
    //public $childrenCount=0; //getRowsetTree
    //public $level=0;
    
    public function __construct($rowset, $idKeyName = "id", $parentIdKeyName = "parent_id")
    {
        $this->rowset = $rowset;
        $this->idKeyName = $idKeyName;
        $this->parentIdKeyName = $parentIdKeyName;
    }

    /**
     * 
     * display a tree with tree-depth  
     * @param int $parentId 
     */
    public function getRowsetTree($parentId )
    {
        return $this->_getRowsetTree($parentId);
        
    }
	
	public function _getRowsetTree($parentId,$level=0)
    {
    	$resultRowset = array();
        $level++;
        foreach( $this->rowset as $i => $item )
        {
            if ($item[$this->parentIdKeyName] == $parentId)
            {
                $item["__level"] = $level;
				$children = $this->_getRowsetTree($item[$this->idKeyName] , $level );
				if( count($children) == 0 )
				{
					$item["__is_leaf"] = true;
				}
				else{
					$item["__is_leaf"] = false;
				}
                $resultRowset[] = $item;
				 
				foreach( $children as $j => $child )
				{
					$resultRowset[] = $child;
				}
            }
        }
        $level--;
        return $resultRowset;
    }
    

    public function getRowById($id )
    {
        foreach( $this->rowset as $i => $item )
        {
             
            if ($item[$this->idKeyName ] == $id)
            {
                return $item;
            }
        }
        return null;
    }

    public function getChildren($parentId)
    {
        $resultRowset = array();
        foreach( $this->rowset as $i => $item )
        {
             
            if ($item[$this->parentIdKeyName] == $parentId)
            {

                $resultRowset[] = $item;
            }
        }
        return $resultRowset;
    }
    
    public function getPath( $id )
    {
         
        $result = array();
        $r = $this->getRowById($id);
      	if( empty( $r)) return array();
		
        $result[] = $r;
        while( $r[$this->parentIdKeyName]>0 )
        {
            $r = $this->getRowById( $r[$this->parentIdKeyName] );
            
            if( $r[$this->idKeyName] == $r[$this->parentIdKeyName])
            {
                break;
            }
            if( !isset($r[$this->idKeyName] ))
            {
                break;
            }
           
            $result[] = $r;
        }
        $result = array_reverse( $result );
        return $result;
    }

}