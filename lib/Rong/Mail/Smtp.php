<?php
//http://www.ietf.org/rfc/rfc0822.txt
class Rong_Mail_Smtp {

    private $fp;
    public $host;
    public $port;
    public $username;
    public $password;
    public $ssl = false;
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
    
    public $debug = false;

    public function __construct() {
        
        //$this->login();
       
    }
    
    public function connect()
    {
        $errorNo = "";
        $errorStr = "";
        if( $this->ssl == true )
        {
            $this->host = "ssl://" . $this->host;
        }
        $this->fp = fsockopen( $this->host , $this->port , $errorNo , $errorStr , 30 );
        if (!$this->fp) {
            
        } else {
           
        }
        $res = $this->receive();
    }
    
    public function login() {
        $this->cmd("EHLO " . $this->host . "\r\n");
        $this->cmd("auth login\r\n");
        $this->cmd(base64_encode($this->username) . "\r\n");
        $this->cmd(base64_encode($this->password) . "\r\n");
    }

    public function cmd($cmd) {
        fputs($this->fp, $cmd);
        $res = $this->receive();
        if ($this->debug) {
            echo ">>" . $cmd . "<br />";
            echo "<<" . $res . "<br />";
        }
        return $res;
    }

    function receive() {
        $res = fgets($this->fp, 4096);
        $status = socket_get_status($this->fp);
        if ($status["unread_bytes"] > 0) {
            $res .= fread($this->fp, $status["unread_bytes"]);
        }
        return $res;
    }

   

    public function send( ) {
        $this->cmd("mail from: <" . $this->from . ">\r\n");
        if(is_string( $this->to ) )
        {
            $this->to = explode(",", $this->to );
        }
        for( $i=0; $i< count( $this->to ); $i++ )
        {
            $this->cmd("rcpt to: <" . $this->to[$i] . ">\r\n");
        }
        $this->cmd("data\r\n");
        $this->cmd("subject:" . $this->subject . "\r\n" .
                "from: <" . $this->from . ">\r\n" .
                "content-type:text/html;charset=\"utf-8\"\r\n" .
                "to:" . implode(",",$this->to) . "\r\n\r\n" .
                $this->content . "\r\n.\r\n" );
 
    }
    
    public function quit()
    {
        $this->cmd("quit\r\n");
    }
    
    public function close() {
        fclose($this->fp);
    }

}

 
?>
