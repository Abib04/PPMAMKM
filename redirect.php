<?php
include "lib/db_lib.php";
sess_start();

if ($_SESSION['login'] == 1) {
    if ($_SESSION['logged_as'] == "super_admin") {
        header("Location: admin.php");
    } else {
        header("Location: " . base_url());
    }
} else {
    header("Location: " . base_url());
}
exit();
?>
