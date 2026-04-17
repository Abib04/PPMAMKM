<?php
include "lib/db_lib.php";
@session_start();
define('BASE_PATH', true);

$mod = ($_SESSION['login'] != 1) ? "" : cleanchar($_GET['module']);
if($_SESSION['login'] != 1){
    if(isset($mod)){
        if((strcmp(cleanchar($_GET['module']), "mod_kabupaten") == 0) or (strcmp(cleanchar($_GET['module']), "mod_daerah")) == 0){
            if($_GET['op'] != "read"){
                exit("Maaf, anda tidak bisa mengakses halaman ini.");
            }else{
                call_file($_GET['module']);
            }
        }elseif(strcmp(cleanchar($_GET['module']), "mod_mahasiswa") == 0){
            if(cleanchar($_GET['op']) != "create"){
                exit("Maaf, anda tidak bisa mengakses halaman ini.");
            }else{
                if($_SESSION['captcha_ans'] == $_POST['captcha']){
                    call_file(cleanchar($_GET['module']));
                }else{
                    echo "<script>alert('Captcha Salah');window.history.go(-1)</script>";
                }
            }
        } else if(strcmp(cleanchar($_GET['module']), "mod_prodi") == 0){
            if($_GET['op'] != "read"){
                exit("Maaf, anda tidak bisa mengakses halaman ini.");
            }else{
                call_file($_GET['module']);
            }
        }else{
            exit("Maaf, anda tidak bisa mengakses halaman ini. huhu");
        }
    }else{
        exit("Maaf, module tidak ditemukan.");
    }
}else{
	if(isset($mod)){
	    //echo 1;
	    //echo ($_GET['module']);
        call_file($mod);
    }else{
        exit("Maaf, anda tidak bisa mengakses halaman ini. haha");
    }
}

