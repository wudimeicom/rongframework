<?php

class Rong_Gd_SimpleSecurityCode
{
	public $sessionKey = "securityCode";
	public function draw( $quality = 50 )
	{
		header ("Content-type: image/png");
		$charsArray = array('a','b','c','d','e','f','g','h','i','j','k','m',
		'n','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
		$text = "";
	    for( $i=0; $i<4; $i++ )
		{
		   $text .= $charsArray[ rand( 0, 33 ) ];
		}
		$_SESSION[ $this->sessionKey ] = $text;
		
		$im  = ImageCreate (40, 20) or die ("Cannot Create image");
		$back_color = ImageColorAllocate ($im , 255, 255, 255);
		
		for( $i=0;$i< 6; $i++ )
		{
			$color = ImageColorAllocate ($im , rand(0,255), rand(0,255), rand(0,255));
			imageline($im, rand(0,40), rand(0,20), rand(0,40), rand(0,20), $color);
		}
		
		$txt_color = ImageColorAllocate ($im , 10 , 35, 51);
		imagestring ( $im , 10, 0, 5, $text , $txt_color);
		imagejpeg( $im ,null , $quality  );
	}
	
	public function getSecurityCode()
	{
		return $_SESSION[ $this->sessionKey ];
	}
	
	public function changeSecurityCodeByRandom(){
		$_SESSION[ $this->sessionKey ] = rand( 1000, 90000);
	}
}
