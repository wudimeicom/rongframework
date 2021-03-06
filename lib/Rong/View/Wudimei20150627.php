<?php

require_once 'Rong/View/Interface.php';
require_once 'Rong/View/Abstract.php';
require_once 'Rong/View/Wudimei/html.php';
require_once 'Rong/View/Wudimei/Parser/Document.php';
require_once "Rong/Logger.php";

class Rong_View_Wudimei extends Rong_View_Abstract implements Rong_View_Interface
{

    public $leftDelimiter = '<!--{';
    public $rightDelimiter = '}-->';
    public $compileDir = "";
    public $forceCompile = false;
    //public $basePath = ""; //base path of the template
    public $data;
    
    public $cachedTplFiles = array();
    public $blocks; 
    public $blockNames = array();
    /* array( [a.html]=> array("parent" => "b.html",
     *                          "blocks" => array(
     *                                          array("name"=>"name",
     *                                                 "content" =>"abc"
     *                                               )
     *                                           )
     *                         ); */
    
    public static $logger;
    
    public function __construct()
    {
        parent::__construct();
        self::$logger =  Rong_Logger::getLogger();
        
        $this->data["wudimei"] = array("foreach" => array()  );
		$this->updateWudimeiSystemArray();
        $this->loadPlugins();
    }
	
	
	public function updateWudimeiSystemArray()
	{
		$this->data["wudimei"]["get"] = &$_GET;
		$this->data["wudimei"]["post"] = &$_POST;
		$this->data["wudimei"]["session"] = &$_SESSION;
		$this->data["wudimei"]["cookie"] = &$_COOKIE;
		$this->data["wudimei"]["now"] = date("Y-m-d H:i:s");
		$this->data["wudimei"]["global"] = &$GLOBALS;
		$this->data["wudimei"]["server"] = &$_SERVER; 
		$this->data["wudimei"]["files"]  =&$_FILES;
		$this->data["wudimei"]["request"] =&$_REQUEST;
		$this->data["wudimei"]["env"] = &$_ENV;
	}
	
    public function loadPlugins()
    {
        $dirObj = dir(dirname(__FILE__) . "/Wudimei/Plugins");
        while ($file = $dirObj->read())
        {
            if ($file != "." && $file != "..")
            {
                require_once dirname(__FILE__) . "/Wudimei/Plugins/" . $file;
            }
        }
        $dirObj->close();
    }

    public  function selectCallback($matches)
    {
        //$tag = trim($matches[1]);
        
        $tag = trim($matches);
        if( $tag == "") return "";
        $code = "";
        if (substr($tag, 0, 1) == '$')
        {

            $code = 'echo wudimei_toString(' . self::compileExpression(substr($tag, 0)) . ');';
        } elseif (@$tag[0] == '*' && substr($tag, -1) == '*')
        {
            $code = "/** " . substr($tag, 1, -2) . " */";
        } elseif (substr($tag, 0, 2) == "if")
        {
            $code = "if( " . self::compileExpression(substr($tag, 3)) . "):";
        } elseif (substr($tag, 0, 4) == "elif")
        {
            $code = "elseif( " . self::compileExpression(substr($tag, 5)) . "):";
        } elseif (substr($tag, 0, 6) == "elseif")
        {
            $code = "elseif( " . self::compileExpression(substr($tag, 7)) . "):";
        } elseif (substr($tag, 0, 4) == "else")
        {
            $code = "else:";
        } elseif (substr($tag, 0, 3) == "/if")
        {
            $code = "endif;";
        } 
        elseif (substr($tag, 0, 11) == "foreachelse")
        {
            $code = "}}else{{";
        }
        elseif (substr($tag, 0, 7) == "foreach")
        {
            $code = self::compileForeach(substr($tag, 8));
        }
        
         elseif (substr($tag, 0, 8) == "/foreach")
        {
            $code = "}}";
        } 
        elseif (substr($tag, 0, 3) == "for")
        {
            $code = self::compileFor(substr($tag, 4));
        } elseif (substr($tag, 0, 4) == "/for")
        {
            $code = "}";
        }
        elseif (substr($tag, 0, 13) == "block.display")
        {
            $code = self::compileBlockDisplay(substr($tag, 13));
        }
        elseif (substr($tag, 0, 14) == "/block.display")
        {
            $code = "";
        }
        elseif (substr($tag, 0, 13) == "block.parent")
        {
            $code = $this->compileBlockParent(substr($tag, 13) );
        }
        elseif (substr($tag, 0, 5) == "block")
        {
            $code = $this->compileBlock(substr($tag, 5));
        } 
        elseif (substr($tag, 0, 6) == "/block")
        {
            $code = " \$this->block_close(\$Rong_View_File); ";
        }
        elseif (substr($tag, 0, 7) == "include")
        {
            $code = self::compileInclude(substr($tag, 8));
        }
        elseif (substr($tag, 0, 7) == "extends")
        {
            $code = $this->compileExtends(substr($tag, 8));
        }
        elseif (substr($tag, 0, 4) == "call")
        {
            $code = $this->compileCall(substr($tag, 5)   );
        } elseif (substr($tag, 0, 3) == "set")
        {
            $code = self::compileSet(substr($tag, 4));
        } elseif (substr($tag, 0, 6) == "assign")
        {
            $code = self::compileSet(substr($tag, 7));
        } else
        {
        	
        	if( strpos($tag, " ") !== false )
			{
        		$tagName = substr( $tag, 0,strpos($tag, " "));
				$functionName = "wudimei_tag_".$tagName;
				if( function_exists( $functionName ) )
				{
					$attrs = substr( $tag,  strpos($tag, " "));
			      	//$code = $functionName($this, $attrs  ) ;
					$code = call_user_func_array( $functionName, array( $attrs ));
				}
			}
			elseif( substr( $tag, 0,1) == "/")
			{
				$tagName = substr( $tag,1);
				
				$functionName = "wudimei_tag_" . $tagName . "_end";
				if( function_exists( $functionName))
				{
					//$code =  $functionName ( $this);
					$code = call_user_func_array( $functionName, array(  ));
				}
			}
			else{
            	$code = 'echo ' . self::compileExpression($tag);
			}
        }
        if( trim( $code )  != "echo" )
        {
        	
			
            $code = '<?php ' . $code . ' ?>';
            return $code;
        }
        return "";
    }

    public static function compileInclude($expression)
    {
        preg_match_all('/file[\s]{0,5}=[\s]{0,5}["|\']{0,1}([^\'|"]+)["|\']{0,1}/i', $expression, $matches);
        $file = $matches[1][0];
        return 'echo $this->fetch("' . $file . '", $this->data );';
    }
    
    public  function compileExtends($expression)
    {
        preg_match_all('/file[\s]{0,5}=[\s]{0,5}["|\']{0,1}([^\'|"]+)["|\']{0,1}/i', $expression, $matches);
        $file = $matches[1][0];
        //echo  $file;
        $this->fetch($file, $this->data );
        return ' $this->extendsView($Rong_View_File,"' . $file . '" );';
    }

    public  function compileCall($expression  )
    {
        $attrs = self::getAttributesArrayFromTextWithOutNameList($expression);
        
        $paramsCode = "array(";
        if (!empty($attrs))
        {
            foreach ($attrs as $k => $v)
            {
                $vCompiled = self::compileExpression($v);
                $attrs[$k] = trim($vCompiled, "'\" ");
                if ($k != "function" && $k != "return")
                {
                    $paramsCode .= "\"" . $k . "\" => " . $vCompiled . ",";
                }
            }
        }
         
        $paramsCode .= ")";

        $function = $attrs["function"];
		$return = @$attrs["return"];
        $code = "";
        if (trim($function) != "")
        {
        	if( trim( $return )!= "" )
			{
				$code .= $return ."=";
			}
            $code .= "call_" . $function . "(" . $paramsCode . ", \$this  );";
        }

        return $code;
    }

    public static function compileSet($expression)
    {
        $attrs = array();
        $attrs = self::getAttributesArrayFromText($expression, "var,value");
		
		$var = $attrs["var"];
        $value = self::compileExpression($attrs["value"]);
        
        return ' $this->data["' . trim($var, '$') . '"] = ' . $value . ';';
    }

    public static function compileForeach($expression)
    {
        $attrs = array();
        $attrs = self::getAttributesArrayFromText($expression, "from,item,key");

        if (!isset($attrs["key"]) || $attrs["key"] == "")
        {
            $attrs["key"] = '$key';
        }

        $from = self::compileExpression($attrs["from"]);
        $item = self::compileExpression($attrs["item"]);
        $key = self::compileExpression($attrs["key"]);

        $code = "";
		$foreachName = trim($attrs["from"], '$ ');
		$foreachName = str_replace('$', "_", $foreachName );
		 
        $code .= '$this->data["wudimei"]["foreach"]["' . $foreachName . '" ]= array("index"=>-1);' . " ";
        $code .= "if( count(" . $from . ")>0 ){ ";
        $code .= "foreach( " . $from . "  as " . trim($key, '@ ') . " =>  " . trim($item, '@ ') . " ){  ";
        $code .= '$this->data["wudimei"]["foreach"]["' . $foreachName . '"]["index"]++;' . " ";
        return $code;
    }

    public static function compileFor($expression)
    {
        $attrs = array();
        $attrs = self::getAttributesArrayFromText($expression, "from,to,step,var");
        //print_r( $attrs );
        $from = self::compileExpression($attrs["from"]);
        $to = self::compileExpression($attrs["to"]);
        $step = self::compileExpression($attrs["step"]);
        $var = self::compileExpression($attrs["var"]);

        static $forIndex = 0;
        $forIndex++;
        $i = "\$i" . $forIndex;

        if (isset($attrs["var"]))
        {
            $i = $var; //assign var name
        }
         
        if( strpos( $step ,"-") === false )//
        {
            $code = "for( " . $i . "=" . $from . "; " . $i . "<=" . $to . "; " . $i . "+=" . $step . "){ ";
        }
        else
        {
            $code = "for( " . $i . "=" .$from. "; " . $i . ">=" .  $to  . "; " . $i . "+=" . $step . "){ ";
        }
        return $code;
    }
    
    public   function compileBlock($expression){
        $attrs = array();
        $attrs = self::getAttributesArrayFromText($expression, "name");
       
        $name = self::compileExpression($attrs["name"]);
        //echo $name;
        
        $code = "";
        $code = " \$this->block_open(\$Rong_View_File,". $name."); ";
        return $code;
        
    }
    
    public function compileBlockParent(){
        $code = "";
        $code = " \$this->blockParent(\$Rong_View_File); ";
        return $code;
    }
    public static function compileBlockDisplay($expression){
        $attrs = array();
        $attrs = self::getAttributesArrayFromText($expression, "name");
         
        $name = self::compileExpression($attrs["name"]);
        //echo $name;
    
        $code = "";
        $code = " \$this->blockDisplay(\$Rong_View_File,". $name."); ";
        return $code;
    
    }

    public static function codeToArray($code)
    {
        
        
        $arr = array();
        $arr_index = 0;
        $inString = false;
        $strQuote = '"';
        $codeLength = strlen($code);
        // echo $code . "<br />";
        for ($i = 0; $i < $codeLength; $i++)
        {
            $char = $code[$i];
            if (in_array($char, array('=', ' ')) == true && $inString == false)
            {
                $arr_index++;
                if (!isset($arr[$arr_index]))
                {
                    $arr[$arr_index] = "";
                }
                $arr[$arr_index] .= $char;
                $arr_index++;
                continue;
            }
            //string start
            if (in_array($char, array("\"", "'")) && $inString == false)
            {
                $strQuote = $char;
                $inString = true;
                if (!isset($arr[$arr_index]))
                {
                    $arr[$arr_index] = "";
                }
                $arr[$arr_index] .= $char;
                continue;
            }
            if ($char == "\\" && $inString == true)
            {
                if( in_array( $code[$i+1], array( $strQuote , "t","b","n","r","\\","'","\"" ) ) )
                {
                    $arr[$arr_index] .= $char . $code[$i+1];
                    $i++;
                    continue;
                }
            }
            //string may end
            if ($char == $strQuote && $inString == true)
            {
                
               $inString = false;
               $arr[$arr_index] .= $char;
               $arr_index++;
               continue;
            }
            if (!isset($arr[$arr_index]))
            {
                $arr[$arr_index] = "";
            }
            $arr[$arr_index] .= $char;
        }
        // print_r( $arr );
        $arr2 = array();
        $arr2_idx = 0;
        //echo count($arr);
        for ($j = 0; $j < $arr_index + 1; $j++)
        {
            if (trim(@$arr[$j]) != "")
            {
                $arr2[$arr2_idx++] = $arr[$j];
            }
        }
        // print_r( $arr2 );
        return $arr2;
    }

    public static function getAttributesArrayFromText($codeText, $keywordList)
    {
        $keywordList = "," . $keywordList . ",";
        $codeText = trim($codeText);
        //$codeText = str_replace("=", " = ", $codeText);
        // $codeTextArray = preg_split("/[\s\t\n\r]+/i", $codeText);
        $codeTextArray = self::codeToArray($codeText);
        // print_r( $codeTextArray );
        $attrs = array();
        $key = "";
        for ($i = 0; $i < count($codeTextArray); $i++)
        {
            if (strpos($keywordList, "," . $codeTextArray[$i] . ",") !== false && $codeTextArray[$i + 1] == "=")
            {
                $key = $codeTextArray[$i];
                $i+=2;
            }
            if (!isset($attrs[$key]) && trim($key) != "")
            {
                $attrs[$key] = "";
            }

            @$attrs[$key] .= @$codeTextArray[$i];
        }
        return $attrs;
    }

    public static function getAttributesArrayFromTextWithOutNameList($codeText)
    {

        $codeText = trim($codeText);
        
        $codeTextArray = self::codeToArray($codeText);
        // print_r( $codeTextArray );
        $attrs = array();
        $key = "";
        for ($i = 0; $i < count($codeTextArray); $i++)
        {
            if ($codeTextArray[$i + 1] == "=")
            {
                $key = $codeTextArray[$i];
                $i+=2;
            }
            if (!isset($attrs[$key]) && trim($key) != "")
            {
                $attrs[$key] = "";
            }

            $attrs[$key] .= $codeTextArray[$i];
        }
        return $attrs;
    }

    /**
     * 
     * @param type $expression
     */
    public static function isStringExpression($expression)
    {
        $expression = trim($expression);



        $char = @$expression[0];

        if ($char == '"' || $char == '\'')
        {

            if ($expression[strlen($expression) - 1] == $char)
            {

                for ($i = 1; $i < strlen($expression) - 1; $i++)
                {
                    if ($expression[$i] == '\\')
                    {
                        if (in_array($expression[$i + 1], array('\\', '"', '\'', 'b', 's', 'n', 'r', 't')))
                        {
                            $i++;
                        } else
                        {
                            return false;
                        }
                    }
                    if ($expression[$i] == $char)
                    {
                        if ($expression[$i - 1] != '\\')
                        {
                            return false;
                        }
                    }
                }
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
        return true;
    }

	/**
	 * "abc\"efg"  to abc"efg
	 */
	public static function evalString( $str )
	{
		eval( '$str=' . $str . ';');
		return $str;
	}
    /*
     * $var.age or $var or $var.0->nu
     */

    public static function compileVar($tag)
    {
        //echo $tag. "<br />";
        if (self::isStringExpression($tag))
        {

            return trim($tag);
        }

        $functions = array();
        //number
        if (preg_match("/^[0-9]+$/i", $tag))
        {
            return $tag;
        }
		
        //$var.aa."number.home".0 | $abc.efg 
        preg_match_all("/([a-zA-Z0-9\$\_]+(\.[a-zA-Z0-9\_]+)*(\.(\"[^\"]*\"))+(\.[a-zA-Z0-9\_]+)*)|([a-zA-Z0-9\_\.\\$\->]+)/i", $tag, $matches);
        // echo $tag; echo "<br />";
          //print_r( $matches );
        $varName = $matches[0][0];
        preg_match_all("/[\|]\s*([a-z0-9\_]+)(\s*[\:]\s*(([\$a-zA-Z0-9\.\_\->]+)|(\"[^\"]*\")|(\'([^\']*)\')))*/i", $tag, $modifier_matches);
        //  print_r( $modifier_matches );
        $modifierTxt = "";
        if (trim($varName) !== "")
        {
            $tag = $varName;
            if (!empty($modifier_matches[0]))
            {
                for ($i = 0; $i < count($modifier_matches[0]); $i++)
                {
                    $funcExp = $modifier_matches[0][$i];
                    $funcName = $modifier_matches[1][$i];
                    preg_match_all("/\:\s*(\\$*[a-z0-9\_\.\_]+|[\$a-z0-9\.\_]+|\"[^\"]*\"|\'([^\']*)\')/i", $funcExp, $params_matches);
                    $params = $params_matches[1];
                     //print_r($params_matches );
                    for ($j = 0; $j < count($params); $j++)
                    {
                        if (preg_match("/^([\$a-z0-9\_]+)(\.[0-9a-z\_]+)*$/i", $params[$j]))
                        {
                            $params[$j] = self::compileVar($params[$j]);
                        }
                    }
                    $functions[] = array(
                        "name" => $funcName,
                        "params" => $params
                    );
                }
            }
        }
		
		//echo $tag;
        //print_r( $functions );
        if (strpos($tag, ".") !== false)
        {
        	//echo "--- " . $tag ." ---";
			
            $tag2 = substr($tag, 1);
			//echo $tag2;
            //$arr = explode(".", $tag2);
			$arr = Rong_View_Wudimei::segmentWithConstStringSupport($tag2, array(".") );
            // print_r( $arr );
            $code = " @\$this->data['" . trim($arr[0]) . "']";

            if (preg_match("/\\$([a-zA-Z0-9\_]+)/i", $arr[0]))
            {
                $code = " @\$this->data[" . self::compileExpression($arr[0]) . "]";
            }
            for ($i = 1; $i < count($arr); $i++)
            {
                if (preg_match("/\\$([a-z0-9\_]+)/i", $arr[$i]))
                {
                    $code .= "[" . trim(self::compileExpression($arr[$i])) . "]";
                } else
                {
                	if( substr( trim($arr[$i]),0,1) == "\"")
					{
						$code .= "[" . trim($arr[$i]) . "]";
					}
					else{
                    	$code .= "['" . trim($arr[$i]) . "']";
					}
                }
            }
            $code .= "";
        } elseif (strpos($varName, "->") != false)
        {
            //echo $varName;
            $code = preg_replace("/\\$([a-z0-9\_]+)/i", "@\$this->data[\"\\1\"]", $varName);
            //echo $varName;
        } else
        {
            $code = ' @$this->data[\'' . substr($tag, 1) . '\']';
        }
        //echo $code;
        for ($i = 0; $i < count($functions); $i++)
        {
            $f = $functions[$i];
			 
            $code = "wudimei_" . $f["name"] . " ( " . $code;
            if (count($f["params"]) > 0)
            {
                $code .= "," . implode(",", $f["params"]);
            }
            $code .= " ) ";
        }
		//echo $code;
        return $code;
    }
	
		 
	public static function segmentWithConstStringSupport( $str ,$splitArr )
	{
		$len = strlen( $str );
		$el = "";
		$arr = array();
		$inStr = false;
		
		for( $i=0;$i< $len;$i++ )
		{
			$ch = $str[$i];
			$nextCh = isset($str[$i+1])?$str[$i+1]:"";
			if( $inStr == false )
			{
				if( $ch == "\"")
				{
					$inStr = true;
					//echo $el ."<br />";
					if( trim($el)!="") $arr[]=$el;
					$el = $ch;
				}
				else{
					$found = false;
					$str_found = "";
					for( $j=0;$j<count( $splitArr);$j++ )
					{
						$chrs = $splitArr[$j];
						if( substr( $str , $i,strlen( $chrs)) == $chrs )
						{
							//echo $el."<br />";
							if( trim($el)!="") $arr[]=$el;
							$el="";
							$found =  true;
							$str_found = $chrs;
						}
					}
					if( $found == false )
					{
						$el .=$ch;
					}
					else{
						$i+=strlen( $str_found)-1;
					}
				}
				
			}
			elseif( $inStr == true ){
				if( $ch == "\\")
				{
					if( $nextCh=="\"")
					{
						$el .= $ch.$nextCh;
						$i++;
					}
				}
				$el .=$ch;
				if( $ch == "\"")
				{
					$inStr =false;
					if( trim($el)!="") $arr[]=$el;
					//echo $el . " <br />";
					$el = "";
				}
				
			}
		}
		if( trim( $el ) != "")
		{
			$arr[] = $el;
		}
		return $arr;
	}
    /**
     * operation chars
     * Enter description here ...
     * @param unknown_type $expression
     */
    public static function compileExpression($expression)
    {
         
        
        if (self::isStringExpression($expression))
        {

            return trim($expression);
        }
        
        // $var.name   |  abc :efg
        $modifier = "((\\$[a-zA-Z0-9\_]+((\->([a-zA-Z0-9\_]+))|(\.\"[^\"]*\")|(\.[\$]?[a-zA-Z0-9\_]+))*)|(\".*\")|('.*'))(\s*[\|]\s*[a-zA-Z0-9\_]+((\s*[\:]\s*((\$[a-z0-9A-Z\.\_\->]+)|(\"([^\"]*)\")|('([^']*)')|([0-9]+)|([a-zA-Z0-9\.\$\_]+)))*)*)*";

        preg_match_all('/' . $modifier . '|[0-9\.]+|\$[a-zA-Z0-9\_\.]+|[a-zA-Z0-9\_]+|===|!==|==|!=|\->|::|<=|>=|\*=|\+=|\/=|\-=|\%=|=|>|,|<|!|\(|\)|\.|\"[^\"]+\"|\'[^\']+\'|and|or|\&\&|\|\||%|\d+|\+|\-|\*|\/|gt|eq|lt/i', $expression, $matches);
        $expArr = $matches[0];
       
        //echo $expression;
          //  print_r( $matches[0] );
        self::$logger->debug("exp:" . var_export($expArr, true) );
        
        $newExp = "";
        for ($i = 0; $i < count($expArr); $i++)
        {
            $tag = $expArr[$i];
            if (substr($tag, 0, 1) == "$")
            {
                $newExp .= self::compileVar($tag); // ' $this->data[\'' . substr($tag, 1) . '\']';
            } elseif (substr($tag, 0, 2) == "eq")
            {
                $newExp .= "==";
            } elseif (substr($tag, 0, 2) == "gt" )
            {
                $newExp .= ">";
            } elseif (substr($tag, 0, 2) == "lt")
            {
                $newExp .= "<";
            }
            else
            {
                $newExp .= ' ' . $tag;
            }
        }
        
        return $newExp;
    }

    public function compileDocumentContent($content)
    {

        // $arr = array();
        //$arr_index = 0;
        $inString = false;
        $inWudimei = false;
        $inComment = false;
        $inIgnore = false;
		$inPHP = false;
		
        $strQuote = '"';
        $contentLength = strlen($content);
        $firstCharOfLeftDelimiter = $this->leftDelimiter[0];
        $firstCharOfRightDelimiter = $this->rightDelimiter[0];
        $leftDelimiterLength = strlen($this->leftDelimiter);
        $rightDelimiterLength = strlen($this->rightDelimiter);
        $wudimeiCode = "";
        //echo $code . "<br />";
        $html = "";
        for ($i = 0; $i < $contentLength; $i++)
        {
            $char = $content[$i];
            if ($inWudimei == false)
            {
                if ($char == $firstCharOfLeftDelimiter)
                {
                    if (substr($content, $i, $leftDelimiterLength ) == $this->leftDelimiter)
                    {
                        $inWudimei = true;
                        $i+= $leftDelimiterLength - 1;
                        //$html .= "<?php ";
                        $wudimeiCode = "";
                        if( $content[$i+1] == "*" )
                        {
                            $inComment = true;
                            //$html .= "\"comment\"";
                        }
                        continue;
                    }
                }

                $html .= $char;
            } else // $inWudimei == true
            {
                if ($inComment == false)
                {
                    if ($inString == false)
                    {
                        if ($char == $firstCharOfRightDelimiter)
                        {
                            if (substr($content, $i, $rightDelimiterLength ) == $this->rightDelimiter)
                            {
                                $inWudimei = false;
                                $i+= $rightDelimiterLength - 1;
                                 
                                if( trim( $wudimeiCode ) == "ignore" || trim( $wudimeiCode) == "literal" )
                                {
                                    $inIgnore = true;
                                    continue;
                                }
                                if( trim( $wudimeiCode ) == "/ignore" || trim( $wudimeiCode) == "/literal" )
                                {
                                    $inIgnore = false;
                                    continue;
                                }
								if( trim( $wudimeiCode) == "php" )
								{
									$inPHP = true;
									$html .= "<?php ";
									continue;
								}
								if( trim( $wudimeiCode) == "/php" )
								{
									$inPHP = false;
									$html .= " ?>";
									continue;
								}
								
                                if( $inIgnore == true )
                                {
                                    $html .= $this->leftDelimiter. $wudimeiCode . $this->rightDelimiter;
                                }
								if( $inPHP == true )
								{
									$html .= $this->leftDelimiter. $wudimeiCode . $this->rightDelimiter;
								}
                                else
                                {
                                    
                                    $html .= $this->selectCallback($wudimeiCode);
                                }
                                
                                continue;
                            }
                        }
                        if (in_array($char, array("\"", "'")))
                        {
                            $strQuote = $char;
                            $inString = true;
                           // $html .= $char;
                            //continue;
                        }
                        
                        
                    } else//in string
                    {
                        if ($char == "\\")
                        {
                            if( in_array( $content[$i+1], array( $strQuote , "t","b","n","r","\\","'","\"" ) ) )
                            {
                                
                                $wudimeiCode .= $char .$content[$i+1] ;
                                
                                $i++;
                                continue;
                            }
                        }
                        //string may end
                        if ($char == $strQuote)
                        {

                            $inString = false;
                        }
                    }
                    $wudimeiCode .= $char;
                }
                else // $inComment == true
                {
                    if( $char == "*" )
                    {
                       
                        if( $content[$i+1] == $firstCharOfRightDelimiter )
                        { 
                            if(substr( $content , $i+1, $rightDelimiterLength ) == $this->rightDelimiter )
                            {
                                $inComment = false;
                                //continue;
                                //echo "hi";echo substr( $content , $i+1, $rightDelimiterLength );
                            }
                        }
                    }
                }
            }
        }
        return $html;
    }

    public function fetch($Rong_View_File, $Rong_View_Data)
    {
        
        
    	$this->updateWudimeiSystemArray();
        /**
         * @var string compiled file name.
         */
        if (count(self::$varArray) > 0)
        {
            foreach (self::$varArray as $saKey => $saValue)
            {
                $this->data[$saKey] = $saValue;
            }
        }
		
		if( !empty($Rong_View_Data) )
		{
			foreach ($Rong_View_Data as $key => $value) {
				$this->data[$key] = $value;
			}
		}
		
        $distFileName = $this->compileDir . "/" . $Rong_View_File;
        $distDir = dirname($distFileName);
        if (!is_dir($distDir))
        {
            mkdir($distDir, 0777, true);
        }
        /**
         * @var string template file
         */
        $filePath = $this->getViewsDirectory() . "/" . $Rong_View_File;

        //use compiled template cache
        if ($this->forceCompile == false)
        {
            //template has  been modified,delete the compiled file
            if (filemtime($filePath) > filemtime($distDir))
            {
                @unlink($distFileName);
            }
            if (file_exists($distFileName))
            {

                ob_start();
                include( $distFileName );
                $output = ob_get_contents();
                ob_end_clean();
                $output .= $this->fetchParentView( $Rong_View_File,$Rong_View_Data );
                //echo "<br />cache " . filemtime( $distFileName ) . " ". $distFileName  ;
                return $output;
            }
        }

        if( !isset( $this->cachedTplFiles[ $Rong_View_File])){
            $content = file_get_contents($filePath);
            $content = $this->compileDocumentContent($content);
            file_put_contents($distFileName, $content);
            $this->cachedTplFiles[ $Rong_View_File] = 1;
        }
        
        $output = "";
        ob_start();
        include( $distFileName );
        $output = ob_get_contents();
        ob_end_clean();
        
        
        $output .= $this->fetchParentView( $Rong_View_File,$Rong_View_Data );
        return $output;
    }
    private function fetchParentView( $Rong_View_File,$Rong_View_Data ){
        $output = "";
        $parentView = $this->blocks[$Rong_View_File ]["parent"];
        if( isset( $parentView ) && trim( $parentView ) != "" ){
        
            $output .= $this->fetch( $parentView , $Rong_View_Data);
        }
        return $output;
    }

    public function display($Rong_View_File, $Rong_View_Data = array(), $Rong_View_Return = false)
    {
        foreach ($Rong_View_Data as $k => $v)
        {
            $this->data[$k] = $v;
        }

        if (count(self::$varArray) > 0)
        {
            foreach (self::$varArray as $saKey => $saValue)
            {
                $this->data[$saKey] = $saValue;
            }
        }

        $fileContent = $this->fetch($Rong_View_File, $Rong_View_Data);
        if ($Rong_View_Return == false)
        {
            echo $fileContent;
        } else
        {
            return $fileContent;
        }
    }
    
    public function blockDisplay($Rong_View_File, $name){
       // echo @$this->blocks[$name];
        echo @$this->blocks[$Rong_View_File]["blocks"][$name];
    }
    
    public function blockParent($Rong_View_File){
        $blockName = end( $this->blockNames );
         
        $viewName = $Rong_View_File;
        $ViewNameFound = $viewName;
        while( trim( $viewName ) != "" ){
            $parentViewName = $this->blocks[$viewName]["parent"];
            $blocks = $this->blocks[$parentViewName]["blocks"];
            if( isset( $blocks[ $blockName ])){
                $ViewNameFound = $parentViewName;
                break;
            }
            //echo $viewName;
            $viewName = $parentViewName;
        }
        echo @$this->blocks[$ViewNameFound]["blocks"][$blockName];
    }
    
    public function block_open( $Rong_View_File, $name ){
      
       if(!isset( $this->blocks[$Rong_View_File])){
           $this->blocks[$Rong_View_File] = array( "parent" =>"", "blocks" => array() ,"child" => "" );
       }
      // $this->blocks[$Rong_View_File]["curBlockName"] = $name;
      // $this->blocks[$Rong_View_File]["blocks"][$name] = "abc";
       array_push( $this->blockNames, $name); 
       ob_start();  
    }
    /**
     * 
     * @param unknown $viewFile $Rong_View_File
     */
    public function block_close($Rong_View_File){
        $c = ob_get_contents();
        ob_end_clean();
        
        $curBlockName = array_pop($this->blockNames);
        $this->blocks[$Rong_View_File]["blocks"][$curBlockName] = $c;
        
        $viewName = $Rong_View_File;
        $firstTimeDeclaredViewName = $viewName;
        while( trim( $viewName ) != "" ){
            $parentViewName = $this->blocks[$viewName]["parent"];
            $blocks = $this->blocks[$viewName]["blocks"];
            if( isset( $blocks[ $curBlockName ])){
                $firstTimeDeclaredViewName = $viewName;
            }
            //echo $viewName;
            $viewName = $parentViewName;
        }
      // echo $firstTimeDeclaredViewName .":". $curBlockName . " ";
        // print_r( $this->blocks );
        if( $firstTimeDeclaredViewName == $Rong_View_File ){
            //echo $c;
            $view2 =  $firstTimeDeclaredViewName;
            $viewFound = $view2;
            while( $view2 != ""){
                $blocks = @$this->blocks[$view2]["blocks"];
               // echo "[".$view2 . " = ";  foreach ( $blocks as $k=>$v ){ echo $k . ","; } echo "] ";
                
                if( isset( $blocks[$curBlockName])){
                    $viewFound = $view2;
                }
               // echo $view2. "--";
                $view2 = $this->getChildView( $view2 );
            }
           // echo $viewFound . ":" . $curBlockName . "<br />";
            $c2 = $this->blocks[ $viewFound ]["blocks"][$curBlockName];
            echo $c2;
        }
    }
    
    public function getChildView( $parentView ){
        $childView = "";
        if( isset( $this->blocks )){
            foreach ( $this->blocks as $v => $item ){
                if( $item["parent"] == $parentView ){
                    $childView = $v;
                }
            }
        }
        return $childView;
    }
    
    public function extendsView($Rong_View_File,$parentViewFile){
        
        $this->blocks[$Rong_View_File]["parent"] = $parentViewFile;
        if( $this->forceCompile == false ){
            $this->fetch( $parentViewFile, $this->data );
        }
    }
    
}