<?php
interface Rong_View_Interface
{
	/**
	 * 
	 * display the view template
	 * @param string $Rong_View_File eg aboutus/index.php
	 * @param array $Rong_View_Data eg array("title" => "Rong framework","author"=>array("yangqingrong") );
	 * @param boolean $Rong_View_Return if given true,return the template result as string
	 */
	public function display( $Rong_View_File , $Rong_View_Data = array() , $Rong_View_Return = false );
	 
	/**
	 * 
	 * assign var to template
	 * @param string $key var name
	 * @param mixed $value var value
	 */
	public static function assign( $key , $value );
	/**
	 * 
	 * set configuration vars for template engine
	 * @param array $configArray
	 */
	public function setConfig( $configArray );
	/**
	 * get configuration
	 *  
	 * @param string $key the key of the configuration array
	 */
	public function getConfig( $key );
}