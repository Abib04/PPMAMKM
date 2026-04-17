<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 09/09/16
 * Time: 8:07
 */
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "kuisioner";

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
    $id = (isset($_GET['npm'])) ? cleanchar($_GET['npm']) : NULL;

    $data = array();

    if($op == "create"){

        $data = array(
            "npm" => $_SESSION['username'],
            "opsi_1" => cleanchar($_POST['rad_1']),
            "opsi_2" => cleanchar($_POST['rad_2']),
            "opsi_3" => cleanchar($_POST['rad_3']),
            "alasan_1" => cleanchar($_POST['alasan_1']),
            "alasan_2" => cleanchar($_POST['alasan_2']),
            "alasan_4" => cleanchar($_POST['alasan_4']),
            "alasan_5" => cleanchar($_POST['alasan_5']),
            "alasan_6" => cleanchar($_POST['alasan_6']),
            "alasan_7" => cleanchar($_POST['alasan_7']),
            "alasan_8" => cleanchar($_POST['alasan_8']),
            "id_thn" => get_year(get_active_year())
        );

        if(db_insert($def_table, $data)){
            echo "true";
        }else{
            echo $_SESSION['err_message'];
        }

    }elseif($op == "read"){

        if(!is_null($id)){
            echo json_encode(db_read("select * from vkuisioneranswer where npm='$id'"));
        }else{
            echo json_encode(db_read("select * from vkuisioneranswer"));
        }


    }elseif($op == "delete"){

        if(!is_null($id)){
            if(db_delete($def_table, array("npm" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }

    }else{

        include "error/page_404.php";

    }
}
