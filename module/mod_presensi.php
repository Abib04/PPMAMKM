<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "absensi";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){

    

    include "error/page_404.php";

    

}else{

    

    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;

    $id_acara = (isset($_GET['id_acara_thn'])) ? cleanchar($_GET['id_acara_thn']) : NULL;

    if(is_null($id_acara)){
        echo "Tentukan untuk acara apa!";
    } else {

        $data = array();

        

        if($op == "create" or $op == "update"){

            

            $data = array(

                "npm" => cleanchar($_POST['npm']),	
                "id_acarathn" => $id_acara,	
                "keterangan" => cleanchar($_POST['ket']),

            );

            

        }

        

        if($op == "create"){

            

            if(db_insert($def_table, $data)){

                echo "true";

            }else{

                if(strpos($_SESSION['err_message'], "Duplicate") > -1){

                    echo "Maaf, nama agama sudah terdaftar";

                }else{

                    echo $_SESSION['err_message'];

                }

            }

            

        }elseif($op == "read"){

            

            if(!is_null($id)){

                echo json_encode(db_read("select * from $def_table where id_acarathn= ".$id_acara." and id=".$id));

            }else{

                echo json_encode(db_read("select * from $def_table where id_acarathn=".$id_acara));

            }

            

            

        }elseif($op == "update"){

            

            if(!is_null($id)){

                

                if(db_update($def_table, $data, array("id" => $id))){

                    echo "true";

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

}
