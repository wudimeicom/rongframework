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
	
	$options = Rong_View_Wudimei::compileExpression($attrs["options"]);
    if( !isset( $attrs["options"] )) $options = Rong_View_Wudimei::compileExpression($attrs["from"]);
	$selectedValue = Rong_View_Wudimei::compileExpression($attrs["selected"]);
    if( !isset( $attrs["selected"] )) $selectedValue = Rong_View_Wudimei::compileExpression($attrs["selectedValue"]);  
	$options = trim( $options,'@ ');  
	$selectedValue = trim( $selectedValue,'@ ');

	 
	$code = '
	$select = new Rong_Html_Select();
	$select->setOptions('. $options .');
	$select->setSelectedValue('. $selectedValue.');';
	 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','selectedValue','options','selected')) === false )
		{
			$code .= '$select->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $select->toHtml();  ';
	
    return $code;
	 
}


function  wudimei_tag_HtmlRadios( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList($strAttributes );
    
    $options = Rong_View_Wudimei::compileExpression($attrs["options"]);
	$checked = Rong_View_Wudimei::compileExpression($attrs["checked"]); 
	
	if( !isset( $attrs["options"] )) $options = Rong_View_Wudimei::compileExpression($attrs["from"]);
    if( !isset( $attrs["checked"] ) ) $checked = Rong_View_Wudimei::compileExpression($attrs["checkedValue"]);  
	
	$separator = Rong_View_Wudimei::compileExpression($attrs["separator"]);  
	$options = trim( $options,'@ ');  
	$checked = trim( $checked,'@ ');
	
	 
	$code = '
	$radios = new Rong_Html_Radios();
	$radios->setOptions('. $options .');
	$radios->setCheckedValue('. $checked .');
	$radios->setSeparator('.$separator.');';
 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','checkedValue','separator','options','checked')) === false )
		{
			$code .= '$radios->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $radios->toHtml();  ';
	
    return $code;
	 
}
function  wudimei_tag_HtmlRadioButtons( $strAttributes)
{
	return wudimei_tag_HtmlRadios( $strAttributes);
}


function  wudimei_tag_HtmlCheckboxes( $strAttributes)
{
	$attrs = array();
    $attrs = Rong_View_Wudimei::getAttributesArrayFromTextWithOutNameList($strAttributes );
	
    $options = Rong_View_Wudimei::compileExpression($attrs["options"]);
    $checked = Rong_View_Wudimei::compileExpression($attrs["checked"]);  
	
	if( !isset( $attrs["options"] )) $options = Rong_View_Wudimei::compileExpression($attrs["from"]);
    if( !isset( $attrs["checked"] ) ) $checked = Rong_View_Wudimei::compileExpression($attrs["checkedValues"]);  
	
	
	$separator = Rong_View_Wudimei::compileExpression($attrs["separator"]);  
	$options = trim( $options,'@ ');  
	$checked = trim( $checked,'@ ');
	
	 
	$code = '
	$checkboxes = new Rong_Html_Checkboxes();
	$checkboxes->setOptions('. $options .');
	$checkboxes->setCheckedValues('. $checked.');
	$checkboxes->setSeparator('.$separator.');';
 
	foreach( $attrs as $k => $v )
	{
		 $v2 = Rong_View_Wudimei::compileExpression($v);
		if( in_array($k, array('from','checkedValue','separator','options','checked')) === false )
		{
			$code .= '$checkboxes->set("' . $k.'",' . $v2 .');'."\r\n";
		}
	}
	
	$code .= 'echo $checkboxes->toHtml();  ';
	
    return $code;
	 
}

 
