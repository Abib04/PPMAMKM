<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("penyakit","penyakit_mahasiswa");

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
                    "nama_penyakit" => cleanchar($_POST['nama_penyakit']),
                    "status" => cleanchar($_POST['status_penyakit'])
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

                // $other = db_read("select replace(nama_penyakit, " ", "") from penyakit where nama_penyakit='".rtrim(cleanchar($_POST['lainnya']), " ","")."'");
                // if(count($other) == 0){


                // }

                if(cleanchar($_POST['lainnya']) != ""){
                    $penyakit = db_read("select * from vpenyakitnospace where penyakit='".str_replace(' ','',cleanchar($_POST['lainnya']))."'");
                    if(count($penyakit) > 0){
                        $data = array(
                            "npm" => $_SESSION['username'],
                            "id_np" => $penyakit[0]['id_np'],
                            "id_thn" => get_id_active_year()
                        );
                        if (db_insert($def_table[1], $data)) {
                            foreach ($_POST['penyakit'] as $value) {
                                $penyakit = db_read("select id_np from penyakit_mahasiswa where npm='".$_SESSION['username']."' AND id_np='".$value."'");
                                if(count($penyakit) == 0) {
                                    $data = array(
                                        "npm" => $_SESSION['username'],
                                        "id_np" => $value,
                                        "id_thn" => get_id_active_year()
                                    );

                                    if (!db_insert($def_table[1], $data)) {
                                        echo $_SESSION['err_message'];
                                        break;
                                    }
                                }
                            }

                            echo "true";
                        } else {
                            echo "Gagal memasukkan data.";
                        }
                    }else {
                        $data = array("nama_penyakit"=>cleanchar($_POST['lainnya']), "status"=>"Y");
                        if (db_insert($def_table[0], $data)) {
                            $lastID = db_lastID();
                            $data = array(
                                "npm" => $_SESSION['username'],
                                "id_np" => $lastID,
                                "id_thn" => get_id_active_year()
                            );
                            if(!isset($_POST['penyakit'])){
                                if (db_insert($def_table[1], $data)) {
                                    echo "true";
                                }else{
                                    echo "Gagal memasukkan data.";
                                }
                            }else{
                                if (db_insert($def_table[1], $data)) {
                                    foreach ($_POST['penyakit'] as $value) {
                                        $penyakit = db_read("select id_np from penyakit_mahasiswa where npm='".$_SESSION['username']."' AND id_np='".$value."'");
                                        if(count($penyakit) == 0) {
                                            $data = array(
                                                "npm" => $_SESSION['username'],
                                                "id_np" => $value,
                                                "id_thn" => get_id_active_year()
                                            );

                                            if (!db_insert($def_table[1], $data)) {
                                                echo $_SESSION['err_message'];
                                                break;
                                            }
                                        }
                                    }

                                    echo "true";
                                } else {
                                    echo "Gagal memasukkan data.";
                                }
                            }
                        }
                    }
                }else{
                    if(!is_array($_POST['penyakit'])){
                        $penyakit = db_read("select id_np from penyakit_mahasiswa where npm='".$_SESSION['username']."' AND id_np='".$_POST['penyakit']."'");
                        if(count($penyakit) == 0){
                            $data = array(
                                "npm" => $_SESSION['username'],
                                "id_np" => $_POST['penyakit'],
                                "id_thn" => get_id_active_year()
                            );

                            if(!db_insert($def_table[1], $data)){
                                echo $_SESSION['err_message'];
                            }
                        }
                    }else{
                    foreach ($_POST['penyakit'] as $value) { 
                        $penyakit = db_read("select id_np from penyakit_mahasiswa where npm='".$_SESSION['username']."' AND id_np='".$value."'");
                        if(count($penyakit) == 0){
                            $data = array(
                                "npm" => $_SESSION['username'],
                                "id_np" => $value,
                                "id_thn" => get_id_active_year()
                            );

                            if(!db_insert($def_table[1], $data)){
                                echo $_SESSION['err_message'];
                                break;
                            }
                        }
                    }}

                    echo "true";
                }
                
            }
            
        }
        
    }elseif($op == "read"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[0] where id_np='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[0]"));
                }
                
            }else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_penyakit='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                }
                
            }
            
        }
        
    }elseif($op == "update"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[0], $data, array("id_np" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_update($def_table[1], $data, array("id_penyakit" => $id))){
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
                    
                    if(db_delete($def_table[0], array("id_np" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[1], array("id_penyakit" => $id))){
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
