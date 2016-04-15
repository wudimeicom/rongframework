<?php
echo Rong_Session::get("name" ,"default");
$addresses = Rong_Session::get("addresses","efg");
$data2 = Rong_Session::all();
print_r( $data2 );
print_r( $addresses );
echo " abc";