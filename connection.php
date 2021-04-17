<?php

$db_con = new mysqli("localhost","root","", "webmap");

if(!$db_con){
	echo "Sorry, failed to connect!!";
}

$db_con->set_charset("utf8");
?>
