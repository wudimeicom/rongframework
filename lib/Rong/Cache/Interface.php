<?php
interface Rong_Cache_Interface 
{
	/**
	 * set cache
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param  int seconds
	 * @param  array $tag
	 */
	
	public function set( $key , $value , $seconds =7200 , $tag = array() );
	public function get( $key );
	public function delete( $key );
	public function deleteOld( );
	public function update( $key , $value );
	public function deleteByTag($tag = array(), $type);
}
?>