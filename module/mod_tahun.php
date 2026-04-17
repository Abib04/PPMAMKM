<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");
    
$def_table = "tahun";

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
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        $data = array(
            "status" => isset($_POST['status_tahun']) ? cleanchar($_POST['status_tahun']) : "N"
        );
        
    }
    
    if($op == "create"){
        $data["thn"] = cleanchar($_POST['thn']);
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
            echo json_encode(db_read("select * from $def_table where id_thn='$id'"));
        }else{
            $status = (isset($_GET['status'])) ? cleanchar($_GET['status']) : NULL;
            if(!is_null($status)){
                echo json_encode(db_read("select * from $def_table where status='$status' order by thn desc"));
            }else{
                echo json_encode(db_read("select * from $def_table order by thn desc"));
            }
        }
        
    }elseif($op == "update"){
        
        $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;

        if(!is_null($id)){
            $data["thn"] = cleanchar($_POST['thn']);
            if(db_update($def_table, $data, array("id_thn" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }

        }else{
            if(db_update($def_table, $data, array("status" => "Y"))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }elseif($op == "delete"){
        
        $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
        if(!is_null($id)){
            if(db_delete($def_table, array("id_thn" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
            
    }else{
        
        include "error/page_404.php";
        
    }
    
}
