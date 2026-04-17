<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");
$def_table = array("sesi","sesi_ruang_oh","sesi_ruang_om","sesi_ruang_pk");
$op = cleanchar($_GET['op']);
$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;
if($op == "create" or $op == "update" or ($op == "delete" and !isset($_GET['xhr']))){
    if(!check_token($token)){
        exit("Token kosong atau tidak cocok!");
    }
}
if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    
    $table = cleanchar($_GET['t']);
    //echo $table;
    
    $data = array();
    
    if($op == "create" or $op == "update"){
        
        if($table == $def_table[0]){
            
            $data = array(
                    "nama_sesi" => cleanchar($_POST['nama_sesi']),
                    "jam_mulai" => cleanchar($_POST['jam_mulai']),
                    "jam_akhir" => cleanchar($_POST['jam_akhir']),
                    "id_acara_thn" => cleanchar($_POST['acara']),
                    //"id_acara" => cleanchar($_POST['']),
                    "tanggal" => cleanchar($_POST['tanggal'])
                    //"id_thn" => get_year(get_active_year())
            );
            
        }else if($table == $def_table[1]){
            
            $data = array(
                    "id_kel" => cleanchar($_POST['kel'])
            );
            
            
        }else if($table == $def_table[2]){
            // $data = array(
            //         // "id_sesi" => cleanchar($_POST['sesi']),
            //         "id_ruang" => cleanchar($_POST['ruang']),
            //         "id_kelompok" => cleanchar($_POST['npm'])
            // );
        }
        
    }
    
    if($op == "create"){
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(db_insert($def_table[0], $data)){
                    echo "true banget";
                    // alert("Berhasil mendaftar.");
                    echo("<meta http-equiv='refresh' content='1'>");
                }else{
                    echo $_SESSION['err_message'];
                }
                
            }else if($table == $def_table[1]){
                
/* 
-- Open House H1
- I 71 = IF , prodi 4 fak 1 
- II 73 = IF + SI prodi 4 fak 1 dan prodi 6 fak 1
- III = Ilkom fak 1
- IV 76 = FCS + FST (selain ilkom) fak 2 dan fak 3
- V 72 = D3 + SI (jika ada) + Internasional
- VI 74  = TI + Tekkom

*/
                // $npm = get_session('username');
                // $prodi = get_session('id_prodi');
                // $kuota_sesi = db_read('SELECT sum(max_kuota) as max_total  FROM `vdivroom` WHERE `id_acara` = 3 AND `id_thn` ='.get_id_active_year());
                // $fakultas = get_session('id_fakultas');
                // $sesi = '';
                // $nama_sesi = '';
                // if($fakultas == 1):
                    /*
                    $tanggal = $_POST['tanggal'];
                    $jam = $_POST['jam'];
                    $query_sesi = db_read("SELECT * FROM `vsesi` WHERE tanggal = '$tanggal' AND jam_mulai = '$jam' AND id_thn = ".get_id_active_year()." AND id_acara = 3");
                    $sesi = $query_sesi[0]['id_sesi'];
                    
                    $sql1 = db_read("SELECT COUNT(*) as jumlah FROM `vsesi_oh` WHERE id_ruang = 82 AND id_sesi = '$sesi' AND id_thn = ".get_id_active_year());
                    // Citra 2
                    $sql2 = db_read("SELECT COUNT(*) as jumlah FROM `vsesi_oh` WHERE id_ruang = 83 AND id_sesi = '$sesi' AND id_thn = ".get_id_active_year());
                    $sql3 = db_read("SELECT COUNT(*) as jumlah FROM `vsesi_oh` WHERE id_ruang = 84 AND id_sesi = '$sesi' AND id_thn = ".get_id_active_year());
                    // Cinema
                    $sql44 = db_read("SELECT COUNT(*) as jumlah FROM `vsesi_oh` WHERE id_ruang = 81 AND id_sesi = '$sesi' AND id_thn = ".get_id_active_year());

                    $ruang1 = db_read("SELECT id_ruang, max_kuota from vdivroom where id_acara = 3 and id_ruang = 82 and id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                    $ruang2 = db_read("SELECT id_ruang, max_kuota from vdivroom where id_acara = 3 and id_ruang = 83 and id_thn=".get_id_active_year()."  ORDER BY prioritas ASC");
                    $ruang3 = db_read("SELECT id_ruang, max_kuota from vdivroom where id_acara = 3 and id_ruang = 84 and id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                    $ruang44 = db_read("SELECT id_ruang, max_kuota from vdivroom where id_acara = 3 and id_ruang = 81 and id_thn=".get_id_active_year()."  ORDER BY prioritas ASC");
                    // $sesi = rand(89,93);
                    

                    
                    if ($sql44[0]['jumlah'] < $ruang44[0]['max_kuota']) {
                        $data['id_sesi'] = $sesi;
                        $data['id_ruang'] = $ruang44[0]['id_ruang'];
                        if(db_insert($def_table[1], $data)){
                            echo "true";
                        }else{
                            echo "false";
                        }
                    }elseif ($sql1[0]['jumlah'] < $ruang1[0]['max_kuota']) {
                        $data['id_sesi'] = $sesi;
                        $data['id_ruang'] = $ruang1[0]['id_ruang'];
                        if(db_insert($def_table[1], $data)){
                            echo "true";
                        }else{
                            echo "false";
                        }
                    }elseif ($sql2[0]['jumlah'] < $ruang2[0]['max_kuota']) {
                            $data['id_sesi'] = $sesi;
                            $data['id_ruang'] = $ruang2[0]['id_ruang'];
                        if(db_insert($def_table[1], $data)){
                            echo "true";
                        }else{
                            echo "false";
                        }
                    }elseif ($sql3[0]['jumlah'] < $ruang3[0]['max_kuota']) {
                            $data['id_sesi'] = $sesi;
                            $data['id_ruang'] = $ruang3[0]['id_ruang'];
                        if(db_insert($def_table[1], $data)){
                            echo "true";
                        }else{
                            echo "false";
                        }
                    }
                    else{
                        echo "NCEN ORA ONO MENEH";
                        echo "\n";
                        echo "Jumlah : ".$sql44[0]['jumlah'];
                        echo "\n";
                        echo "Max Kuota Ruang Cinema : ".$ruang44[0]['max_kuota'];
                        echo "\n";
                        echo "Max Kuota Ruang Citra 1 : ".$ruang1[0]['max_kuota'];
                        echo "\n";
                        echo "Max Kuota Ruang Citra 2 : ".$ruang2[0]['max_kuota'];
                        echo "\n";
                        //print_r($data);
                    }
                    */
                    /* ----- UPDATE JULI 2022 ------ */
                    $id_kel = cleanchar($_POST['kel']);
                    $tanggal = cleanchar($_POST['tanggal']);
                    $id_sesi = cleanchar($_POST['id_sesi']);
                    $id_ruang = cleanchar($_POST['id_ruang']);
                    
                    
                    //Ambil Data Ruang
                    $ruang = db_read("SELECT id_ruang, max_kuota FROM ruang WHERE id_ruang=".$id_ruang);
                    
                    $query_sesi = db_read("SELECT `id_sesi`, `id_acara`, `nama_sesi`, `jam_mulai`, `jam_akhir`, `nama_acara`, `tanggal`, `id_thn` 
                    FROM `vsesi` WHERE id_sesi = '$id_sesi' AND tanggal = '$tanggal' AND id_thn = ".get_id_active_year()." AND id_acara = 3 LIMIT 1");
                    //$sesi = $query_sesi[0]['id_sesi'];
                    foreach ($query_sesi as $k => $v) {
                        $jumlah = get_jumlah_peserta_oh($v['id_sesi'],$id_ruang,'ruang');
                        foreach ($ruang as $k_ruang=>$v_ruang){
                            if($v_ruang['max_kuota'] > $jumlah){
                                if(checkExist($_SESSION['username'])){
                                    echo "Maaf, maksimal yang dapat hadir pada acara open house adalah 1 orang.";
                                } else {
                                    $data['id_sesi'] = $id_sesi;
                                    $data['id_ruang'] = $id_ruang;
                                    $data['id_kel'] = $id_kel;
                                    if(db_insert($def_table[1], $data)){
                                        echo "true 1";
                                        // header("Refresh:0; url=https://ppm.amikom.ac.id/media.php?page=data_mhs_reg_oh");
                                        ?>
                                        <script type="text/javascript">
                                        window.location.href="<?php echo base_url(); ?>";
                                        </script>
                                        <?php
                                        // break;
                                    }else{
                                        echo $_SESSION['err_message'];
                                    }
                                }
                            }else{
                                echo 'Maaf jadwal open house penuh!';
                            }
                        }
                    }
                    
                    /* ----- END UPDATE JULI 2022 ------ */

                // elseif(in_array($fakultas,array(2,3))):
                //     if(!$prodi == 19)
                //         $nama_sesi = 'IV';
                //     else
                //         $nama_sesi = 'III';
                // endif;
                // $cond = false;
                // do {
                //     if($cond){
                //         if ($nama_sesi == 'I') {
                //             $nama_sesi = 'II';
                //         } else if($nama_sesi == 'II') {
                //                 $nama_sesi = 'V';
                //         } else if($nama_sesi == 'VI'){
                //             $nama_sesi = 'V';
                //         }
                        
                //     }
                    
                //     $tmp = db_read("SELECT id_sesi,tanggal,jam_mulai FROM vsesi WHERE id_acara= 3 AND id_thn=".get_id_active_year()." AND nama_sesi='".$nama_sesi."' LIMIT 1");
                //     foreach ($tmp as $k => $v) {
                //         $sesi = $v['id_sesi'];
                //     }
                //     $cond = get_jumlah_peserta_oh($sesi) >= $kuota_sesi[0]['max_total'];
                // } while ($cond);
                // $ruang = db_read("SELECT id_ruang, max_kuota from vdivroom where id_acara = 3 and id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                // $n_ruang = count($ruang);
                // if($n_ruang > 0){
                //     foreach ($ruang as $k_ruang=>$v_ruang){
                //         $jumlah = get_jumlah_peserta_oh($sesi,$v_ruang['id_ruang'],'ruang');
                //         if($v_ruang['max_kuota'] > $jumlah){
                //             if(checkExist($_SESSION['username'])){
                //                 echo "Maaf, maksimal yang dapat hadir pada acara open house adalah 1 orang.";
                //             } else {
                //                 $data['id_sesi'] = $sesi;
                //                 $data['id_ruang'] = $nruang;
                //                 if(db_insert($def_table[1], $data)){
                //                     echo "true";
                //                     break;
                //                 }else{
                //                     echo $_SESSION['err_message'];
                //                 }
                //             }
                //         } else {
                            
                //             if(($n_ruang-1) == $k_ruang){
                //                 echo 'Maaf jadwal open house penuh!';
                //             }
                //         }
                //     }
                // }else{
                //     echo "Maaf, ruangan untuk open house belum ditentukan";
                // }
            }else if($table == $def_table[2]){
                db_free_query("DELETE sesi_ruang_om FROM sesi_ruang_om INNER JOIN vkelompok on sesi_ruang_om.id_kelompok = vkelompok.id_kelompok  WHERE vkelompok.id_thn = ".get_id_active_year());
                $ruang = db_read("select id_ruang, max_kuota from vdivroom where id_acara='2'");
                $msg = NULL;
                if(count($ruang) > 0){
                    $kloter = db_read("select * from kloter where id_thn='".get_year(get_active_year())."'");
                    if(count($kloter) > 0){
                        foreach($kloter as $k_kloter => $v_kloter){
                            $query = "select id from kelompok kel where not exists(select id_kelompok from sesi_ruang_om om where om.id_kelompok=kel.id) and id_kloter='".$v_kloter['id']."'";
                            $sql = db_read($query);
                            if(count($sql) > 0){
                                $a = 0;
                                foreach($sql as $key => $value){
                                    $data = array(
                                        "id_kelompok" => $value['id'],
                                        "id_ruang" => $ruang[$a]['id_ruang']
                                    );
                                    if(db_insert($def_table[2], $data)){
                                        $msg = "true 2";
                                    }else{
                                        $msg = $_SESSION['err_message'];
                                    }
                                    $a += abs($key%2);
                                    
                                }
                            } else {
                                echo "Proses Selesai";
                                break;
                            }
                        }
                    } else {
                        echo "Kloter belum ditetapkan.";
                    }
                    // foreach ($ruang as $k_ruang => $v_ruang) {
                    //     $jumlahMhs = db_read("select count(npm) as jumlah from sesi_ruang_om where id_ruang='".$v_ruang['id_ruang']."'");
                    //     $available_quotas = $v_ruang['max_kuota'] - $jumlahMhs[0]['jumlah'];
                    //     if($available_quotas > 0){
                    //         $query = "SELECT npm FROM mahasiswa mhs where not exists(select npm from sesi_ruang_om om where om.npm = mhs.npm) order by rand() limit " . $v_ruang['max_kuota'];
                    //         $sql = db_read($query);
                            
                    //         if(count($sql) > 0){
                    //             foreach ($sql as $key => $value) {
                    //                 $data = array(
                    //                             "npm" => $value['npm'],
                    //                             "id_ruang" => $v_ruang['id_ruang']
                    //                 );
                    //                 if(db_insert($def_table[2], $data)){
                    //                     $msg = "true";
                    //                 }else{
                    //                     $msg = $_SESSION['err_message'];
                    //                 }
                    //             }
                    //         }else{
                    //             $msg = "Proses Selesai";
                    //             break;
                    //         }
                    //     }
                    // }
                    // echo $msg;
                }else{
                    echo "Ruang belum ditetapkan";
                }
            }elseif($table == $def_table[3]){
                db_free_query("TRUNCATE sesi_ruang_pk");
                $ruang = db_read("select id_ruang, max_kuota from vdivroom where id_acara='1'");
                $kloter = db_read("select * from kloter");
                $msg = NULL;
                if(count($kloter) > 0){
                if(count($ruang) > 0){
                    $tanggal = db_read("select tanggal_mulai, tanggal_selesai from acara_tahun where id_acara='1'");
                    if(count($tanggal) > 0){
                        $dates = getBetweenDates($tanggal[0]['tanggal_mulai'],$tanggal[0]['tanggal_selesai']);
                        db_free_query("set foreign_key_checks=0");
                        db_free_query("insert into sesi_ruang_pk(npm) select npm from mahasiswa");
                        db_free_query("set foreign_key_checks=1");
                        // db_free_query("set foreign_key_checks=0;insert into sesi_ruang_pk(npm) select npm from mahasiswa");
                        // if(db_free_query("set foreign_key_checks=0;insert into sesi_ruang_pk(npm) select npm from mahasiswa;set foreign_key_checks=1;")){
                        // }else{
                        //     echo "Gagal memasukkan data.";
                        // }
                        $start = 1;
                        $end = 0;
                        foreach($dates as $date){
                            $sessions = db_read("select * from sesi where id_acara='1' and tanggal='".$date."'");
                            // print_r($sessions);
                            // print_r($ruang);
                            foreach($sessions as $session){
                                foreach($ruang as $v_ruang){
                                    $end = $end + $v_ruang['max_kuota'];
                                    db_free_query("update sesi_ruang_pk set id_ruang='".$v_ruang['id_ruang']."', id_sesi='".$session['id_sesi']."' where id_sesi_pk between ".$start." and ". $end.";");
                                    $start = $end;
                                }
                            }
                        }
                    }else{
                        echo "Tanggal belum ditetapkan";
                    }
                }else{
                    echo "Ruang belum ditetapkan";
                }
                } else {
                    echo "kloter belum ditetapkan";
                }
            }
        }
        
    }elseif($op == "read"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[0] where id_sesi='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[0]"));
                }
                
            }else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_sesi_oh='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                    echo json_last_error_msg();
                }
                
            }else if($table == $def_table[2]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[2] where id_sesi_om='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[2]"));
                }
                
            }else if($table == $def_table[3]){
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[3] where id_sesi_pk='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[3]"));
                }
            }
        }
        
    }elseif($op == "read_full"){
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                if(!is_null($id)){
                    echo json_encode(db_read("select * from vsesi where id_sesi='$id'"));
                }else{
                    echo json_encode(db_read("select * from vsesi"));
                }
            }else if($table == $def_table[1]){
                if(!is_null($id)){
                    echo json_encode(db_read("select * from vsesi_oh where id_sesi_oh='$id' and id_thn='".get_year(get_active_year())."'"));
                }else{
                    echo json_encode(db_read("select * from vsesi_oh where id_thn='".get_year(get_active_year())."'"));
                }
            }else if($table == $def_table[2]){
                if(!is_null($id)){
                    echo json_encode(db_read("select * from vsesi_om where id_sesi_om='$id'"));
                }else{
                    echo json_encode(db_read("select * from vsesi_om"));
                }
            }else if($table == $def_table[3]){
                if(!is_null($id)){
                    echo json_encode(db_read("select * from vsesi_pk where id_sesi_pk='$id'"));
                }else{
                    echo json_encode(db_read("select * from vsesi_pk"));
                }
            }
        }
    }elseif($op == "update"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){
                    if(db_update($def_table[0], $data, array("id_sesi" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_update($def_table[1], $data, array("id_sesi_oh" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }else if($table == $def_table[2]){
                
                if(is_null($id) == FALSE){
                   
                    if(db_update($def_table[2], $data, array("id_sesi_om" => $id))){
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
                    
                    if(db_delete($def_table[0], array("id_sesi" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    $id_kel = isset($_GET['id_kel']) ? cleanchar($_GET['id_kel']) : NULL;
                    if(db_delete($def_table[1], array("id_sesi_oh" => $id))){
                        $photo = getcwd().'/resource/mahasiswa/file_kehadiran_ortu/'.cleanchar($_GET['npm']).'.jpg';
                        if(file_exists($photo)){
                            unlink($photo);
                        }
                        if(db_update("keluarga",array("file_kehadiran"=>""),array("id_kel"=>$id_kel))){
                            echo "true";
                        }else{
                            if(($_SESSION['err_message']) == ""){
                                echo "true";
                            }else{
                                echo $_SESSION['err_message'];
                            }
                        }
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[2]){
                
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[2], array("id_sesi_om" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
                
            }else if($table == $def_table[3]){
                if(is_null($id) == FALSE){
                    if(db_delete($def_table[3], array("id_sesi_pk" => $id))){
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
