<?php
/**
 * @return Rong_View_Wudimei Description
 */
require_once 'Rong/Db.php';
require_once 'Rong/Db/Model.php';

/**
 * 
 * @return \Rong_View_Wudimei
 */
function load_wudimei()
{
    require_once 'Rong/View/Wudimei.php';
    $wudimei = new Rong_View_Wudimei();
    $wudimei->compileDir = ROOT . "/data/compiled";

    $wudimei->viewsDirectory = ROOT . "/application/views";
    $wudimei->leftDelimiter = "{";
    $wudimei->rightDelimiter = "}";
    return $wudimei;
}

/**
 * 
 * @global array $config
 * @return Rong_Db_Driver_Mysqli
 */
function load_database( $section = "default")
{
    $db = Rong_Db::factory( config("database.".$section.".adapter") ,  config("database.".$section) );
    Rong_Db_Model::setDefaultDb( $db );
    return $db;
}
?>
