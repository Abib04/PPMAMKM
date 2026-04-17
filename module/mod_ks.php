<?php

if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "kritik_saran";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
	if($op == "create"){

		$data = array(
			"nama" => cleanchar($_POST['nama']),
			"email" => cleanchar($_POST['email']),
			"pesan" => cleanchar($_POST['pesan']),
			"id_thn" => get_year(get_active_year())
// 			,"waktu" => date("Y-m-d H:i:s")
		);

		$captcha = isset($_POST['captcha']) ? cleanchar($_POST['captcha']) : NULL;

		if(!is_null($captcha)){
			if(db_insert($def_table, $data)){
				echo "true";
			}else{
				echo $_SESSION['err_message'];
			}
		}else{
			echo "Isi captcha terlebih dahulu";
		}

	}elseif($op == "delete"){
		$id = isset($_GET['id']) ? cleanchar($_GET['id']) : NULL;
		if(!is_null($id)){
            if(db_delete($def_table, array("id_ks" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }

	}
}
