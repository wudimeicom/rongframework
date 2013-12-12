<?php
require_once 'Rong/Mail/Smtp.php';
class SmtpController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    
    public function indexAction(){
        
       
        $smtp = new Rong_Mail_Smtp();
        $smtp->host = "smtp.exmail.qq.com";
        $smtp->port = 25;
        $smtp->username = "yangqingrong@wudimei.com";
        $smtp->password = "*******";
        $smtp->from ="yangqingrong@wudimei.com";
        
        $smtp->debug =true;
         $smtp->connect();
        $smtp->login();
        
        //------------send first email start-------
        $smtp->to = array("admin@wudimei.com" );
        $smtp->subject = "hello,how are you?你好吗？";
        $smtp->content = "hello,<b>你好吗？</b>";
        $smtp->send();//send an email
        //------------send first email end-------
      
        //------------send second email start------
        /*
        $smtp->to = array("yqr@wudimei.com");
        $smtp->subject = "i would like to meet you next day.";
        $smtp->content = "do you have time?";
        $smtp->send();
        */
        //------------send second email end------
        $smtp->quit();
        $smtp->close();
    }
    
    public function sslAction()
    {
        //uncomment this line in php.ini:  ;extension=php_openssl.dll
        $smtp = new Rong_Mail_Smtp();
        $smtp->host = "smtp.gmail.com";
        $smtp->port = 465;
        $smtp->username = "**********@gmail.com";
        $smtp->password = "*******";
        $smtp->ssl = true; 
        $smtp->debug =true; //if it was set to true,the smtp will output the debug info.
        
        $smtp->from ="**********@gmail.com";
        
        $smtp->connect();
        $smtp->login();
        //------------send first email start--------
        $smtp->to = array("yangqingrong@wudimei.com","admin@wudimei.com");
        $smtp->subject = "hello,how are you?你好吗？";
        $smtp->content = "hello,<b>你好吗？</b>";
        $smtp->send();//send an email
        //------------send first email end--------
        
        //------------send second email start--------
        /*
        $smtp->to = array("admin@wudimei.com");
        $smtp->subject = "i would like to meet you next day.";
        $smtp->content = "do you have time?";
        $smtp->send();
        */
        //------------send second email end--------
        $smtp->quit();
        $smtp->close();
    }
}
?>
