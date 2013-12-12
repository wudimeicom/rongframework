<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__)."/../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/Crypto/SwapBit.php';

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

