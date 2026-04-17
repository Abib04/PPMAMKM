<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");
    
$def_table = "kloter";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $data = array();
    
    if($op == "create"){
        $data["nama_kloter"] = cleanchar($_POST['kloter']);
        $data["id_thn"] = get_year(get_active_year());
        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                echo "Maaf, tahun sudah terdaftar";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }elseif($op == "read"){
        
        $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
        if(!is_null($id)){
            echo json_encode(db_read("select * from $def_table where id='$id'"));
        }
        
    }elseif($op == "update"){
        
        $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;

        if(!is_null($id)){
            $data["nama_kloter"] = cleanchar($_POST['kloter']);
            if(db_update($def_table, $data, array("id" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }

        }
        
    }elseif($op == "delete"){
        
        $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
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
