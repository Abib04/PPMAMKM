<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "fakultas";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        $data = array( "nama_fakultas" => cleanchar($_POST['nama_fakultas']), "status" => cleanchar($_POST['status_fakultas']));
        
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
        
        if(!is_null($id)){
            echo json_encode(db_read("select * from $def_table where id='$id'"));
        }else{
            echo json_encode(db_read("select * from $def_table"));
        }
        
    }elseif($op == "update"){
        
        if(!is_null($id)){
            
            if(db_update($def_table, $data, array("id" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
            
    }elseif($op == "delete"){
        
        if(!is_null($id)){
            if(db_delete($def_table, array("id" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
