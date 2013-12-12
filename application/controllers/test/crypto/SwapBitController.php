<?php

require_once 'Rong/Crypto/SwapBit.php';
class SwapBitController extends Rong_Controller {

    public function __construct() {
        parent::__construct();
    }
    // http://127.0.0.9/index.php/test/crypto/SwapBit
    public function indexAction() {
        
        
        $text = "Hello,this is the text to be encrypted!";
        $password ="pasword";
        
        $start = microtime( true );
        $swapBit = new Rong_Crypto_SwapBit();
        
        
        $encryptedText = $swapBit->encrypt($text, $password);
        echo "encrypted text: " . $encryptedText . "<br />";
        
        $decryptedText = $swapBit->decrypt($encryptedText , $password);
        echo "decrypted text: " . $decryptedText  . "<br />";
        
        echo "base 64 decode: " . base64_decode( $encryptedText );
        $end = microtime( true );
        echo "<br />" . (   $end - $start ) . " seconds";
    }
}
?>
