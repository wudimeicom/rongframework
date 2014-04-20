<?php

/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * 
 * Copyright 2009, 2014 Yang Qing-rong
 */
require_once 'Rong/Cache/Abstract.php';

class Rong_Cache_Driver_File extends Rong_Cache_Abstract
{

    public function set($key, $value, $seconds = 7200, $tag = array())
    {
        //expire  config:cach_dir
        
        $cacheFile = $this->getCacheFilePath($key);
		$this->saveDataToFile( $cacheFile, $value);
		
        //info
        $info = array();
        $info["expire"] = strtotime("now") + $seconds;
        $info["tag"] = $tag;
		
        $infoFileName = $this->getCacheInfoFilePath($key);
        $this->saveDataToFile( $infoFileName, $info );
		
    }

    public function get($key)
    {
        $cacheFile = $this->getCacheFilePath($key);

        $infoFileName = $this->getCacheInfoFilePath($key);
        if (!file_exists($infoFileName))
        {
            return null;
        }

        $cache_info = include $infoFileName;
         
        if ($cache_info["expire"] < strtotime("now"))
        {
            @unlink($infoFileName);
            @unlink($cacheFile);
            return null;
        }

        $cache_value = include $cacheFile;
        return $cache_value;
    }

    public function delete($key)
    {
       
        $cacheFile = $this->getCacheFilePath($key);

        $infoFileName = $this->getCacheInfoFilePath($key);
        @unlink($infoFileName);
        @unlink($cacheFile);
    }

    public function deleteOld()
    {
        $dirObj = dir($this->config["cache_dir"]);
        while ($entry = $dirObj->read())
        {
            if ($entry != "." && $entry != "..")
            {
                if (strpos($entry, "Rong_Cache_Info") !== false)
                {
                    $cacheInfoFile = $this->config["cache_dir"] . "/" . $entry  ;
                    //$info = unserialize( file_get_contents( $cacheInfoFile ) );
                    $cache_info = include $cacheInfoFile;
                    if ($cache_info["expire"] < strtotime("now"))
                    {
                        $cacheFile = str_replace("_Info", "", $cacheInfoFile);
                        @unlink($cacheFile);
                        @unlink($cacheInfoFile);
                    }
                }
            }
        }
    }

    /*
     * @$type  "all" or "any"
     */

    public function deleteByTag($tag = array(), $type)
    {
        $dirObj = dir($this->config["cache_dir"]);
        while ($entry = $dirObj->read())
        {
            if ($entry != "." && $entry != "..")
            {
                if (strpos($entry, "Rong_Cache_Info") !== false)
                {
                    $cacheInfoFile = $this->config["cache_dir"] . "/" . $entry;
                    $info =include $cacheInfoFile;
                     
                    $cacheTag = $info["tag"];
					
                    if ($type == "any")
                    {
                        $find = false;
                        for ($i = 0; $i < count($tag); $i++)
                        {
                            if (in_array($tag[$i], $cacheTag))
                            {

                                $find = TRUE;
                            }
                        }
                        if ($find)
                        {
                            $cacheFile = str_replace("_Info", "", $cacheInfoFile);
                            @unlink($cacheFile);
                            @unlink($cacheInfoFile);
                        }
                    } elseif ($type == "all")
                    {
                        $hasError = false;
                        for ($i = 0; $i < count($tag); $i++)
                        {
                            if (!in_array($tag[$i], $cacheTag))
                            {

                                $hasError = TRUE;
                            }
                        }
                        if (!$hasError)
                        {
                            $cacheFile = str_replace("_Info", "", $cacheInfoFile);
                            @unlink($cacheFile);
                            @unlink($cacheInfoFile);
                        }
                    } else
                    {
                        return null;
                    }
                }
            }
        }
    }

    public function update($key, $value, $tag = array())
    {
        
        $cacheFile = $this->getCacheFilePath($key);
        if (isset($value))
        {
            $this->saveDataToFile( $cacheFile, $value);
        }
         
        $infoFileName = $this->getCacheInfoFilePath($key);

        $info =include $infoFileName;
        
        if (!empty($tag))
        {
            $info["tag"] = $tag;
			$this->saveDataToFile( $infoFileName, $info );
        }
    }
	
	public function getRegularFileName($fileName){
		return preg_replace("/([^a-zA-Z0-9\.\_]+)/i", "", $fileName );
	}

	private function getCacheFilePath( $key )
	{
		$key2 = $this->getRegularFileName( $key );
        $fileName = "Rong_Cache_" . $key2;
        $cacheFile = $this->config["cache_dir"] . "/" . $fileName . ".php";
		return $cacheFile;
	}
	
	private function getCacheInfoFilePath( $key )
	{
		 $key2 = $this->getRegularFileName( $key );
		 $infoFileName = $this->config["cache_dir"] . "/Rong_Cache_Info_" . $key2 . ".php";
		 return $infoFileName;
	}
	
	private function saveDataToFile( $filePath, $value )
	{
		$valuePhp = "<?php\r\n return " . var_export($value, true) . "; ?>";
        file_put_contents( $filePath, $valuePhp);
	}
}

?>