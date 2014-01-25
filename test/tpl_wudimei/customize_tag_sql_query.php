<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
 
$PathToRongFramework = dirname(__FILE__)."/../../lib";

set_include_path(  "." . PATH_SEPARATOR . $PathToRongFramework .  PATH_SEPARATOR . get_include_path() );

require_once 'Rong/View/Wudimei.php';
$wudimei = new Rong_View_Wudimei();
$wudimei->compileDir = dirname(__FILE__) . "/templates/compiled";
$wudimei->viewsDirectory = dirname(__FILE__) .  "/templates";

$wudimei->leftDelimiter = "{";
$wudimei->rightDelimiter = "}";
$wudimei->forceCompile = true;

function execute_query( $sql )
{
	$sql = str_replace("[TablePrefix]", "w_", $sql );
	$conn = mysql_connect("localhost","root","123456");
	mysql_select_db("rong_db");
	$rows = array();
	$query = mysql_query($sql);
	while ($row = mysql_fetch_assoc( $query)) {
		$rows[] = $row;
	}
	return $rows;
}

function  wudimei_tag_query( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromText($strAttributes, "sql,item");
    $sql = Rong_View_Wudimei::compileExpression($attrs["sql"]);
    $item = Rong_View_Wudimei::compileExpression($attrs["item"]);  
	
	$item = trim( $item,'@ ');
	
	
	$code = '$this->data["queryResult"]=execute_query(' . $sql . ');';
	$from = '$this->data["queryResult"]';
    $code .= ' foreach( ' . $from . ' as ' .   $item  . ' ){';
	return $code; 
}



function wudimei_tag_query_end( ){
	return '}';
}



 
$wudimei->display("hello/customize_tag_sql_query.html");

