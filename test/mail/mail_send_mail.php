<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );


require_once 'Rong/Mail/SendMail.php';

$mail = new Rong_Mail_SendMail();
$mail->to = array( "abc@****.com" );
$mail->from = "abc@****.com";
$mail->subject =  " how are you?";
$mail->content = "content";
$mail->send();