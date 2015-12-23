<?php


class Rong_Session_File implements SessionHandlerInterface
{
	private $config;
	
	public function __construct($config){
		$this->config = $config;
	}
	
	function open($savePath, $sessionName)
	{ 
		//if( is_dir( $savePath ) ){
			//$this->config["save_path"] = $savePath;
		//}
		if (!is_dir($this->config["save_path"])) {
			mkdir($this->config["save_path"], 0777,true);
		}
		
		return true;
	}

	function close()
	{
		
		return true;
	}

	function read($id)
	{
		static $hasClean = false;
		if( $hasClean == false ){
			$this->gc( $this->config["gc_maxlifetime"]);
			$hasClean = true;
			
		}
		return (string)@file_get_contents( $this->config["save_path"]."/sess_".$id );
	}

	function write($id, $data)
	{
		return file_put_contents($this->config["save_path"]."/sess_".$id, $data) === false ? false : true;
	}

	function destroy($id)
	{
		$file = $this->config["save_path"]."/sess_".$id;
		if (file_exists($file)) {
			unlink($file);
		}

		return true;
	}

	function gc($maxlifetime)
	{
		foreach (glob($this->config["save_path"]."/sess_*") as $file) {
			if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
				unlink($file);
			}
		}

		return true;
	}
	
	function create_sid(){
		return uniqid("");
	}
}
