<?php
/**
 * file encoding utf-8
 * 文件字符编码utf-8
 */
$PathToRongFramework = dirname(__FILE__) . "/../lib";

set_include_path("." . PATH_SEPARATOR . $PathToRongFramework . PATH_SEPARATOR . get_include_path());

require_once 'Rong/Acl.php';
$acl = new Rong_Acl();

/*
 *  + - guest                      
 *       + - customer             + - article_editor
 *            +----  super_admin 
 */
$acl -> addRole(new Rong_Acl_Role("GUEST",			"guest account"						));
$acl -> addRole(new Rong_Acl_Role("CUSTOMER",		"customer", 		array("GUEST")	));
$acl -> addRole(new Rong_Acl_Role("ARTICLE_EDITOR",	"article editor"					));
$acl -> addRole(new Rong_Acl_Role("SUPER_ADMIN", 	"super admin", 		array("CUSTOMER", "ARTICLE_EDITOR")));
 

/*
 *  +- news   +- events
 *     +- article
 */
$acl -> addResource(new Rong_Acl_Resource("NEWS",		"news"));
$acl -> addResource(new Rong_Acl_Resource("EVENTS",		"events"));
$acl -> addResource(new Rong_Acl_Resource("ARTICLE",	"article", array("NEWS","EVENTS")));


$acl -> addAccount(new Rong_Acl_Account("YAQY","yaqy"));
$acl -> addAccount(new Rong_Acl_Account("YANGQINGRONG","yangqingrong", array("GUEST", "ARTICLE_EDITOR")));


echo '--------- grant ARTICLE_EDITOR add,delete,edit,read news<br />';
echo '--------- grand GUEST read news<br />';

$acl -> allow("ARTICLE_EDITOR", "NEWS", array("add", "delete", "edit","read"));
$acl -> allow("GUEST", "NEWS", array("read"));

showAcl("GUEST", "NEWS", "read" , "001" );
showAcl("GUEST", "NEWS", "delete" , "001.2");
showAcl("ARTICLE_EDITOR", "NEWS", "delete" , "001.3");
showAcl("SUPER_ADMIN","NEWS","delete", "005");

echo '--------- deny ARTICLE_EDITOR to delete,edit news<br />';
$acl -> deny("ARTICLE_EDITOR", "NEWS", array("delete", "edit"));
showAcl("ARTICLE_EDITOR", "NEWS", "read" , "002");
showAcl("ARTICLE_EDITOR", "NEWS", "delete" , "003");
showAcl("SUPER_ADMIN","NEWS","read", "004");
showAcl("SUPER_ADMIN","NEWS","delete", "005");

echo '--------- grant SUPER_ADMIN to delete  news<br />';
$acl -> allow("SUPER_ADMIN", "NEWS", array("delete"));
showAcl("SUPER_ADMIN","NEWS","edit", "006");
showAcl("SUPER_ADMIN","NEWS","delete", "006");
showAcl("ARTICLE_EDITOR", "NEWS", "delete" , "007");
showAcl("GUEST", "NEWS", "delete" , "008");
showAcl("CUSTOMER", "NEWS", "delete" , "009");


/*
$aclString = serialize($acl);
echo $aclString;
$newObj = unserialize($aclString);
print_r($newObj);

$acl = $newObj;
echo "<br />";
showAcl("SUPER_ADMIN","NEWS","delete");
showAcl("ARTICLE_EDITOR", "NEWS", "delete" );
showAcl("GUEST", "NEWS", "delete" );
showAcl("CUSTOMER", "NEWS", "delete" );
 * 
 */


function showAcl( $roleId , $resourceId , $operation , $code  )
{
	global $acl;
	if ($acl -> isAllowed($roleId, $resourceId, $operation)) {
		echo $code . " ". $roleId." is allowed to $operation $resourceId(允许$roleId $operation $resourceId)<br />";
	}
	else{
		echo $code . " ". $roleId." is not allowed to $operation $resourceId(不允许$roleId $operation $resourceId)<br />";
	}
}