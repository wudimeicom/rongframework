<?php

$config["site_root"] = "http://" . $_SERVER["SERVER_NAME"] . "";  //eg http://wudimei.com   http://wudimei.com/main
$config["url_prefix_of_controller"] = "/index.php"; //eg: [/index.php](/Article/index) [/index.php?do=](/Article/index) [null](/Article/index)

$config["database"] = array(
    "default" => array(
        "host" => "127.0.0.1",
        "dbname" => "rong_db",
        "username" => "root",
        "password" => "123456", //password of database
        "charset" => "utf8",  //or latin1 gbk and so on
        "table_prefix" => "w_",
        "adapter" => "Mysqli"  //or Mysql Sqlite Pg Oci8 Mssql
    )
);
$config["enable_dev"] = true; //turn it to false in production enviroment
$config["enable_sql_debug"] = false;
?>