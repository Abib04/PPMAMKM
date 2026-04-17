<?php
$host = "localhost";
$user = "ppm_2016";
$pass = "Y%1%QI7am(9M";
$dbs = "ppm_2016";

$db = new mysqli($host, $user, $pass, $dbs);

if($db->connect_errno > 0){
    die('Gagal [' . $db->connect_error . ']');
}  
?>
