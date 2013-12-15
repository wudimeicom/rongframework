<?php
/*
 * Rong PHP Framework
 * author:Yang Qing-rong
 * Email : yaqy@qq.com yangqingrong@gmail.com
 * blog  : http://hi.baidu.com/tangtou
 * This is a free software under the GNU Licence.
 */
require_once 'Rong/Db/Interface.php';
abstract class Rong_DB_Abstract extends Rong_Object implements Rong_Db_Interface {
	public $fieldEscapeLeft = "";
	public $fieldEscapeRight = "";
	public $config = array();
	public function setConfig($config) {
		$this -> config = $config;
	}

	public function getConfig() {
		return $this -> config;
	}

	public function delete($table, $where) {
		$sql = "delete from " . $table . " where {$where}";
		$this -> query($sql);
		return $this -> affectedRows();
	}

	public function update($table, $data, $where) {
		$setArray = array();
		foreach ($data as $key => $value) {
			$setArray[] = $this -> fieldEscapeLeft . "{$key}" . $this -> fieldEscapeRight . " = '" . $this -> escape($value) . "'";
		}
		$sql = "update " . $table . " set " . implode(",", $setArray) . " where {$where}";
		$this -> query($sql);
		return $this -> affectedRows();
	}

	public function insert($table, $data) {
		$fields = array_keys($data);
		$values = array_values($data);

		for ($i = 0; $i < count($fields); $i++) {
			$fields[$i] = $this -> fieldEscapeLeft . $this -> escape($fields[$i]) . $this -> fieldEscapeRight;

			$values[$i] = "'" . $this -> escape($values[$i]) . "'";
		}
		$sql = "insert into {$table}(" . implode(",", $fields) . ") " . " values( " . implode(",", $values) . ");";
		$this -> query($sql);
		return $this -> insertId();
	}

	/**
	 * @param $sqlMixed array|string string:sql string,array:element 0is sql,element 1 is record count sql
	 */
	public function limit($sqlMixed, $page, $pageSize) {
		$page = (intval($page) == 0) ? 1 : intval($page);
		$pageSize = intval($pageSize) == 0 ? 10 : intval($pageSize);

		$start = ($page - 1) * $pageSize;

		$sql = "";
		$sqlCount = "";
		if (is_string($sqlMixed) == true) {
			$sql = $sqlMixed;
			$sqlCount = "select count(*) count from (" . $sql . ") n";
		}
		elseif (is_array($sqlMixed)) {
			$sql = $sqlMixed[0];
			$sqlCount = $sqlMixed[1];
		}

		$sqlAll = $sql . " limit " . $start . "," . $pageSize . ";" . $sqlCount;
		$rows = $this -> call($sqlAll);
		//print_r( $rows );
		$RecordCount = 0;
		if( isset( $rows[1][0]) &&!empty($rows[1][0]) )
		{
			foreach($rows[1][0] as $k=> $v)
			{
				$RecordCount=$v;
			}
		}
		$PageCount = ceil($RecordCount / $pageSize);
		$Prev = ($page - 1) > 1 ? ($page - 1) : 1;
		$Next = ($page + 1) > $PageCount ? $PageCount : ($page + 1);
		$result = array(
			"Data" => $rows[0],
			"PaginationData" => array(
				"Page" => $page,
				"First" => 1,
				"Last" => $PageCount,
				"Next" => $Next,
				"Prev" => $Prev,
				"PageCount" => $PageCount,
				"PageSize" => $pageSize,
				"RecordCount" => $RecordCount
			)
		);
		return $result;
	}

	public function getPaginator($sql, $page, $pageSize, $urlTemplate, $paginatorSettings = array()) {
		$data = $this -> limit($sql, $page, $pageSize);
		require_once 'Rong/Html/Paginator.php';
		$pagePaginator = new Rong_Html_Paginator($data["PaginationData"]);
		$pagePaginator -> setSettingsArray($paginatorSettings);
		$data["PaginatorHtml"] = $pagePaginator -> getPaginatorHtml($urlTemplate);
		return $data;
	}

	public function fetchRow($sql) {
		$rows = $this -> fetchAll($sql);
		return @$rows[0];
	}

	/**
	 *
	 * @param string $str
	 * @param string $type  ""|"GET"|"POST"
	 * @return string
	 */
	public function antiSqlInjection($str, $type = "") {
		$type = strtoupper($type);
		if ($type == "") {
			if (!empty($_POST)) {
				$type = "POST";
			}
			else {
				$type = "GET";
			}
		}

		if ($type == "POST") {

			echo "post";
			print_r(json_encode($_POST));
			$str = stripslashes($str);
			$str = str_replace("|", "&#124;", $str);
			$str = str_replace("<", "&#60;", $str);
			$str = str_replace(">", "&#62;", $str);
			$str = str_replace("&nbsp;", "&#32;", $str);
			$str = str_replace(" ", "&#32;", $str);
			$str = str_replace("(", "&#40;", $str);
			$str = str_replace(")", "&#41;", $str);
			$str = str_replace("`", "&#96;", $str);
			//$str = str_replace("'", "&#39;", $str);
			$str = str_replace('"', "&#34;", $str);
			$str = str_replace(",", "&#44;", $str);
			$str = str_replace("$", "&#36;", $str);
			$str = str_replace("", "&#92;", $str);
			$str = str_replace("/", "&#47;", $str);

		}
		else {
			//$str = stripslashes($str);
			$str = str_replace("_", "\_", $str);
			$str = str_replace("%", "\%", $str);
			$str = str_replace("&#92;", "", $str);
			$str = str_replace("&#47;", "/", $str);
			$str = str_replace("&#32;", " ", $str);
			$str = str_replace("&#44;", ",", $str);
			$str = str_replace("&#39;", "'", $str);
			$str = str_replace("#39;", "'", $str);

			$str = preg_replace_callback("/([&]?#[0-9a-zA-Z]+;)|(&[a-zA-Z0-9]+;)/i", array(
				$this,
				"replaceHtmlSpecialChars"
			), $str);
			$str = str_replace(";", "", $str);
			$str = str_replace("`", "", $str);
			$str = str_replace("#", "", $str);
		}
		return $str;
	}

	private function replaceHtmlSpecialChars($matches) {
		preg_match_all("/([a-zA-Z0-9]+)/i", $matches[0], $arr);
		$chars = array(
			"nbsp" => " ",
			"39" => "'",
			"lt" => "<",
			"gt" => ">",
			"quot" => "'",
			"amp" => "&",
			"apos" => "'"
		);

		return @$chars[$arr[0][0]];
	}

}
?>