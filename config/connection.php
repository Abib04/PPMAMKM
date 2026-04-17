<?php
include "config.php";
$con = mysqli_connect($config['db_hostname'], $config['db_uname'], $config['db_passwd']);
if(!$con){
die(trigger_error("Connection failed : ".mysqli_connect_error()));
}else{
mysqli_select_db($con, $config['dbname']);
}

