<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/View/Tag/Abstract.php';
class Rong_View_Tag_Tag extends Rong_View_Tag_Abstract 
{
       public function __construct(   )
       {
       	   parent::__construct();
       }
       public function start( $tag )
       {
       	   $tag = trim( $tag );
       	   $args = array();
       	   $tagName = substr( $tag , 0 , strpos( $tag , " " ) );
       	   $xml = simplexml_load_string( "<".  $tag . " />" );
       	   
       	   $attrs = $xml[0]->attributes ( );
       	   foreach( $attrs as $key => $value )
       	   {
       	   		$args[ $key ] =  strval( $value ) ;
       	   }
       	   
		   $tagClassMethodArray = $this->tagNameToArray( $tagName );
		  // echo $this->getTagsDirectory() . "/" . $tagClassMethodArray["class"] . ".php";
		   
		   if( file_exists( $this->getTagsDirectory() . "/" . $tagClassMethodArray["class"] . ".php" ) )
		   {
       	   	  require_once $this->getTagsDirectory() . "/" . $tagClassMethodArray["class"] . ".php" ;
       	   	  $obj = new $tagClassMethodArray["class"]();
       	   	  echo $obj->$tagClassMethodArray["method"](  $args );
		   }
       }
}
?>
