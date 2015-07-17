<?php
require_once "Rong/Language.php";

class Rong_View_Wudimei_Language{
    /**
     * 
     * @var Rong_Language
     */
    public $languageObject;
    
    public function compileLangTag($attrString ){
        
        $arrCode = "array(";
        $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList( $attrString );
        foreach ( $attrs as $k => $v ){
            $attrs[$k] = Rong_View_Wudimei::compileExpression($v );
            if( $k !== "key"){
                $arrCode .= "'" . $k . "' => " . $attrs[$k] . ",";
            }
        }
        $arrCode .= ")";
       // file_put_contents("d:/a.txt", var_export($attrs,true ));
        return "echo \$this->lang->languageObject->text(" . $attrs["key"]. " ," . $arrCode . ");";
    }
    
    public function setLanguageObject($languageObject){
        $this->languageObject = $languageObject;
    }
}