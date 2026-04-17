<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("panitia","posisi_panitia");
//$def_table = "panitia";

$op = (isset($_GET['op'])) ? cleanchar($_GET['op']) : NULL;

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if($op == "create" or $op == "update" or $op == "delete"){
    if(!check_token($token)){
        exit("Token kosong atau tidak cocok!");
    }
}

if(is_null($op)){
    
    include "pages/error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $table = isset($_GET['t']) ? cleanchar($_GET['t']) : NULL;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        if($table == $def_table[0]){
         
            $data = array(
                    "id_pp" => cleanchar($_POST['posisi_panitia']),
                    "id_thn" => get_year(get_active_year()),
                    "nama" => cleanchar($_POST['nama']),
                    "no_identitas" => cleanchar($_POST['no_identitas']),
                    "jk" => cleanchar($_POST['jk']),
                    "hp" => cleanchar($_POST['hp'])
            );
            
        }else if($table == $def_table[1]){
            
            $data = array(
                    "nama_pp" => cleanchar($_POST['nama_pp']),
                    "status" => cleanchar($_POST['status_pp'])
            );
            
        }
        
    }
    
    if($op == "create"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
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
            //echo ($def_table[0]);
            if($table == $def_table[0]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[0] inner join $def_table[1] on $def_table[0].id_pp=$def_table[1].id_pp  where id_panitia=$id and id_thn=".get_year(get_active_year())." "));
                    // echo json_encode(db_read("select * from $def_table[0] where id_thn=".get_year(get_active_year())." "));
                }else{
                    echo json_encode(db_read("select * from $def_table[0] inner join $def_table[1] on $def_table[0].id_pp=$def_table[1].id_pp  where id_thn=".get_year(get_active_year())." "));
                }
                
            }
            else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_pp=".$id));
                    // echo json_encode(db_read("select * from $def_table[1] where id_pp='7'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                }
                
            }
            
        }
        
    }elseif($op == "read_full_panitia"){
        //$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        //if(!is_null($id)){
        //    echo json_encode(db_read("select * from panitia where id_panitia=".$id." and id_thn=".$thn));
        //}else{
        //    echo json_encode(db_read("select * from panitia where id_thn=".$thn));
        //}
        
        if(in_array($table, $def_table)){
            //echo ($def_table[0]);
            if($table == $def_table[0]){
                //echo $def_table[0];
                if(!is_null($id)){
                    //echo json_encode(db_read("select * from $def_table[0] where id_panitia=$id and id_thn=".get_year(get_active_year())." "));
                    echo json_encode(db_read("select * from $def_table[0] where id_thn=".get_year(get_active_year())." "));
                }else{
                    echo json_encode(db_read("select * from $def_table[0] where id_thn=".get_year(get_active_year())." "));
                }
                
            }else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_pp=".$id));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                }
                
            }
            
        }
        
        
        
    }elseif($op == "update"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[0], $data, array("id_panitia" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[1], $data, array("id_pp" => $id))){
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
                    
                    if(db_delete($def_table[0], array("id_panitia" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[1], array("id_pp" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }
            
        }
        
    }else{
        $uri = $_SERVER[REQUEST_URI];
        if(strpos($uri, "presensi_panitia") < 0)
            include "pages/error/page_404.php";
    }
    
}
