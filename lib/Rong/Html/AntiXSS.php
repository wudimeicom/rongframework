<?php
class Rong_Html_AntiXSS {

	public $allowedTags = array("a", "table", "tbody", "tr", "td", "th", "div", "span", "label", "p", "body", "img", "canvas", "abbr", "address", "area", "article", "aside", "audio", "b", "base", "basefont", "bdo", "big", "blockquote", "br", "button", "center", "cite", "code", "col", "colgroup", "command", "datalist", "dd", "del", "details", "dfn", "dir", "dl", "dt", "em", "embed", "fieldset", "figcaption", "figure", "font", "footer", "form", "frame", "frameset", "h1", "h2", "h3", "h4", "h5", "h6", "head", "header", "hgroup", "html", "i", "iframe", "input", "ins", "keygen", "isindex", "kbd", "legend", "li", "link", "map", "mark", "menu", "meta", "meter", "nav", "noframes", "ol", "optgroup", "option", "output", "param", "pre", "progress", "q", "section", "select", "small", "source", "strike", "strong", "sub", "summary", "sup");

	public $allowedAttributes = array("name", "value", "type", "href", "class", "width", "height", "color", "bgcolor", "style", "target", "id", "tabindex", "repeat", "acceskey", "contenteditable", "contentextmenu", "dir", "draggable", "irrelevant", "lang", "ref", "title", "selected", "checked", "alt");

	//public $allowedJavascript = false;

	public function removeXSS($text) {
		
		
		$inTag = false;
		$needRemove = false;
		$tagsToRemove = array();
		$allowedTags = array();
		$row = array();
		for ($i = 0; $i < strlen($text); $i++) {
			$ch = substr($text, $i, 1);
			if ($ch == "<") {
				$inTag = true;
				$row["start"] = $i;
				$tagName = $this -> getTagName($text, $i);
				$tagName = trim($tagName, "\/");
				if (array_search($tagName, $this -> allowedTags) === false)//not allowed tag
				{
					$needRemove = true;
				} else {
					$needRemove = false;

				}
				$i += strlen($tagName);
				continue;
			}

			if ($ch == ">") {
				$inTag = false;
				$row["end"] = $i;
				if ($needRemove == true) {
					$tagsToRemove[] = $row;
				} else {
					$allowedTags[] = $row;
				}
			}
		}

		for ($i = 0; $i < count($tagsToRemove); $i++) {
			$r = $tagsToRemove[$i];
			$s = $r["start"];
			$e = $r["end"];
			for ($j = $s; $j < $e + 1; $j++) {
				$text[$j] = "";
			}
		}

		for ($i = 0; $i < count($allowedTags); $i++) {
			$r = $allowedTags[$i];
			$s = $r["start"];
			$e = $r["end"];
			$text = $this -> removeEvilAttributes($text, $s, $e);
		}
		return $text;
	}

	private function removeEvilAttributes($text, $s, $e) {
		
		$str = substr($text, $s + 1, $e - $s - 1);
		//echo $str . "\n";
		
		if (strpos($str, "\n") == false && strpos($str, " ") == false && strpos($str, "\r\n") == false && strpos($str, "\t") == false) {
			return $text;
		} else {
			if (isset($GLOBALS["debug"]))
				echo "str:" . $str . "\n";

			$len = strlen($str);
			$inStr = false;
			$tokens = array();
			$start = $end = 0;
			$tokenStr = "";
			$quote = "";
			for ($i = $s; $i < $e; $i++) {
				$ch = $text[$i];
				if ($ch == " " || $ch == "\t" || $ch == "\n" || $ch . @$str[$i + 1] == "\r\n") {

					if ($inStr == false) {
						if (isset($GLOBALS["debug"]))
							echo $tokenStr . "--\n";
						$end = $i;
						$tokens = $this -> addToTokensArray($tokens, $tokenStr, $start, $end);
						$start = $i;
						$tokenStr = "";
					}

				}
				if ($inStr == false && $ch == "=") {

					if (isset($GLOBALS["debug"]))
						echo $tokenStr . "--\n";
					$end = $i;
					$tokens = $this -> addToTokensArray($tokens, $tokenStr, $start, $end);
					$start = $i;

					$end = $i;
					$tokens = $this -> addToTokensArray($tokens, "=", $start, $end);
					$start = $i;
					if (isset($GLOBALS["debug"]))
						echo "=";
					$tokenStr = "";
					continue;
				}

				if ($inStr == false && ($ch == "'" || $ch == "\"")) {
					$inStr = true;
					$quote = $ch;
					continue;
				}

				if ($inStr == true && $ch == $quote) {
					$inStr = false;
					if (isset($GLOBALS["debug"]))
						echo $tokenStr . "--\n";
					$end = $i;
					$tokens = $this -> addToTokensArray($tokens, $tokenStr, $start, $end);
					$start = $i;
					$tokenStr = "";
					continue;
				}
				$tokenStr .= $ch;

			}
			if (isset($GLOBALS["debug"]))
				echo $tokenStr . "--\n";
			$end = $i-1;
			$tokens = $this -> addToTokensArray($tokens, $tokenStr, $start, $end);
			$start = $i;

			//print_r($tokens);
			for ($i = 0; $i < count($tokens); $i++) {
				$t = $tokens[$i];
				$strVal = strtolower(trim($t[0]));

				if (isset($tokens[$i + 1][0]) && strtolower(trim($tokens[$i + 1][0])) == "=") {
					$val = @$tokens[$i + 2][0];
					
					$hasXSS = false;
					if ($strVal == "href" || $strVal == "src") {
						$val = preg_replace("/([\s\t]+)/i", "", $val );
						$val = str_replace("\t", "", $val );
						$val = str_replace("\\r", "", $val );
						$val = str_replace("\\n", "", $val );
						
						if (preg_match("/j[\s]*a[\s]*v[\s]*a[\s]*s[\s]*c[\s]*r[\s]*i[\s]*p[\s]*t[\s]*/i", $val )) {
							//echo $t[0] . "--";
							
							$hasXSS = true;
						}
					}

					if ($strVal == "style") {
						if (preg_match("/expression/i", $tokens[$i + 2][0])) {
							//echo $t[0] . "--";
							$hasXSS = true;
						}
					}
					
					if( in_array( $strVal , $this->allowedAttributes) ==  false )
					{
						$hasXSS = true;
						
					}
					if( $hasXSS )
					{
						for( $j= $tokens[ $i][1]+1; $j<= $tokens[ $i+2][2]; $j++ )
						{
								$text[$j] = "";
						}
					}
				}

			}
			return $text;
		}
	}

	private function addToTokensArray($tokens, $str, $start, $end) {
		if (trim($str) != "") {
			$tokens[] = array($str, $start, $end);
		}
		return $tokens;
	}

	protected function getTagName($text, $offset) {
		$blank = strpos($text, " ", $offset);
		$rn = strpos($text, "\r\n", $offset);
		$n = strpos($text, "\n", $offset);
		$t = strpos($text, "\t", $offset);
		$tag = strpos($text, ">", $offset);

		$min = 100000000;
		if ($blank > 0 && $blank < $min)
			$min = $blank;
		if ($rn > 0 && $rn < $min)
			$min = $rn;
		if ($n > 0 && $n < $min)
			$min = $n;
		if ($t > 0 && $t < $min)
			$min = $t;
		if ($tag > 0 && $tag < $min)
			$min = $tag;

		return substr($text, $offset + 1, $min - $offset - 1);
	}

}

 
 /*
$text = '<span>杨庆荣abc</span>
<script type="text/javascript">alert("hello");</script>
<script type=text/javascript>alert("hello");</script>
<script>alert("hello");</script>
jiba
<style		type="text/css">a{ color:green; }</style>

<table>
<tr><th>name</th></tr>
<tr><td>Yang Qing-rong</td></tr>
</table>

<a id=  \'yqr\' href		=  "java Scr
ipt:	alert(\'  hello 		\');  "  name	=	name onclick 	= "alert(\'hello\')" >click me</a>
<span style = "cursor: eXpression ( document.write(\'hello\' ) ) " selected id=33	age  	= 12>Hello,world</span>
<img Src= "javas		cript:alert(\'jiba\');" />
<a href="javascrip t:  		alert(\'hello\')">ff</a>
<a href="http://www.wudimei.com">wudimei.com</a>
';
 

$xss = new Rong_Html_AntiXSS();
echo $xss -> removeXSS($text); 
*/
