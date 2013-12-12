<?php

require_once 'Rong/Controller/Abstract.php';

class Rong_Controller_Request extends Rong_Controller_Abstract {

    public function __construct() {
        parent::__construct();
    }

    function removeMagicQuotes() {
        static $firstTime = true; //can be call onece per http request
        if( $firstTime == true )
        {
            if(  (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()===1  )
                 || (  ini_get('magic_quotes_sybase') && ( strtolower(ini_get('magic_quotes_sybase')) != "off" )  )
               ) {
                
                $_POST = $this->_stripSlashes($_POST);
                $_GET = $this->_stripSlashes($_GET);
                $_COOKIE = $this->_stripSlashes($_COOKIE);
                $_REQUEST = $this->_stripSlashes($_REQUEST);
            }
            $firstTime = false;
        }
    }

    function _stripSlashes($value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (is_array($v)) {
                    $value[$k] = $this->_stripSlashes($v);
                } else {
                    $value[$k] = stripslashes( $v );
                }
            }
        } else {
            $value = stripslashes($value);
        }
        return $value;
    }

}