<?php
require_once "Rong/Mail/SendMail.php";
 class SendMailController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    
    public function indexAction(){
        
        $mail = new Rong_Mail_SendMail();
        $mail->to = array( "abc@****.com" );
        $mail->from = "abc@****.com";
        $mail->subject =  " how are you?";
        $mail->content = "content";
        $mail->send();
    }
 }
?>
