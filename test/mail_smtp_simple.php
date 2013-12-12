<?php 

/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

//$GLOBALS["debug"] =1;
require_once 'Rong/Mail/Smtp.php';
$smtp = new Rong_Mail_Smtp();
$smtp->host = "smtp.exmail.qq.com";
$smtp->port = 25;
$smtp->username = "yangqingrong@wudimei.com";
$smtp->password = "*******";
$smtp->from ="yangqingrong@wudimei.com";

$smtp->debug =true;
 $smtp->connect(); //连接
$smtp->login(); //登录


//------------send first email start 发第一封邮件开始-------
$smtp->to = array("admin@wudimei.com" );
$smtp->subject = "hello,how are you?你好吗？";
$smtp->content = "hello,<b>你好吗？</b>";
$smtp->send();//send an email
//------------send first email end 发第一封邮件结束-------
  
  
//------------send second email start 发第二封邮件开始------
/*
$smtp->to = array("yqr@wudimei.com");
$smtp->subject = "i would like to meet you next day.";
$smtp->content = "do you have time?";
$smtp->send();
*/
//------------send second email end 发第二封邮件结束-----

//.....

$smtp->quit(); //退出登录
$smtp->close();  //关闭连接


