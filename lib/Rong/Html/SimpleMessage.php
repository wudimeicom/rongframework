<?php
class Rong_Html_SimpleMessage{
	
	public $redirection_delay = 5000; //
	public $redirection_uri = "";
	public $template_path = "";
	
	public $charset = "utf-8";
	public $okButtonText = "OK";
	
	public function show( $message , $title   )
	{
		if( file_exists( $this->template_path) )
	    {
			include $this->template_path;
		}
		else{
			$this->_showMessage( $message, $title );
		}
	}
	
	
	private function _showMessage( $message, $title )
	{
		$html  = '<html><head>';
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=' . $this->charset . '" />';
		$html .= '<title>' . $title . '</title>';
		$html .= '<style type="text/css">';
		$html .= '.MessageBox{ margin-left:auto;margin-right:auto;width:500px;border:1px solid #E4E4E4;} '."\r\n";
		$html .= '.MessageTitle{ font-weight:bold; padding:2px 5px; background-color:#F0F0F0; } '."\r\n";
		$html .= '.MessageContent{ padding:10px 5px;background-color:#FEFEFE;} '."\r\n";
		$html .= '.buttonDiv{ margin-top:10px; }' . "\r\n";
		$html .= '</style>';
		$html .= '</head><body>';
		$html .= '<div class="MessageBox">';
		if( trim( $title )  != "" )
		{
			$html .= '<div class="MessageTitle">' . $title .'</div>';
		}
		$html .= '<div class="MessageContent">' . $message;
		if( trim( $this->redirection_uri ) != "" )
		{
			$html .= '<div class="buttonDiv"> <input type="button" value="' . $this->okButtonText . '" onclick="location.href=\''. $this->redirection_uri .'\';" /> </div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		if( trim( $this->redirection_uri ) != "" )
		{
			$html .= '<script type="text/javascript">';
			$html .= 'setTimeout(function(){ location.href = "'. $this->redirection_uri .'"; },'. $this->redirection_delay .' ); ';
			$html .= '</script>';
		}
		$html .= '</body></html>';
		echo $html;
	}
	
	public function setRedirectionDelay( $newDelay )
	{
		$this->redirection_delay = $newDelay;
	}
	
	public function getRedirectionDelay(   )
	{
		return $this->redirection_delay  ;
	}
	
	public function setRedirectionUri( $uri ){
		$this->redirection_uri = $uri;
	}
	
	public function getRedirectionUri(  ){
		return $this->redirection_uri ;
	}
	
	public function getTemplatePath(){
		return $this->template_path;
	}
	
	public function setTemplatePath( $path ){
		return $this->template_path = $path ;
	}
	
	public function getCharset( )
	{
		return $this->charset;
	}
	
	public function setCharset( $charset )
	{
		$this->charset = $charset;
	}
	
	public function getOkButtonText()
	{
		return $this->okButtonText;
	}
	
	public function setOkButtonText( $okButtonText )
	{
		$this->okButtonText =  $okButtonText ;
	}
}
