<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "ruang";

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
            "nama_ruang" => cleanchar($_POST['nama_ruang']),
            "max_kuota" => cleanchar($_POST['max_kuota'])
        );
        
    }
    
    if($op == "create"){
        
        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            echo $_SESSION['err_message'];
        }
        
    }elseif($op == "read"){
        if(is_null($id)){
            echo json_encode(db_read("select * from $def_table"));
        }else{
            echo json_encode(db_read("select * from $def_table where id_ruang='$id'"));
        }
        
        
    }elseif($op == "update"){
        
        if(is_null($id) == FALSE){
            
            if(db_update($def_table, $data, array("id_ruang" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }elseif($op == "delete"){
        
        if(is_null($id) == FALSE){
            if(db_delete($def_table, array("id_ruang" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
            
    }else{
        
        include "error/page_404.php";
        
    }
    
}
