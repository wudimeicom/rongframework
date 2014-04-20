<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * homepage  : http://rong.wudimei.com/
 * 
 * Copyright 2009, 2014 Yang Qing-rong
 * 
 * http://windows.php.net/downloads/pecl/releases/memcache/3.0.8/
 * php_memcache-3.0.8-[php version]-ts-vc11-x86.zip
 */
require_once 'Rong/Cache/Abstract.php';

class Rong_Cache_Driver_Memcache extends Rong_Cache_Abstract
{
	public $memcache;
	public function __construct( $config )
	{
		parent::__construct( $config);
		$this->initMemcache();
	}
	
	protected function initMemcache(){
		if( class_exists("Memcache") !== false )
		{
			$this->memcache = new Memcache();
			
		}
		elseif( class_exists("Memcached") !== false )
		{
			$this->memcache = new Memcached();
			//echo "memcached";
		}
		else{
			throw new Rong_Exception("the memcache extension is not installed");
		}
		
		$servers = $this->config["servers"];
		 
		for( $i=0;$i< count( $servers); $i++ )
		{
			$server = $servers[$i];
			$this->memcache->addServer($server[0],$server[1],$server[2]);
			
		}
	}
	
	public function set( $key , $value , $seconds =7200 , $tag = array() ){
		$this->memcache->set( $key ,$value, false ,time()+$seconds);
		$this->memcache->set("__RongFramework.".$key.".expire", time()+$seconds , false, time()+$seconds );
		$this->memcache->set("__RongFramework.".$key.".tag",    $tag,             false, time()+$seconds  );
		
		$this->keys_add( $key );
	}
	public function get( $key ){
		return $this->memcache->get($key);
	}
	
	public function delete( $key ){
		$this->memcache->delete( $key );
		$this->memcache->delete( "__RongFramework.".$key.".expire" );
		$this->memcache->delete( "__RongFramework.".$key.".tag" );
		
		$this->keys_delete( $key );
	}
	
	public function deleteOld( ){
		return true;
	}
	
	public function update( $key , $value ){
		$expire = $this->memcache->get("__RongFramework.".$key.".expire" );
		 
		if( $expire == "" )
		{
			return false;
		}
		
		$this->memcache->set( $key ,$value, false ,$expire);
	}
	
	/*
	 * $type : "all" or "any"
	 */
	public function deleteByTag($tag = array(), $type)
    {
    	$keys = $this->get("__RongFramework.keys");
		if( $keys == false){ $keys = array(); }
		$len = count( $keys );
		
		
		for( $i=0; $i< $len; $i++ )
		{
			$key = $keys[$i];
			$tagCached = $this->memcache->get("__RongFramework." . $key . ".tag");
			
			 
			if( $tagCached == false ){ $tagCached = array(); }
			  
			if( $type == "all" )
			{
				$allFound = true;
				if( empty($tagCached) == true )
				{
					$allFound = false;
				}
				else{
					foreach ($tagCached as $tagValue ) {
						if( array_search( $tagValue, $tag ) === false )
						{
							$allFound = false;
						}
					}
				} 
				if( $allFound == true )
				{
					 $this->delete($key);
					//echo "delete " . $key;
				}
			}
			if( $type == "any" )
			{
				$found = false;
				if( empty( $tag ))
				{
					 
				}
				else{
					
					foreach ($tag as $tagValue) {
						//echo $tagValue; 
						if( array_search( $tagValue, $tagCached ) !== false )
						{
							$found = true;
						}
					}
					
				}
				if( $found == true )
				{
					$this->delete($key);
				}
			}
		}
	}
	
	protected function keys_add( $key )
	{
		$keys = $this->get("__RongFramework.keys");
		if( $keys == false){ $keys = array(); }
		if( array_search( $key, $keys )=== false )
		{
			$keys[] = $key;
			$this->memcache->set( "__RongFramework.keys" ,$keys, false ,time()+3600*24*30);
		}
	}
	
	protected function keys_delete( $key )
	{
		$keys = $this->get("__RongFramework.keys");
		if( $keys == false){ $keys = array(); }
		$len = count( $keys );
		$newKeys = array();
		foreach( $keys as $item)
		{
			if( $item != $key )
			{
				$newKeys[] = $item;
			}
		}
		$this->memcache->set( "__RongFramework.keys" ,$newKeys, false ,time()+3600*24*30);
	}
}
