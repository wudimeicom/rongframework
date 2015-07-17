<?php
class Rong_Language{
	public $language = "cn";//current language
	public $defaultLanguage = "cn";
	
	public $languages = array(); //cn en 
	public $translations = array(); //
	public $languageDirectory = "";
	
	public $allowLogNotFoundItem = false;
	public $logFile = "";
	
	public function __construct( /* $lang */ )
	{
		//$this->language = $lang;
	}
	
	
	public function loadLanguageFile( $file )
	{
		$newLangs = include $this->languageDirectory . "/" . $this->language . "/" . $file;
		if( !empty( $newLangs ) )
		{
			foreach ( $newLangs as $key => $value) {
				$this->languageArray[ $key ] = $value;
			}
		}
	}
	
	public function text( $key , $options = array() )
	{
		$value = @$this->languageArray[ $key ];
		$value = $this->replaceLanguageTemplate($value ,$options );
		if( @trim(  $value ) == "" && $this->allowLogNotFoundItem === true )
		{
			if( !file_exists( $this->logFile ) )
			{
				file_put_contents( $this->logFile , '<' . '?php return array(); ?>'  );
			}
			$var = include $this->logFile;
			@$var[$key] = $key;
			$content = '<' . '?php return ' . var_export( $var , true ) . '; ?>';
			file_put_contents( $this->logFile , $content );
			
		}
		return $value;
	}
	
	public function textSub( $key , $subKey , $options = array() )
	{
		$value = $this->languageArray[ $key ][$subKey];
		$value = $this->replaceLanguageTemplate($value , $options);
		return $value;
	}
	
	public function replaceLanguageTemplate( $value ,$options = array()  )
	{
		if( is_string( $value ) )
		{
			if( !empty( $options ) && is_array( $options)  )
			{
				foreach ($options as $opt_key => $opt_value) {
					$value = str_replace( "{" . $opt_key . "}", $opt_value , $value );
				}
			}
		}
		elseif( is_array( $value )){
			if( !empty( $value ) )
			{
				foreach ($value as $a_key => $a_value) {
					if( !empty( $options ) )
					{
						foreach ($options as $opt_key => $opt_value) {
							$value[ $a_key] = str_replace( "{" . $opt_key . "}", $opt_value , $a_value );
						}
					}
				}
			}
		}
		return $value;
	}
	
	public function setLanguage( $newLang )
	{
		if( array_search( $newLang , $this->languages ) !== false )
		{
			$this->language =  $newLang ;
		}
		else
		{
			$this->language = $this->defaultLanguage;
		}
		
	}
	
	public function getLanguage(   )
	{
		return $this->language  ;
	}
	
	public function setDefaultLanguage( $defLang )
	{
		$this->defaultLanguage  = $defLang;
	}
	
	public function getDefaultLanguage(   )
	{
		return $this->defaultLanguage ;
	}
	
	public function setLanguageDirectory( $LanguageDirectory )
	{
		if( !is_dir( $LanguageDirectory) )
		{
			throw new Rong_Exception("Language directory '" . $LanguageDirectory . "' not found!",1);
		}
		else
		{
			$this->languageDirectory = $LanguageDirectory;
			$dirObj = dir( $this->languageDirectory );
			while( ($file = $dirObj->read() ) !== false )
			{
				if( $file != "." && $file != ".." )
				{
					if( is_dir( $this->languageDirectory . "/" . $file ) )
					{
						$this->languages[] = $file;
					}
				}
			}
		}
	}
	
	public function getLanguageDirectory(  )
	{
		return $this->languageDirectory ;
	}
	
}
