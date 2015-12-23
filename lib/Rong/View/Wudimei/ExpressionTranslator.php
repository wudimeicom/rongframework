<?php
define("WT_ARRAY_ELEMENT", 1);
class Rong_View_Wudimei_ExpressionTranslator{

    public static function translate( $exp ){
    
        
    
        $exp = "<" . "?php " .$exp;
        $tokens = token_get_all( $exp );
    
        $replacement = array(
                "lt" => "<",
                "gt" => ">",
                "lte" => "<=",
                "gte" => ">=",
                "eq"  => "==",
                "neq" => "!="
        );
    
        for( $i=0; $i< count( $tokens); $i++ ){
            $t = &$tokens[$i];
            if( is_array($t)){
                if( $t[0] == T_VARIABLE ){
                    $t[1] = "@\$this->data[\"" .trim( $t[1],"\$") . "\"]";
                }
                if( $t[0] == T_STRING ){ //replace template keyword
                    if( isset($replacement[ trim($t[1])] )){
                        $t[1] = $replacement[$t[1]];
                    }
                }
            }
            else{
                if( isset($replacement[ trim($t)] )){
                    $t = $replacement[$t];
                }
            }
        }
        //array element
        $newTk = array();
        for( $i=0; $i< count( $tokens); $i++ ){
            $t = &$tokens[$i];
            if( is_array($t) == false && trim($t) == "." ){
                $tn = &$tokens[$i+1];
                $code = $tn[1];
                if( $tn[0] == T_STRING ){
                    $code = "\"" . $tn[1]."\"";
                }
                elseif( $tn[0] == T_FOREACH ){
                    $code = "\"" . $tn[1]."\"";
                }
                $tn[1] = "[" . $code . "]";
                $tn[3] = WT_ARRAY_ELEMENT;
                $newTk[] = $tn;
                $i++;
                continue;
            }
            $newTk[] = $t;
        }
        unset($tokens);
        //dot number as elemnt
        for( $i=0; $i< count( $newTk); $i++ ){
            $t = &$newTk[$i];
            if( is_array( $t )){
                $code = $t[1];
                if( $t[0] == T_DNUMBER&& substr($code,0,1) == "." && ($newTk[$i-1][0] == T_VARIABLE ||$newTk[$i-1][3]==WT_ARRAY_ELEMENT)  ){
                    $code = "[".trim( $code , ".") . "]";
                    $t[1] = $code;
                    $t[3] = WT_ARRAY_ELEMENT;
                }
            }
        }
        //concat variable
        $newTk2 = array();
        $j=0;
        for( $i=0; $i< count( $newTk); $i++ ){
            $t = &$newTk[$i];
            if( is_array( $t )){
                $type = $t[0];
                $code = $t[1];
                $wtype = @$t[3];
                if( $type == T_OBJECT_OPERATOR   )
                {
                    $newTk2[$j-1][1] .= "->" .$newTk[$i+1][1];
                    $i++;
                }
                elseif( $wtype == WT_ARRAY_ELEMENT){
                    $newTk2[$j-1][1] .= $code;
                }
                else{
                    $newTk2[$j++] = $t;
                }
            }
            else{
                $newTk2[$j++] = $t;
            }
        }
        unset( $newTk);
        //concat modifier
        $newTk3 = array();
        $newTk2_count = count( $newTk2 );
        for( $i=0; $i< $newTk2_count; $i++ ){
            $t = &$newTk2[$i];
            if( is_array( $t )){
                $type = $t[0];
                $code = $t[1];
                $wtype = @$t[3];
                $newTk3[] = $t;
            }
            else{
                if( trim( $t) == "|"){
                    $fuc_name = "wudimei_". $newTk2[$i+1][1];
                    $params = array();
                    for( $j= $i+2;$j<$newTk2_count; $j+=2 ){
    
                        $t2 = $newTk2[$j];
                        //echo $t2[1];
                        if( @trim($t2 ) != ":"){
    
                            break;
                        }
                        $params[] = $newTk2[$j+1][1];
                        $newTk2[$j+1][1] = "";
                        $newTk2[$j] = "";
    
                    }
                    $lastVarIndex = $i-1;
                    while( $lastVarIndex>0 ){
                        $var = @$newTk2[$lastVarIndex][1];
                        if( trim( $var ) != ""){
                            break;
                        }
                        $lastVarIndex--;
                    }
                    $var = $newTk2[$lastVarIndex][1];
                   
                    $paramStr = implode("," , $params ) ;
                    if( trim( $paramStr ) != "" ){ //consider the none-param modifier
                        $paramStr = "," . $paramStr;
                    }
                    $var = $fuc_name . "(" . $var .$paramStr. ") ";
                    $newTk2[$lastVarIndex][1] = $var;
                    $newTk2[$i+1][1] = "";
                    $newTk2[$i] = "";
                }
            }
        }
    
        $newCode = "";
        for( $i=1; $i< $newTk2_count; $i++ ){
            $t = &$newTk2[$i];
            if( is_array( $t )){
    
                $code = $t[1];
                $newCode .= $code;
            }
            else{
                $newCode .= $t;
            }
        }
        unset( $newTk2);
        return $newCode;
        //display_token( $newTk2 ,2);
    }
    
}