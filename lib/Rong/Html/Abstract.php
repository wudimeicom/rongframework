<?php
require_once 'Rong/Object.php';
require_once 'Rong/Html/Interface.php';

abstract class Rong_Html_Abstract extends Rong_Object  implements Rong_Html_Interface
{
    /**
     *
     * @var string $tagName html element's tag name
     */
        public $tagName ;
        /**
         *
         * @var array $attributes html elements attributes
         */
        public $attributes = array();
       
        
	public function __construct( )
	{
		parent::__construct();
	}
        /**
         * set an attribute with it's name and value
         * @param type $name
         * @param type $value
         * @return \Rong_Html_Abstract
         */
        public function set($name, $value) {
            @$this->attributes[$name] = $value;
            return $this;
        }
        /**
         * remove an attribute of current html element
         * @param type $name
         * @return \Rong_Html_Abstract
         */
        public function remove( $name )
        {
            unset( $this->attributes[$name] );
            return $this;
        }
        
        /**
         * convernt $attributes array into html string
         * @return string html attributes string
         */
        public function attributesToHtml()
        {
            $html = " ";
            foreach ( $this->attributes as $k => $v )
            {
               
                ///if(   $v != "" && $k[0] != "_" )
                //{
                   $html .= $k . "=\"" . $v . "\" "; 
                //}
            }
            return $html;
        }
}
?>