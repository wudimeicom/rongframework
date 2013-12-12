<?php

class Rong_Mail_SendMail {

    /**
     * pending array("name"=>"","email"=>"")
     * @var type string
     */
    public $from = "";

    /**
     *
     * @var array
     */
    public $to = array();
    public $subject = "";
    public $content = "";

    public function send() {
        if(is_string( $this->to ) )
        {
            $this->to = explode(",", $this->to );
        }
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        
        // Additional headers
        for( $i=0; $i< count( $this->to ); $i++ )
        {
            $headers .= 'To: You <' . $this->to[$i] . '>' . "\r\n";
        }
        $headers .= 'From: 无敌美 <290359552@qq.com>' . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        mail( implode(",", $this->to ), $this->subject, $this->content, $headers);
    }

}

?>