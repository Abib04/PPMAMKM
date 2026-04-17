<?php

if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("acara","acara_tahun");

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
    
    $data = array();
    if(isset($_GET['t']))
        $table = cleanchar($_GET['t']);
    
    if($op == "create"){

        if($table == $def_table[0]){
            $data = array(
                "nama_acara" => cleanchar($_POST['nama_acara']),
                // "keterangan" => cleanchar($_POST['keterangan']),
                // "tanggal_mulai" => cleanchar($_POST['tanggal_mulai']),
                // "tanggal_selesai" => cleanchar($_POST['tanggal_selesai'])
            );
        } else if($table == $def_table[1]){
            $data = array(
                "id_acara" => cleanchar($_POST['nama_acara']),
                "method_th" => cleanchar(@$_POST['method']),
                "keterangan" => cleanchar($_POST['keterangan']),
                "tgl_mulai" => cleanchar($_POST['tanggal_mulai']),
                "tgl_selesai" => cleanchar($_POST['tanggal_selesai']),
                "id_thn" => get_year(get_active_year())
            );
        }
        
    }

    if($op == "update"){
        if($table == $def_table[1]){
            $data = array(
                "id_acara" => cleanchar($_POST['nama_acara']),
                "method_th" => cleanchar(@$_POST['method']),
                "keterangan" => cleanchar($_POST['keterangan']),
                "tgl_mulai" => cleanchar($_POST['tanggal_mulai']),
                "tgl_selesai" => cleanchar($_POST['tanggal_selesai'])
            );
        }
    }
    
    if($op == "create"){
        if(in_array($table, $def_table)){
            
                if($_POST['nama_acara'] != "" or $_POST['keterangan'] != "" or $_POST['tanggal_selesai'] != "" or $_POST['tanggal_mulai'] != ""){
                    $data["id_thn"] = get_year(get_active_year());
                    if(db_insert($table, $data)){
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
                    echo json_encode(db_read("select * from vacara where id_acara=".$id." and id_thn=".get_year(get_active_year())));
                }else{
                    echo json_encode(db_read("select * from vacara where id_thn=".get_year(get_active_year())));
                }
            }else if($table == $def_table[1]){
                $thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
                if(!is_null($id)){
                    echo json_encode(db_read("select * from vacara where id_acara_thn=$id and id_thn=$thn"));
                }else{
                    echo json_encode(db_read("select * from vacara where id_thn=$thn"));
                }
            }
        }
        
        
    }elseif($op == "reads"){
        $thn = (isset($_GET['thn']))? clean_char($_GET['thn']):get_year(get_active_year());
        if(!is_null($id)){
            echo json_encode(db_read("select * from vacara where id_acara_thn=$id and id_thn=$thn"));
        }else{
            echo json_encode(db_read("select * from vacara where id_thn=$thn"));
        }
        
        
    }elseif($op == "update"){
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $data = array(
                    "nama_acara" => cleanchar($_POST['nama_acara']),
                );

                if(!is_null($id)){

                    if(db_update($def_table[0], $data, array("id_acara" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }

                }
            } elseif ($table == $def_table[1]){
                    if(db_update($def_table[1], $data, array("id" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
            }

        }
            
    }elseif($op == "delete"){
        
        if(!is_null($id)){
            if(db_delete($table, array("id_acara" => $id))){
                echo "true";
            }else{
                echo $_SESSION['err_message'];
            }
        }
    }elseif($op == "read_jam_oh"){
        //echo $_GET['tgl'];
        $now = strtotime(date("Y-m-d"));
        $tgl = strtotime((isset($_GET['tgl']))? cleanchar($_GET['tgl']):null );
        $kuota = db_read("SELECT sum(max_kuota) as total FROM vdivroom where id_acara = 3 AND id_thn = ".get_id_active_year());
        
	    if(!is_null($tgl)){
            if($now < $tgl){ 
                echo json_encode(db_read("select a.jam_mulai, a.jam_akhir, nama_sesi, a.id_sesi from vsesi a LEFT join (select sesi_ruang_oh.id_sesi, count(*) as total from sesi_ruang_oh group by sesi_ruang_oh.id_sesi) b on a.id_sesi = b.id_sesi where a.id_acara=3 and a.tanggal='".cleanchar($_GET['tgl'])."' AND ifnull(b.total,0) < ".$kuota[0]['total']));    
            } else {
                $d = array('now' => $now,'tanggal' => $tgl);
                echo json_encode($d);
            }
        }
    }elseif($op == "read_sesi_oh"){
        //echo $_GET['tgl'];
        $now = strtotime(date("Y-m-d"));
        $tgl = strtotime((isset($_GET['tgl']))? cleanchar($_GET['tgl']):null );
        $sesi = cleanchar($_GET['sesi']);
        $kuota = db_read("SELECT sum(max_kuota) as total FROM vdivroom where id_acara = 3 AND id_thn = ".get_id_active_year());
        
	    if(!is_null($tgl)){
	        //3 = 'Open House Universitas'
            if($now < $tgl){ 
                echo json_encode(db_read("select *,
                (SELECT COUNT(*) as jml FROM `sesi_ruang_oh` 
                WHERE sesi_ruang_oh.id_thn='".get_id_active_year()."' 
                AND sesi_ruang_oh.id_ruang=ruang.id_ruang 
                AND sesi_ruang_oh.id_sesi='".$sesi."'
                GROUP BY id_sesi, id_ruang) as terpakai
                from vdivroom 
                inner join ruang on ruang.id_ruang=vdivroom.id_ruang 
                where id_acara=3 and 
                tanggal LIKE '%".cleanchar($_GET['tgl'])."%' 
                and id_thn=".get_id_active_year()." 
                ORDER BY prioritas, ruang.nama_ruang"));    
            } else {
                $d = array('now' => $now,'tanggal' => $tgl);
                echo json_encode($d);
            }
        }
    }
    else{
        
        include "error/page_404.php";
        
    }
    
}
