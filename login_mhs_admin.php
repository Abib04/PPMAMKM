<?php
include 'lib/db_lib.php';
if(!(($_SESSION['login'] == 1 and in_array($_SESSION['logged_as'],array('super_admin','ddi'))) or isset($_SESSION['is_admin'])))
    echo "false";
else {
    if(isset($_GET['id'])){
        if(is_npm(cleanchar($_GET['id']))){
            if(is_npm($_SESSION['username'])){
                echo('false');
                exit();
            }
            $admin = $_SESSION['username'];
            logout();
            @session_start();
            $_SESSION['is_admin'] = $admin;
            $_SESSION['no_edit'] = (isset($_GET['editable']))?false:true;
            $r_val = login(cleanchar($_GET['id']),'');
            echo $r_val;
        } else {
            if(cleanchar($_GET['id']) == $_SESSION['is_admin']){
            $admin = $_SESSION['is_admin'];
            logout();
            @session_start();
            $_SESSION['is_admin'] = $admin;
            $r_val = login($admin,'');
            unset($_SESSION['is_admin']);
            unset($_SESSION['no_edit']);
            echo $r_val;
            } else {
                echo "Gagal Pindah";
            }
        }
    }
}


?>
