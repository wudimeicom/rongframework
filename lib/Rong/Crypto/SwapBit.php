<?php
/**
 *  Swap Bit algorithm 
 */
class Rong_Crypto_SwapBit {

    function encrypt($text, $password) {
        $arr = array();
        for ($i = 0; $i < strlen($text); $i++) {
            $ch = ord($text[$i]);
            $b = decbin($ch);
            $bstr = strrev(str_repeat("0", 8 - strlen($b)) . $b);
            $arr[] = $bstr;
        }
        //print_r( $arr );
        $records = array();
        $passPos = 0;
        
        $passLength = strlen($password);
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < 8; $j+=3) {
                if ($passPos >= $passLength) {
                    $passPos = 0;
                }
                $posVal = ord($password[$passPos]);
                $posVal = ($posVal + ($i * 8 + $j)) % (8 * count($arr));
                $i2 = intval($posVal / 8);
                $j2 = intval($posVal % 8);
                
                $tmp = $arr[$i][$j];
                $arr[$i][$j] = $arr[$i2][$j2];
                $arr[$i2][$j2] = $tmp;
                //echo $i . "," . $j . " => " . $i2 . "," . $j2 . "\n";
                $passPos++;
            }
        }
        //print_r( $arr );
        $str = "";
        for ($i = 0; $i < count($arr); $i++) {
            $str .= chr(bindec($arr[$i]));
        }
        //echo $str;
        $str = base64_encode($str);
        return $str;
    }

    function decrypt($text, $password) {
        $text = base64_decode($text);
        $arr = array();
        for ($i = 0; $i < strlen($text); $i++) {
            $b = decbin(ord($text[$i]));
            $arr[] = str_repeat("0", 8 - strlen($b)) . $b;
        }
        //print_r( $arr );
        $passPos = 0;
        $passLength = strlen($password);
        $rules = array();
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < 8; $j+=3) {
                if ($passPos >= $passLength) {
                    $passPos = 0;
                }
               // echo $passPos;
                $posVal = ord($password[$passPos]);
                $posVal = ($posVal + ($i * 8 + $j)) % (8 * count($arr));
                $i2 = intval($posVal / 8);
                $j2 = intval($posVal % 8);
                /*
                  $tmp = $arr[$i][$j];
                  $arr[$i][$j] = $arr[$i2][$j2];
                  $arr[$i2][$j2] = $tmp;
                 * 
                 */
                $rules[] = array($i, $j, $i2, $j2);
                // echo $i . "," . $j . " => " . $i2 . "," . $j2 . "\n";
                $passPos++;
            }
        }
        //print_r( $rules );
        for ($i = count($rules) - 1; $i >= 0; $i--) {
            $x1 = $rules[$i][0];
            $y1 = $rules[$i][1];
            $x2 = $rules[$i][2];
            $y2 = $rules[$i][3];
            $tmp = $arr[$x1][$y1];
            $arr[$x1][$y1] = $arr[$x2][$y2];
            $arr[$x2][$y2] = $tmp;
        }
        $str = "";
        for ($i = 0; $i < count($arr); $i++) {
            $str .= chr(bindec(strrev($arr[$i])));
        }
        return $str;
        //print_r( $arr );
    }

    /**
     * 0,1 => 12,6
     * 12,6 => 1,5
     * 1,5 => 1,2
     * 
     * 10000110
     * 10000110 0,0
     * 11000010 1,6
     * 
     *    012345
     * 00 123456
     * 15 163452
     * 34 163542
     * 
     * 34 163452
     * 15 123456
     */
}

?>
