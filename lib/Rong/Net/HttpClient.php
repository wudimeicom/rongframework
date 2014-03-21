<?php
/**
 *
 * HTTP Client class enable you conect to web easily
 * @author Yang Qing-rong	yangqingrong@gmail.com
 *
 */
 require_once 'Rong/Object.php';
 require_once 'Rong/Logger.php';
 
class Rong_Net_HttpClient extends Rong_Object {
	public $headers = array();
	public $responseText;
	public $errorNumber;
	public $errorString;
	public $cookieDir;
	/**
	 *@var string cookie text, "Cookie: {$cookieData}\r\n",if is set,the local cookie will be replaced */
	public $cookieData;
	
	public $currentHost;
	/**
	 * @var array file array
	 */
	public $fileArray = array();
	public $fileContentType = "multipart/mixed";


	public $logger;
	public function __construct() {
		parent::__construct();
		$this -> headers = array("Content-Type" => "text/html;charset=utf-8");
		$this->logger =  Rong_Logger::getLogger();
	}
	
	
	
	public function setCookieData($data) {
		$this -> cookieData = $data;
	}



	public function getCookieData() {
		return $this -> cookieData;
	}



	/**
	 * @return string the $cookieDir
	 */
	public function getCookieDir() {
		return $this -> cookieDir;
	}
	
	
	
	/**
	 * @param string $cookieDir
	 */
	public function setCookieDir($cookieDir) {
		$this -> cookieDir = $cookieDir;
	}
	
	
	
	/**
	 *
	 * @param string $name  eg: "file"  or "file[0]","file[1]","file[2]"....
	 * @param string $file
	 */
	public function addFile($name, $file) {
		if( file_exists( $file ) == true )
		{
			$this -> fileArray[$name] = $file;
		}
		else{
			$this->logger->error("file \"" . $file . "\" not found!");
		}
	}



	/**
	 *
	 * Enter description here ...
	 * @param string $url
	 * @param string $method "GET"|"POST"
	 * @param unknown_type $paramArray
	 */
	public function request($url, $method = "GET", $postArray = array( )) {
		$urlArray = parse_url($url);
		$this -> currentHost = $urlArray["host"];

		if( !isset($urlArray["host"]) )
		{
			 
			$this->logger->fatal("host name can not be null,please check your url.");
			return false;
		}
		if( in_array( $method, array("GET","HEAD","POST","PUT","DELETE","TRACE"," OPTIONS")) == false )
		{
			$this->logger->warn("method \"" . $method."\" is not supported!");
		}
		 
		$CRLF = "\r\n";

		$postText = "";
		$boundary = "";
		if (!empty($this -> fileArray))//upload
		{
			$boundary = "------" . md5(uniqid());
			$postText .= "--" . $boundary . "\r\n";

			if (!empty($postArray)) {
				foreach ($postArray as $key => $val) {
					$postText .= "Content-Disposition: form-data; name=\"" . $key . "\"\r\n\r\n";
					$postText .= $val . "\r\n";
					$postText .= "--" . $boundary . "\r\n";
				}
			}
			if (!empty($this -> fileArray)) {
				foreach ($this->fileArray as $name => $file) {
					$postText .= "Content-Disposition: form-data; name=\"" . $name . "\"; filename=\"" . basename($file) . "\"\r\n";
					$postText .= "Content-Type: " . $this -> fileContentType . "\r\n\r\n";
					$postText .= file_get_contents($file) . "\r\n";
					$postText .= "--" . $boundary . "\r\n";
				}
			}
			$postText .= "--\r\n\r\n";
		} else {
			$postItem = array();
			if (!empty($postArray)) {
				foreach ($postArray as $key => $val) {
					$postItem[] = urlencode($key) . "=" . urlencode($val);
				}
			}
			$postText = implode("&", $postItem);
		}
		if (!isset($urlArray["port"]) || $urlArray["port"] == "") {
			$urlArray["port"] = 80;
		}
		$text = $method . " " . $urlArray["path"];
		if (trim(@$urlArray["query"]) != "") {
			$text .= "?" . $urlArray["query"];
		}
		$text .= " HTTP/1.1" . $CRLF;
		$text .= "Host: " . $urlArray["host"] . $CRLF;
		$text .= "User-Agent: wudimei.com" . $CRLF;
		
		
		if (trim($this -> cookieData) != "") {
			$cookie = "Cookie: " . $this -> cookieData . "\r\n";
		}
		else{
			$cookie = $this -> getLocalCookies();
		}
		
		$text .= $cookie;
		// $text .= "Cookie: name=yangqingrong; age=25 years old; PHPSESSID=ao6pesjilvemgbbd6jffnu5m91" . $CRLF;
		if (isset($urlArray["query"])) {
			$text .= "Query: " . @$urlArray["query"] . $CRLF;
		}

		if ($method == "POST" && trim($postText) != "") {
			$text .= "Connection: Close" . $CRLF;
			if (!empty($this -> fileArray)) {
				$text .= "Content-Type: multipart/form-data; boundary=" . $boundary . $CRLF;
			} else {
				$text .= "Content-Type: application/x-www-form-urlencoded" . $CRLF;
			}
			$text .= "Content-length: " . strlen($postText) . $CRLF . $CRLF;
			$text .= $postText;
		} else {
			$text .= "Connection: Close" . $CRLF . $CRLF;
			$text .= "Content-length: " . strlen($postText) . $CRLF . $CRLF;
		}

		if (isset($GLOBALS["debug"])) {
			echo "<br />---{Rong_Net_HttpClient \$text}---------<br /><textarea rows=\"5\" cols=\"50\">";
			echo $text;
			echo "</textarea><br />---{/Rong_Net_HttpClient \$text}---------<br />";
		}
		$fp = fsockopen($urlArray["host"], $urlArray["port"], $this -> errorNumber, $this -> errorString);
		fwrite($fp, $text);

		$response = "";
		while (!feof($fp)) {
			$response .= $t = fread($fp, 1024);
			 
		}

		fclose($fp);

		if (isset($GLOBALS["debug"])) {
			echo "<br />---{Rong_Net_HttpClient \$response}---------<br /><textarea rows=\"5\" cols=\"50\">";
			echo $response;
			echo "</textarea><br />---{/Rong_Net_HttpClient \$response}---------<br />";
		}
		$this -> responseText = $response;
		$this -> saveCookies();
		return $this -> responseText;
	}

	private function getLocalCookies() {

		if (trim($this -> getCookieDir()) == "") {
			$this->logger->warn("\$cookieDir is null,get no cookies.");
			return null;
		}
		$cookieText = "Cookie: ";
		$cookieFile = $this -> getCookieDir() . "/" . $this -> currentHost . ".cookie.inc";
		if (file_exists($cookieFile)) {
			include $cookieFile;
			if (isset($cookieArray) && !empty($cookieArray)) {
				for ($i = 0; $i < count($cookieArray); $i++) {
					$cookieText .= $cookieArray[$i]["name"] . "=" . $cookieArray[$i]["value"] . "; ";

				}
			}
		}
		$cookieText .= "\r\n";
		return $cookieText;
	}

	private function saveCookies() {
		if (trim($this -> getCookieDir()) == "") {
			$this->logger->warn("\$cookieDir is null,no place to store cookies.");
			return false;
		}
		$headerLen = strpos($this -> responseText, "\r\n\r\n");
		$headerText = substr($this -> responseText, 0, $headerLen);
		//echo $headerText;
		preg_match_all("/Set-Cookie:(.+)\r\n/i", $headerText, $matches);
		$cookies = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$cookieLine = $matches[1][$i];
			$cookieItems = explode(";", $cookieLine);
			$firstKv = explode("=", $cookieItems[0]);
			$name = trim($firstKv[0]);
			$value = trim($firstKv[1]);
			$cookies[$i] = array("name" => $name, "value" => $value);
			for ($j = 1; $j < count($cookieItems); $j++) {
				$cookieKV = explode("=", $cookieItems[$j]);

				$cookies[$i][trim($cookieKV[0])] = trim($cookieKV[1]);
			}
		}
		//print_r( $cookies );
		$newCookies = array();
		$cookieFile = $this -> getCookieDir() . "/" . $this -> currentHost . ".cookie.inc";
		if (file_exists($cookieFile)) {
			include $cookieFile;
			// $cookieArray
			$newCookies = @$cookieArray;
		}
		for ($i = 0; $i < count($cookies); $i++) {
			$found = false;
			$foundJ = -1;
			for ($j = 0; $j < count($newCookies); $j++) {
				if ($cookies[$i]["name"] == $newCookies[$j]["name"] && $cookies[$i]["path"] == $newCookies[$j]["path"]) {
					$foundJ = $j;
					$found = true;
				}
			}
			if ($found == true) {
				$newCookies[$foundJ] = $cookies[$i];
			} else {
				$newCookies[] = $cookies[$i];
			}
		}

		$cookieContent = "<?php \$cookieArray=" . var_export($newCookies, true) . "; ?>";
		file_put_contents($cookieFile, $cookieContent);
	}

	public function getHeader() {
		//Transfer-Encoding: chunked
		return substr($this -> responseText, 0, strpos($this -> responseText, "\r\n\r\n"));
	}

	public function getContent() {
		$header = $this -> getHeader();
		//echo "[" . $header . "]";
		if (strpos($header, "Transfer-Encoding: chunked") !== false) {
			$chunkContent = substr($this -> responseText, strpos($this -> responseText, "\r\n\r\n") + 4);

			//echo $chunkContent;
			$content = "";
			$strLen = strlen($chunkContent);
			for ($i = 0; $i < $strLen; $i++) {
				$rnPos = strpos($chunkContent, "\r\n", $i);
				$hexNum = substr($chunkContent, $i, $rnPos - $i);
				$num = hexdec($hexNum);
				//if( $num =0 ) break;
				// echo "[$hexNum:$num]";
				if ($num > 0) {
					
					$content .= substr($chunkContent, $i + strlen($hexNum), $num + 2);
				}
				$i += strlen($hexNum) + 2 + $num + 1;
				
			}
			
			return $content;
			
		} else {
			$cnt = substr($this -> responseText, strpos($this -> responseText, "\r\n\r\n") + 4);

			return $cnt;
		}
	}

}
