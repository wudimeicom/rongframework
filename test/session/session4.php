<?php
Rong_Session::put("addresses",[["id"=>123,"name"=>"jiba"]]);
Rong_Session::put("name","yqr");
Rong_Session::put("name2","yqr2");
Rong_Session::put("name3","yqr3");
Rong_Session::delete("name2");
print_r( $_COOKIE );
echo session_id();
