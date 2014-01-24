<?php
require_once 'Rong/Html/Select.php';
require_once 'Rong/Html/Radios.php';
require_once 'Rong/Html/Checkboxes.php';
/**
 * selectedValue="id_1"
 * from=$fruits
 */
 
function  wudimei_tag_HtmlSelect( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList($strAttributes );
    $from = Rong_View_Wudimei::compileExpression($attrs["from"]);
    $selectedValue = Rong_View_Wudimei::compileExpression($attrs["selectedValue"]);  
	$from = trim( $from,'@ ');  
	$selectedValue = trim( $selectedValue,'@ ');

	 
	$code = '
	$select = new Rong_Html_Select();
	$select->setOptions('. $from .');
	$select->setSelectedValue('. $selectedValue.');';
	 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','selectedValue')) === false )
		{
			$code .= '$select->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $select->toHtml();  ';
	
    return $code;
	 
}


function  wudimei_tag_HtmlRadioButtons( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList($strAttributes );
    $from = Rong_View_Wudimei::compileExpression($attrs["from"]);
    $selectedValue = Rong_View_Wudimei::compileExpression($attrs["checkedValue"]);  
	$separator = Rong_View_Wudimei::compileExpression($attrs["separator"]);  
	$from = trim( $from,'@ ');  
	$selectedValue = trim( $selectedValue,'@ ');
	
	 
	$code = '
	$radios = new Rong_Html_Radios();
	$radios->setOptions('. $from .');
	$radios->setCheckedValue('. $selectedValue.');
	$radios->setSeparator('.$separator.');';
 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','checkedValue','separator')) === false )
		{
			$code .= '$radios->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $radios->toHtml();  ';
	
    return $code;
	 
}



function  wudimei_tag_HtmlCheckboxes( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList($strAttributes );
    $from = Rong_View_Wudimei::compileExpression($attrs["from"]);
    $selectedValue = Rong_View_Wudimei::compileExpression($attrs["checkedValues"]);  
	$separator = Rong_View_Wudimei::compileExpression($attrs["separator"]);  
	$from = trim( $from,'@ ');  
	$selectedValue = trim( $selectedValue,'@ ');
	
	 
	$code = '
	$checkboxes = new Rong_Html_Checkboxes();
	$checkboxes->setOptions('. $from .');
	$checkboxes->setCheckedValues('. $selectedValue.');
	$checkboxes->setSeparator('.$separator.');';
 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','checkedValue','separator')) === false )
		{
			$code .= '$checkboxes->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $checkboxes->toHtml();  ';
	
    return $code;
	 
}

 
