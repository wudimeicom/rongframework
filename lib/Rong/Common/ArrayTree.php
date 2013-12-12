<?php

/**
 * 
 * Enter description here ...
 * @author rong
 *
 */
class Rong_Common_ArrayTree extends Rong_Object
{

    public $idKeyName; //auto increment id
    public $parentIdKeyName;
    public $rowset;
    public $resultRowset;
    public $level=0;
    
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
    public function getRowsetTree($parentId)
    {
        
        $this->level++;
        for ($i = 0; $i < count($this->rowset); $i++)
        {
            $item = $this->rowset[$i];
            if ($item[$this->parentIdKeyName] == $parentId)
            {
                $item["level"] = $this->level;
                $this->resultRowset[] = $item;
                $this->getRowsetTree($item[$this->idKeyName]);
            }
        }
        $this->level--;
        return $this->resultRowset;
    }

    public function getRowById($id )
    {
        for ($i = 0; $i < count($this->rowset); $i++)
        {
            $item = $this->rowset[$i];
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
        for ($i = 0; $i < count($this->rowset); $i++)
        {
            $item = $this->rowset[$i];
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