<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "admin";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if($op == "create" or $op == "update" or $op == "delete"){
    if(!check_token($token)){
        exit("Token kosong atau tidak cocok!");
    }
}

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        $data = array(
            "user_level" => cleanchar($_POST['user_level']),
            "username" => cleanchar($_POST['username']),
            "id_thn" => cleanchar($_POST['tahun']),
            "status" => cleanchar($_POST['status_admin'])
        );
        
    }
    
    if($op == "create"){
        
        if($_POST['password_'] == $_POST['password_retype']){

            if($_POST['password_'] == ""){
                unset($data['password_']);
            }

            $data["password"] = md5(cleanchar($_POST['password_']));
            if(db_insert($def_table, $data)){
                echo "true";
            }else{
                if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                    echo "Maaf, Admin anda sudah terdaftar";
                }else{
                    echo $_SESSION['err_message'];
                }
            }
        }else{
            echo "Password tidak sama.";
        }
        
    }elseif($op == "read"){
        if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin"){
            if(!is_null($id)){
                echo json_encode(db_read("select * from $def_table where id_admin='$id'"));
            }else{
                echo json_encode(db_read("select * from $def_table"));
            }
        } else {
            echo 'Anda tidak diperkenankan mengakses halaman ini.';
        }
        
    }elseif($op == "read_full"){
        if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin"){
            if(!is_null($id)){
                echo json_encode(db_read("select * from vadmin where id_admin='$id'"));
            }else{
                echo json_encode(db_read("select * from vadmin"));
            }
        } else {
            echo 'Anda tidak diperkenankan mengakses halaman ini.';
        }
    }elseif($op == "update"){
        
        if(!is_null($id)){

            if($_POST['password_'] == $_POST['password_retype']){
                if($_POST['password_'] != ""){
                    $data["password"] = md5(cleanchar($_POST['password_']));
                }

                if(db_update($def_table, $data, array("id_admin" => $id))){
                    echo "true";
                }else{
                    echo $_SESSION['err_message'];
                }
            }else{
                echo "Password tidak sama.";
            }
            
        }
            
    }elseif($op == "delete"){
        
        if(is_null($id) == FALSE){
            if(db_delete($def_table, array("id_admin" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
