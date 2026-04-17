<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "kabupaten";

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
        
        $data = array("id_daerah" => cleanchar($_POST['daerah']), "nama_kab" => cleanchar($_POST['nama_kab']), "status" => cleanchar($_POST['status_kab']), "id_negara"=> cleanchar($_POST['negara']));
        
    }
    
    if($op == "create"){
        
        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                echo "Maaf, nama kabupaten sudah terdaftar";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }elseif($op == "read"){
        
        $daerah = (!is_null($_GET['daerah'])) ? cleanchar($_GET['daerah']) : NULL;
        if(!is_null($daerah)){
            echo json_encode(db_read("select * from $def_table where id_daerah='$daerah' order by nama_kab asc"));
        }else if(!is_null($id)){
            echo json_encode(db_read("select * from $def_table where id_kab='$id'"));
        }else{
            echo json_encode(db_read("select * from $def_table"));
        }
        
    }elseif($op == "update"){
        
        if(!is_null($id)){
            
            if(db_update($def_table, $data, array("id_kab" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
            
    }elseif($op == "delete"){
        
        if(!is_null($id)){
            if(db_delete($def_table, array("id_kab" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
