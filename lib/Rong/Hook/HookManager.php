<?php
require_once 'Rong/Exception.php';

class Rong_Hook_HookManager extends Rong_Object{
    public $hookDirectory;
    protected $hooks;
    public function setHookDirectory( $dir )
    {
        $this->hookDirectory = $dir;
    }
    
    public function loadHooks(){
        if( !is_dir( $this->hookDirectory ) )
        {
            throw  new Rong_Exception("hook directory not exists!");
        }
        $this->scanDir( $this->hookDirectory );
        
    }
    
    protected function scanDir( $dir )
    {
        $dirObj = dir( $dir );
        while( ($file = $dirObj->read()) != false )
        {
            if( $file != "." && $file != ".." )
            {
                $path = $dir . "/" . $file;
                if(is_dir($path))
                {
                    $this->scanDir( $path );
                }
                elseif(is_file ($path)){
                    if( strpos( basename($path) , "Hook_" ) == 0 )
                    {
                        require_once $path;
                        $className = str_replace(".php", "", basename($path) );
                        $classObj = new $className();
                        $this->hooks[] = $classObj;
                    }
                }
            }
        }
    }
    
    public function hang( $hook_name ){
        for( $i=0; $i< count( $this->hooks); $i++ )
        {
            if(method_exists($this->hooks[$i], $hook_name) )
            {
                $this->hooks[$i]->$hook_name();
            }
        }
    }
}
?>
