<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "sesi_kloter";

$def_pk = "id";

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

$op = cleanchar($_GET['op']);

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        $data = array("id_kloter"=>cleanchar($_POST['kloter']));
        
    }
    
    if($op == "create"){
        

        $sesi = explode(",", cleanchar($_POST['sesi']));

        if(count($sesi) > 0){
            $msg = NULL;
            for($i = 0; $i < count($sesi); $i++){
                $data['id_sesi'] = $sesi[$i];
                if(db_insert($def_table, $data)){
                    $msg = "true";
                }else{
                    $msg = $_SESSION['err_message']."\\n";
                }
            }

            echo $msg;
        }else{
            echo "Maaf, pilih sesi terlebih dahulu.";
        }
        
    }elseif($op == "read"){
        // $sesi = (isset($_GET['sesi']))? cleanchar($_GET['sesi']):null;
        if(!is_null($id)){
            $par = (isset($_GET['par']))? cleanchar($_GET['par']):null;
            if(is_null($par)){
                echo json_encode(db_read("select * from vsesi_kloter where id_thn=".get_year(get_active_year())." and id_kloter=$id"));
            } elseif($par == "different"){
                $ids = isset($_GET['id']) ? cleanchar($_GET['id']) : NULL;
                if(!is_null($id)){
                    $sesi = explode(";", rtrim($ids, ";"));
                    $sql = "select * from vsesi where id_thn=".get_year(get_active_year())." AND id_sesi not in (select id_sesi from vsesi_kloter where id_thn='".get_year(get_active_year())."' and id_kloter=$id)";
                    // for ($i=0; $i < count($sesi); $i++) { 
                    //     $sql .= " id_sesi != " . $sesi[$i] . " AND";
                    // }

                    // $sql = rtrim($sql, " AND");

                    echo json_encode(db_read($sql));
                }
            }
        }else{
            echo json_encode(db_read("select * from $def_table"));
        }
        
    }elseif($op == "update"){
        $sesi = explode(",", cleanchar($_POST['sesi']));
        $msg = NULL;
        if(count($sesi) > 0){
            if(db_delete($def_table, array("id_kloter" => $_GET['id']))){
                for($i = 0; $i < count($sesi); $i++){
                    $data['id_sesi'] = $sesi[$i];
                    if(db_insert($def_table, $data)){
                        $msg = "true";
                    }else{
                        $msg = $_SESSION['err_message']."\\n";
                    }
                }
                echo $msg;
            }else{
                echo $_SESSION['err_message'];
            }
            
        }else{
            echo "Maaf, pilih ruangan terlebih dahulu.";
        }

            
    }elseif($op == "delete"){
        
        if(!is_null($id)){
            if(db_delete($def_table, array("id_kloter" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
