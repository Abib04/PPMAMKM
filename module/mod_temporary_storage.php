<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "temporary_storage";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $data = array();
    
    if($op == "create"){
        $data = array(
            "judul" => cleanchar($_POST['judul']),
            "isi" => cleanchar($_POST['isi'])
        );
        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            if(strpos($_SESSION['err_message'], "Duplicate") > -1){
               echo "Maaf, Data anda sudah ada";
            }else{
               echo $_SESSION['err_message'];
            }
         }
        
            
    }elseif($op == "delete"){
        
        if(is_null($id) == FALSE){
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
