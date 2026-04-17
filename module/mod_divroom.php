<?php

if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "div_room";

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
                    "id_acara_thn" => cleanchar($_POST['acara'])
        );
    }
    
    if($op == "create"){

        $room = explode(",", cleanchar($_POST['ruang']));

        if(count($room) > 0){
            $msg = NULL;
            for($i = 0; $i < count($room); $i++){
                $data['id_ruang'] = $room[$i];
                if(db_insert($def_table, $data)){
                    $msg = "true";
                }else{
                    $msg = $_SESSION['err_message']."\\n";
                }
            }

            echo $msg;
        }else{
            echo "Maaf, pilih ruangan terlebih dahulu.";
        }

    }elseif ($op == "read") {
        
        $par = isset($_GET['par']) ? cleanchar($_GET['par']) : NULL;

        if($par == "same"){
            $acara = isset($_GET['acara']) ? cleanchar($_GET['acara']) : NULL;
            $tanggal = isset($_GET['tanggal']) ? cleanchar($_GET['tanggal']) : NULL;
            if(!is_null($acara) and !is_null($tanggal)){
                echo json_encode(db_read("select * from vdivroom where id_acara_thn=".$acara." AND tanggal='".$tanggal."'"));
            }
        }elseif($par == "different"){
            $id = isset($_GET['id']) ? cleanchar($_GET['id']) : NULL;
            if(!is_null($id)){
                $room = explode(";", rtrim($id, ";"));
                $sql = "select * from ruang where";
                for ($i=0; $i < count($room); $i++) { 
                    $sql .= " id_ruang != " . $room[$i] . " AND";
                }

                $sql = rtrim($sql, " AND");

                echo json_encode(db_read($sql));
            }
        }else{
            echo json_encode(db_read("select * from vdivroom"));
        }

    }elseif ($op == "update") {
        $room = explode(",", cleanchar($_POST['ruang']));
        $msg = NULL;
        if(count($room) > 0){
            if(db_delete($def_table, array("id_acara_thn" => $_GET['acara']))){
                for($i = 0; $i < count($room); $i++){
                    $data['id_ruang'] = $room[$i];
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

    }elseif ($op == "delete") {
        $acara = isset($_GET['acara']) ? cleanchar($_GET['acara']) : NULL;
        if(!is_null($acara)){
            if(db_delete($def_table, array("id_acara_thn" => $acara))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }else{
            echo $acara;
        }

    }elseif($op == "inlene_edit"){
        $id_dr = $_POST['id_dr'];
        $data['kuota'] = $_POST['nilai'];
        if(db_update('div_room',$data,array('id_dr'=>$id_dr))){
            $res['message'] = "Berhasil melakukan update";
            $res['status'] = 200;
            echo json_encode($res);
        }
    }else{
        
        include "error/page_404.php";
        
    }
    
}
