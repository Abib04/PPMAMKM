<?php

require "lib/db_lib.php";
session_start();
logout();
ob_start();
header("Location:".base_url());
