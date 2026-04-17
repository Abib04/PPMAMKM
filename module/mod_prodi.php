<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "prodi";
$def_pk = "id";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        $data = array("id_fakultas" => cleanchar($_POST['fakultas']), "nama_prodi" => cleanchar($_POST['nama_prodi']), "status" => cleanchar($_POST['status_prodi']), "jenjang"=> cleanchar($_POST['jenjang_prodi']),"kode"=> cleanchar($_POST['kode']));
        
    }
    
    if($op == "create"){
        
        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                echo "Maaf, nama prodi sudah terdaftar";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }elseif($op == "read"){
        $fakultas = (isset($_GET['fakultas']))? cleanchar($_GET['fakultas']):null;
        if(!is_null($fakultas)){
            echo json_encode(db_read("select * from $def_table where id_fakultas=$fakultas"));
        }elseif(!is_null($id)){
            echo json_encode(db_read("select * from $def_table where id=$id"));
        }else{
            echo json_encode(db_read("select * from $def_table"));
        }
        
    }elseif($op == "update"){
        
        if(!is_null($id)){
            if(db_update($def_table, $data, array($def_pk => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
            
    }elseif($op == "delete"){
        
        if(!is_null($id)){
            if(db_delete($def_table, array($def_pk => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
