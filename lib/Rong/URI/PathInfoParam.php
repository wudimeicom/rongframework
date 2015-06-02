<?php

class Rong_URI_PathInfoParam
{

    public $path_info;
    public $path_items;
    public $params;

    public function __construct()
    {
        //REDIRECT_PATH_INFO,REDIRECT_URL
        if( isset( $_SERVER["PATH_INFO"] ) )
        {
            $this->path_info = $_SERVER["PATH_INFO"];
        }
        elseif(isset ( $_SERVER["ORIG_PATH_INFO"]))
        {
            $this->path_info = $_SERVER["ORIG_PATH_INFO"];
        }
         elseif(isset ( $_SERVER["REDIRECT_PATH_INFO"]))
        {
            $this->path_info = $_SERVER["REDIRECT_PATH_INFO"];
        }
        /*
         elseif(isset ( $_SERVER["REDIRECT_URL"]))
        {
            $this->path_info = $_SERVER["REDIRECT_URL"];
        }*/
        else
        {
            $this->path_info = "";
        }
        $this->path_items = explode("/", $this->path_info);
    }

    public function item($index)
    {
        if( !isset( $this->path_items[$index] ) )
        {
            return "";
        }
        return $this->path_items[$index];
    }

    public function getAction()
    {
        return $this->item(1);
    }

    public function getParam($name)
    {
        if (empty($this->params))
        {
            for ($i = 2; $i < count($this->path_items); $i+=2)
            {
                $this->params[$this->path_items[$i]] = $this->path_items[$i + 1];
            }
        }
        if( !isset( $this->params[$name] ) )
        {
            return "";
        }
        return $this->params[$name];
    }

}

?>
