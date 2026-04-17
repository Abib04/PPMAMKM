<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "acara";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if($op == "create" or $op == "update" or $op == "delete"){
    if(!check_token($token)){
        exit("Token kosong atau tidak cocok!");
    }
}

if(is_null($op)){
    
    include "pages/error/page_404.php";
    
}else{
    
    $old_passwd = md5(cleanchar($_POST['password_lama']));
    $new_passwd = cleanchar($_POST['password_baru']);
    $conf_passwd = cleanchar($_POST['password_baru_conf']);
    
    if($op == "update"){

        if($_SESSION['logged_as'] === "mahasiswa"){
            $query = "select npm, password from mahasiswa where npm='".$_SESSION['username']."' and password='".$old_passwd."'";
        }else{
            $query = "select username, password from admin where username='".$_SESSION['username']."' and password='".$old_passwd."'";
        }

        $sql = db_read($query);

        if(count($sql) > 0){
            if($new_passwd == $conf_passwd){
                if($_SESSION['logged_as'] == "mahasiswa"){
                    $sql = db_update("mahasiswa", array("password"=>md5($new_passwd)), array("npm"=>$_SESSION['username']));
                    if($sql){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }else{
                    $sql = db_update("admin", array('password'=>md5($new_passwd)), array("username"=>$_SESSION['username']));
                    if($sql){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
            }else{
                echo "Password tidak cocok.";
            }
        }else{
            echo "Maaf, password lama tidak sesuai.";
        }
            
    }else{
        
        include "error/page_404.php";
        
    }
    
}
