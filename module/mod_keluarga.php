<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("keluarga","hub_keluarga");

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
    
    $table = cleanchar($_GET['t']);
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        if($table == $def_table[0]){
            
            $data = array(
                    "npm" => isset($_GET['npm']) ? $_GET['npm'] : $_SESSION['username'],
                    "id_hub_kel" => cleanchar($_POST['hub_kel']),
                    "jk" => cleanchar($_POST['jk_kel']),
                    "pekerjaan" => cleanchar($_POST['pekerjaan']),
                    "telepon" => cleanchar($_POST['telepon']),
                    "email" => cleanchar($_POST['email']),
                    "alamat" => cleanchar($_POST['alamat']),
                    "nama_kel" => cleanchar($_POST['nama_kel'])
            );
            
        }elseif($table == $def_table[1]){
            
            $data = array(
                    "nama_hub_kel" => cleanchar($_POST['nama_hub']),
                    "status" => cleanchar($_POST['status_hub'])
            );
            
        }
        
    }
    
    if($op == "create"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $data['id_thn'] = get_year(get_active_year());
                if(db_insert($def_table[0], $data)){
                    echo "true";
                }else{
                    echo $_SESSION['err_message'];
                }
                
            }else if($table == $def_table[1]){
                
                if(db_insert($def_table[1], $data)){
                    echo "true";
                }else{
                    echo $_SESSION['err_message'];
                }
                
            }
            
        }
        
    }elseif($op == "read"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[0] where id_kel='$id' and id_thn='".get_year(get_active_year())."'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[0] where id_thn='".get_year(get_active_year())."'"));
                }
                
            }else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_hub_kel='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                }
                
            }
            
        }
        
    }elseif($op == "update"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[0], $data, array("id_kel" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[1], $data, array("id_hub_kel" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }
            
        }
        
    }elseif($op == "delete"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[0], array("id_kel" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[1], array("id_hub_kel" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }
            
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
