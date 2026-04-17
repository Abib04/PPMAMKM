<?php

require "lib/db_lib.php";

$uname = cleanchar($_POST['username']);
$passwd = cleanchar($_POST['password']);

login($uname, $passwd);
