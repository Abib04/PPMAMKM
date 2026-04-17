<?php
// ini_set('memory_limit', '44M');
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");


function getClosest($search, $arr) {
   $closest = null;$idxclosest = null;
   $terbesar = null;$val_terbesar = null;
   // var_dump($arr);echo "<br/>";

   foreach ($arr as $idx=>$item) {
      $terbesar = $idx;$val_terbesar=$item;

      if ($closest === null || abs($search - $closest) > abs($item - $search)) {
         if($search <= $item){
         	$closest = $item;$idxclosest=$idx;
         }
      }
   }

   // var_dump($search);

   if ($closest == null) {
        return array('idx'=>$terbesar, 'val'=>$val_terbesar);
   } else {
        return array('idx'=>$idxclosest, 'val'=>$closest);
   }
   
}

// $id_acara = array();
// $sql = db_read("select id_acara from acara where method=0");
// foreach ($sql as $key => $value) {
//     $id_acara[] = $value['id_acara'];
// }

$def_table = "acara_ruang_kelompok";
$def_table_fakultas = "acara_ruang_fakultas";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

if(is_null($op)){
    echo "tidak ada op";
    //include "error/page_404.php";
    
}else{
    
    
    $acara_id = (isset($_GET['acara']))? cleanchar($_GET['acara']) : null;
    $thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_id_active_year();
    if(!is_null($acara_id)){
    //$sql = db_read("SELECT * FROM `acara` WHERE `id_acara` = ".$acara_id);
    $sql = db_read("SELECT * FROM `vacara` WHERE `id_acara` = ".$acara_id. " AND `id_thn` = ".$thn);
    
    if(count($sql) > 0){
        
        if($op == "div"){
            //Method tabel view vacara:
            //1. Pembagian by kelompok
            //2. Pembagian by fakultas
            //3. Pembagian by kelompok dengan jumlah ruangan sama (dengan yang "Pembagian ruangan") di setiap kloter dan sesi
            //4. Pembagian by prodi
            if($sql[0]['method_th']==1){
                //1. Pembagian By Kelompok
                // $hasil = false;
                // $room = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = $acara_id and id_thn=".get_id_active_year());
                // // print_r($room);
                // // echo "<hr>";
                // if(count($room) > 0){
                //     $sesi = db_read("SELECT id_sesi,id_kloter FROM vsesi_kloter WHERE id_acara = $acara_id and id_thn=".get_id_active_year());
                //     if(count($sesi) > 0){
                //         // print_r($sesi);
                //         foreach ($sesi as $k_sesi => $v_sesi) {
                //             db_delete("acara_ruang_kelompok",array("id_sesi"=>$v_sesi['id_sesi']));
                //             // echo "test";
                //             $list_sesi = "";
                //             $l_sesi = db_read("SELECT `id_sesi` FROM `vsesi_kloter` WHERE `id_kloter` = ".$v_sesi['id_kloter']." and id_acara = $acara_id");
                //             foreach ($l_sesi as $key => $value) {
                //                 $list_sesi .= "'".$value['id_sesi']."', ";
                //             }
                //             $list_sesi = rtrim($list_sesi,", ");
                //             $i_room = 0;
                //             $kelompok = db_read("SELECT * FROM kelompok where id_kloter=".$v_sesi['id_kloter']." and id NOT in (SELECT id_kelompok FROM acara_ruang_kelompok where id_sesi in (".$list_sesi."))");
                //             $kuota_room = $room[$i_room]['max_kuota'];
                //             // echo "<hr>";
                //             // echo count($kelompok);
                            
                //             for ($kel = 0 ; $kel < count($kelompok) ;$kel++) {
                //                 pindah:
                                
                //                 $jummhs = count(db_read("select npm from mahasiswa where id_kelompok=".$kelompok[$kel]['id']));
                //                 // echo $kuota_room."-".$jummhs;
                //                 if($kuota_room >= $jummhs){
                                    
                //                     $data = array("id_kelompok"=>$kelompok[$kel]['id'],"id_ruang" => $room[$i_room]['id_ruang'], "id_sesi" => $v_sesi['id_sesi']);
                //                     if(db_insert($def_table, $data)){
                                        
                //                         $kuota_room = $kuota_room-$jummhs;
                //                         // echo "<br>Kelompok ".$kelompok[$kel]['id']. " : ";
                //                         // echo " = ".$kuota_room;
                //                         // echo " sesi ".$v_sesi['id_sesi'];
                //                         // echo " ruangan ".$room[$i_room]['id_ruang'];
                //                         $hasil = true;
                //                     }else{
                //                         echo $_SESSION['err_message'];
                //                     }
                //                 } else {
                //                     $i_room++;
                //                      $kuota_room = $room[$i_room]['max_kuota'];
                //                     goto pindah;
                //                 }
                                
                //             }
                //         }
                //     } else {
                //         echo "Maaf, Sesi tidak tersedia";
                //     }

                
                // } else {
                //     echo "Maaf, Ruangan untuk acara ini belum ditentukan!";
                // }
                // if($hasil){
                //     echo "Sukses ....";
                // }
                
                
                /*
                $kloter  = db_read("SELECT * FROM `kloter` WHERE id_thn = ".get_id_active_year());
                foreach ($kloter as $key => $value) {
                    $sesi = db_read("SELECT * FROM `vsesi_kloter` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year()." AND id_kloter = ".$value['id']);
                    $jm_sesi = count($sesi);
                    $kelompok = db_read("SELECT kelompok.id as id_kelompok, ifnull(count(mahasiswa.npm),0) as jumlah FROM kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok  WHERE kelompok.id_kloter = ".$value['id']." AND mahasiswa.id_thn = ".get_id_active_year()." GROUP BY kelompok.id ORDER BY kelompok.id");
                    $jml_kelompok = count($kelompok);
                    $kontrol = $jml_kelompok;
                    $per_sesi = ceil($jml_kelompok/$jm_sesi);
                    $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                    $jum_ruang = count($ruang);
                    $sukses = 0;
                    $gagal = 0;
                    echo 'jumlah sesi '.$value['id'].' jumlah kelompok '.$jml_kelompok.' jumlah ruang '.$jum_ruang.'<br />';
                        $s = 0;
                        $i_ruangan = 0;
                        $kuota = $ruang[0]['max_kuota'];
                        for($i = 0; $i < $jml_kelompok; $i++){
                            pindah_ruang2: 
                            if($i_ruangan == $jum_ruang){
                                $s++;
                                $i_ruangan = 0;
                                $kuota = $ruang[$i_ruangan]['max_kuota'];
                                if($s == $jm_sesi){
                                    break;
                                }
                            }
                            if($kuota >= $kelompok[$i]['jumlah']){
                                $data = array(
                                            'id_sesi' => $sesi[$s]['id_sesi'],
                                            'id_ruang' => $ruang[$i_ruangan]['id_ruang'],
                                            'id_kelompok' => $kelompok[$i]['id_kelompok']
                                        );               
                                if(db_insert($def_table,$data)){
                                    $sukses++;
                                } else {
                                    $gagal++;
                                }
                                $kuota -= $kelompok[$i]['jumlah'];
                            } else {
                                $i_ruangan++;
                                $kuota = $ruang[$i_ruangan]['max_kuota'];
                                goto pindah_ruang2;
                            }
                        }
                    echo "Berhasil : ".$sukses." kelompok dan Gagal : ".$gagal." kelompok.".$_SESSION['err_message'];
                }
                */
                
                /* UPDATE AGUSTUS 2022 */
                $newLine = "\r\n";
                $sesi = db_read("SELECT * FROM `vsesi` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year());
                $jm_sesi = count($sesi);
                $kelompok = db_read("SELECT kelompok.id as id_kelompok, ifnull(count(mahasiswa.npm),0) as jumlah 
                                    FROM kelompok 
                                    left join mahasiswa on kelompok.id = mahasiswa.id_kelompok
                                    LEFT JOIN kloter ON kelompok.id_kloter=kloter.id
                                    WHERE mahasiswa.id_thn = ".get_id_active_year()." 
                                    AND kloter.id_thn=".get_id_active_year()."
                                    GROUP BY kelompok.id ORDER BY kelompok.id");

                // var_dump($kelompok);
                $jml_kelompok = count($kelompok);
                $kontrol = $jml_kelompok;
                $per_sesi = ceil($jml_kelompok/$jm_sesi);
                $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY prioritas DESC, id_ruang ASC");
                $jum_ruang = count($ruang);
                $sukses = 0;
                $gagal = 0;
                echo 'jumlah sesi '.$jm_sesi.' jumlah kelompok '.$jml_kelompok.' jumlah ruang '.$jum_ruang.$newLine;
                
                $s = 0;
                $i_ruangan = 0;
                $kuota = $ruang[0]['max_kuota'];
                
                for($i = 0; $i < $jml_kelompok; $i++){
                    pindah_ruang_1: 
                    if($i_ruangan == $jum_ruang){
                        $s++;
                        $i_ruangan = 0;
                        $kuota = $ruang[$i_ruangan]['max_kuota'];
                        if($s == $jm_sesi){
                            break;
                        }
                    }
                    if($kuota >= $kelompok[$i]['jumlah']){
                        
                        //Cek Data terlebih Dahulu
                        $cek = db_read("SELECT id_kelompok FROM acara_ruang_kelompok WHERE id_kelompok = ".$kelompok[$i]['id_kelompok']." AND id_sesi=".$sesi[$s]['id_sesi']);
                        if(count($cek)>0){
                            $gagal++;
                        }else{
                        
                            $data = array(
                                        'id_sesi' => $sesi[$s]['id_sesi'],
                                        'id_ruang' => $ruang[$i_ruangan]['id_ruang'],
                                        'id_kelompok' => $kelompok[$i]['id_kelompok']
                                    );      
                           
                            if(db_insert($def_table,$data)){
                                $sukses++;
                                $kuota -= $kelompok[$i]['jumlah'];
                            } else {
                                $gagal++;
                            }
                        }
                        
                    } else {
                        $i_ruangan++;
                        $kuota = $ruang[$i_ruangan]['max_kuota'];
                        goto pindah_ruang_1;
                    }
                }
                echo "Berhasil : ".$sukses." kelompok dan Gagal : ".$gagal.$newLine;
                        
                /* END UPDATE */
                
                //echo "Pembagian By Kelompok";
            }elseif ($sql[0]['method_th']==2) {
                //2. Pembagian by fakultas
                $newLine = "\r\n";
                
                /* Sebelum dibuatkan Sesi di Fakultas */
                /*
                
                $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                $jum_ruang = count($ruang);
                //echo "Pembagian BY FAKULTAS";
                $fakultas  = db_read("SELECT * FROM `fakultas`");
                $i_ruangan = 0;
                foreach ($fakultas as $key => $value) {
                    if($key>0){
                        $i_ruangan++; // Tiap Ganti Fakultas, ganti Ruangan
                    }
                    
                    $mhs_fakultas = db_read("SELECT npm, nama_fakultas FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id JOIN `fakultas` f ON p.id_fakultas=f.id WHERE m.id_thn = ".get_id_active_year()." AND f.id=".$value['id']);
                    $jml_mhs_fakultas = count($mhs_fakultas);
                    $kontrol = $jml_mhs_fakultas;
                    
                    $sukses = 0;
                    $gagal = 0;
                    
                    $kuota = $ruang[0]['max_kuota'];
                    
                    for($i = 0; $i < $jml_mhs_fakultas; $i++){
                        //pindah_ruang2:
                        if($i_ruangan == $jum_ruang){
                            $i_ruangan = 0;
                            $kuota = $ruang[$i_ruangan]['max_kuota'];
                        }
                        if($kuota >= $kelompok[$i]['jumlah']){
                            
                            //Cek Data terlebih Dahulu
                            $cek = db_read("SELECT npm FROM acara_ruang_fakultas WHERE npm = ".$mhs_fakultas[$i]['npm']." AND id_acara_tahun=".$sql[0]['id_acara_thn']);
                            if(count($cek)>0){
                                $gagal++;
                            }else{
                                $data = array(
                                            'npm' => $mhs_fakultas[$i]['npm'],
                                            'id_ruang' => $ruang[$i_ruangan]['id_ruang'],
                                            'id_fakultas' => $value['id'],
                                            'id_acara_thn' => $sql[0]['id_acara_thn']
                                        );      
                               
                                if(db_insert($def_table_fakultas,$data)){
                                    $sukses++;
                                    $kuota -= $kelompok[$i]['jumlah'];
                                } else {
                                    $gagal++;
                                }
                            }
                            
                        } else {
                            $i_ruangan++;
                            $kuota = $ruang[$i_ruangan]['max_kuota'];
                            //goto pindah_ruang2;
                        }
                    }
                    
                    echo "Berhasil : ".$sukses." mahasiswa fakultas ".$value['nama_fakultas']." dan Gagal : ".$gagal.$newLine;
                    
                }*/
                
                // Setelah dibuatkan Sesi
                // $sesi = db_read("SELECT * FROM `vsesi` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year());
                // $jm_sesi = count($sesi);
                // $fakultas = db_read("SELECT f.id as id_fakultas, ifnull(count(m.npm),0) as jumlah 
                //                         FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id 
                //                         JOIN `fakultas` f ON p.id_fakultas=f.id 
                //                         WHERE m.id_thn = ".get_id_active_year()."
                //                         GROUP BY f.id ORDER BY f.id");
                // $jml_fakultas = count($fakultas);
                // $kontrol = $jml_fakultas;
                // //$per_sesi = ceil($jml_fakultas/$jm_sesi);
                // $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY prioritas ASC");
                // $jum_ruang = count($ruang);
                
                // $s = 0;
                // $i_ruangan = 0;
                // $kuota = $ruang[0]['max_kuota'];
                
                // $fakultas_all  = db_read("SELECT * FROM `fakultas`");
                // $i_ruangan = 0;
                // foreach ($fakultas_all as $key => $value) {
                //     if($key>0){
                //         $i_ruangan++; // Tiap Ganti Fakultas, ganti Ruangan
                //     }
                    
                //     $mhs_fakultas = db_read("SELECT npm, nama_fakultas FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id JOIN `fakultas` f ON p.id_fakultas=f.id WHERE m.id_thn = ".get_id_active_year()." AND f.id=".$value['id']);
                //     $jml_mhs_fakultas = count($mhs_fakultas);
                //     $kontrol = $jml_mhs_fakultas;
                //     $per_sesi = ceil(1/$jm_sesi);
                    
                //     $sukses = 0;
                //     $gagal = 0;
                    
                //     $kuota = $ruang[0]['max_kuota'];
                    
                //     for($i = 0; $i < $jml_mhs_fakultas; $i++){
                //         pindah_ruang2:
                //         if($i_ruangan == $jum_ruang){
                //             $s++;
                //             $i_ruangan = 0;
                //             $kuota = $ruang[$i_ruangan]['max_kuota'];
                //             if($s == $jm_sesi){
                //                 break;
                //             }
                //         }
                //         if($kuota >= $fakultas[$i]['jumlah']){
                            
                //             //Cek Data terlebih Dahulu
                //             $cek = db_read("SELECT npm FROM acara_ruang_fakultas WHERE npm = ".$mhs_fakultas[$i]['npm']." AND id_sesi=".$sesi[$s]['id_sesi']);
                //             if(count($cek)>0){
                //                 $gagal++;
                //             }else{
                //                 $data = array(
                //                             'npm' => $mhs_fakultas[$i]['npm'],
                //                             'id_ruang' => $ruang[$i_ruangan]['id_ruang'],
                //                             'id_sesi' => $sesi[$s]['id_sesi']
                //                         );      
                               
                //                 if(db_insert($def_table_fakultas,$data)){
                //                     $sukses++;
                //                     $kuota -= 1; // kurangi satu karena tiap mahasiswa
                //                 } else {
                //                     $gagal++;
                //                 }
                //             }
                            
                //         } else {
                //             $i_ruangan++;
                //             $kuota = $ruang[$i_ruangan]['max_kuota'];
                //             goto pindah_ruang2;
                //         }
                //     }
                    
                //     echo "Berhasil : ".$sukses." mahasiswa fakultas ".$value['nama_fakultas']." dan Gagal : ".$gagal.$newLine;
                    
                // }

                // Update Sept 2024

                //3. Pembagian by Fakultas Prodi
                // 2,11,1,12,22,21,83,82,62,60,61  => gabungan FIK
                // 91,92,93,94,95,96,67 => gabungan FES
                // 84,85,86 => gabungan FST                
                // $gb1 = array(2,11,1,12,22,21,83,82,62,60,61);
                // $gb2 = array(91,92,93,94,95,96,67);
                // $gb3 = array(84,85,86);               

                // Kasus yang bergabung dalam 1 ruangan hanya FIK
                $gb1 = array(2,11,1,12,22,21,83,82,62,60,61);
                $gb2 = array(96, 67); //Ilkom dan Internasional
                $gb3 = array(84); //satu aja
                
                $newLine = "\r\n";
                $sesi = db_read("SELECT * FROM `vsesi` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year());
                $jm_sesi = count($sesi);
                $prodi = db_read("SELECT p.kode as kode, ifnull(count(m.npm),0) as jumlah 
                                        FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id 
                                        JOIN `fakultas` f ON p.id_fakultas=f.id 
                                        WHERE m.id_thn = ".get_id_active_year()."
                                        GROUP BY p.kode ORDER BY p.id_fakultas ASC");
                $prodi_mhs = array();
                foreach ($prodi as $key => $value) {
                    $prodi_mhs[$value['kode']] = $value['jumlah'];
                }
                //Urutkan dari yang terbanyak
                arsort($prodi_mhs);
                
                $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY max_kuota DESC, id_ruang ASC");
                $jum_ruang = count($ruang);
                $dt_ruang = array();
                foreach ($ruang as $key => $value) {
                    $dt_ruang[$value['id_ruang']] = $value['max_kuota'];
                }
                //Urutkan dari yang terbanyak
                arsort($dt_ruang);

                $prodi  = db_read("SELECT * FROM `prodi`");
                $dt_prodi = array();
                foreach ($prodi as $key => $value) {
                    $kode = $value['kode'];
                    if(in_array($kode, $gb1)){
                        $txt = implode("",$gb1);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb2)){
                        $txt = implode("",$gb2);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb3)){
                        $txt = implode("",$gb3);
                        $dt_prodi[$txt][] = $value;
                    }else{
                        $dt_prodi[$kode][] = $value;
                    }
                }
                
                //////////////////////////////////////////
                $s=0; //sesi hanya 1

                foreach($dt_prodi as $key => $arrData){
                    
                    $jml_total_mhs_prodi = 0;
                    $nama_kode_prodi = array();
                    $dt_mhs_prodi = array();
                    foreach($arrData as $idx => $value){
                        //Get Jumlah Mahasiswa Per Prodi Yang dikonfirmasi
                        $dt_mhs_prodi[$value['id']] = db_read("SELECT npm, nama_prodi, p.kode FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id JOIN `fakultas` f ON p.id_fakultas=f.id WHERE m.id_thn = ".get_id_active_year()." AND m.konfirmasi='Y' AND p.id=".$value['id']);
                        $jml_mhs_prodi = count($dt_mhs_prodi[$value['id']]);
                        $jml_total_mhs_prodi += $jml_mhs_prodi;
                        
                        $nama_kode_prodi[] = $value['nama_prodi'];
                    }
                    
                    $sukses = 0;
                    $gagal = 0;
                    
                    //CARI RUANGAN KUOTA YANG SESUAI

                    $counter_sisa_mhs = $jml_total_mhs_prodi;
                    $arr_ruangan = [];

                    while ( $counter_sisa_mhs > 0) {
                        $cari = getClosest($counter_sisa_mhs, $dt_ruang);
                        $counter_sisa_mhs -= $cari['val'];

                        $arr_ruangan[] = $cari;
                        unset($dt_ruang[$cari['idx']]);
                    }

                    // var_dump($arr_ruangan);

                    $indeks_ruang = 0;
                    foreach($dt_mhs_prodi as $id_prodi=>$arrDataProdiMhs){

                        $urt_mhs = 1;

                        foreach($arrDataProdiMhs as $idx=>$value){

                            $sql = "SELECT npm FROM acara_ruang_fakultas WHERE npm = '".$value['npm']."' AND id_sesi=".$sesi[$s]['id_sesi'];

                            $cek = db_read($sql);
                            if(count($cek)>0){
                                $gagal++;
                            }else{
                                $data = array(
                                    'npm' => $value['npm'],
                                    'id_ruang' => $arr_ruangan[$indeks_ruang]['idx'],
                                    'id_sesi' => $sesi[$s]['id_sesi']
                                );      

                                // echo "<hr/> $urt_mhs . ";
                                // var_dump($data);
                                // echo "<hr/>";


                                if(db_insert($def_table_fakultas,$data)){

                                    $sukses++;

                                } else {

                                    $gagal++;

                                }
                            }

                            $arr_ruangan[$indeks_ruang]['val']--;
                            $urt_mhs++;
                            if ($arr_ruangan[$indeks_ruang]['val'] == 0) {
                                $indeks_ruang++;
                                $urt_mhs = 1;
                            }

                            /*if ($indeks_ruang >= count($arr_ruangan)) {
                                break;
                            }*/
                        }                 
                        
                    }                    
                    
                    echo "Total Mahasiswa prodi ".implode(",",$nama_kode_prodi)." : $jml_total_mhs_prodi, Berhasil : ".$sukses." mahasiswa dan Gagal : ".$gagal.$newLine.'<br>';
                    
                }


                // end Update sept 2024
                
                
            } elseif ($sql[0]['method_th']==3) {
                //3. Pembagian by kelompok dengan jumlah ruangan sama (dengan yang "Pembagian ruangan") di setiap kloter dan sesi
                
                /*$sesi_ruang = db_read("SELECT vsesi.id_sesi,vdivroom.id_ruang, vdivroom.max_kuota AS kuota FROM vsesi LEFT JOIN vdivroom on vsesi.id_acara = vdivroom.id_acara AND vsesi.id_thn = vdivroom.id_thn WHERE vsesi.id_thn = ".get_id_active_year()." AND vsesi.id_acara = ".$acara_id." GROUP BY vsesi.id_sesi,vdivroom.id_ruang Order by vsesi.id_sesi,vdivroom.max_kuota asc") ;
                $harus_pisah = array(15,16,array(3,6,7,20),array(22,21,4,8));
                
                $index_sesi = 0;
                $sukses = 0;
                $gagal = 0;
                foreach ($harus_pisah as $key => $value) {
                    $where_in = '';
                    if(is_array($value)){
                        $where_in = 'IN (';
                        foreach ($value as $k => $v) {
                            $where_in .= ($k==0)? $v: ', '.$v;
                        }
                        $where_in .= ')';
                    } else {
                        $where_in = ' = '.$value;
                    }
                    $index_mhs = 0;
                    $query = "SELECT n.npm FROM mahasiswa n WHERE n.konfirmasi='Y' AND n.id_thn = ".get_id_active_year()." AND n.id_prodi ".$where_in." group by n.id_prodi,n.npm";
                    $mahasiswa = db_read($query);
                    while(count($mahasiswa)>$index_mhs){
                        if($sesi_ruang[$index_sesi]['kuota'] == 0 )
                            $index_sesi++;
                        $data['npm'] = $mahasiswa[$index_mhs]['npm'];
                        $data['id_sesi'] = $sesi_ruang[$index_sesi]['id_sesi'];
                        $data['id_ruang'] = $sesi_ruang[$index_sesi]['id_ruang'];
                        if(db_insert('acara_ruang_person',$data)){
                            $index_mhs++;
                            $sesi_ruang[$index_sesi]['kuota']--;
                            $sukses++;
                        } else {
                            $gagal++;
                        }
                    }
                    $index_sesi++;
                }
            
                $sesi_ruang2 = db_read("SELECT vsesi.id_sesi,vdivroom.id_ruang,ifnull(vdivroom.max_kuota-a.jumlah,vdivroom.max_kuota) AS kuota FROM vsesi LEFT JOIN vdivroom on vsesi.id_acara = vdivroom.id_acara AND vsesi.id_thn = vdivroom.id_thn left join (SELECT `id_sesi`, `id_ruang`, count(`npm`) as jumlah FROM `acara_ruang_person` group by `id_sesi`, `id_ruang`) a on vsesi.id_sesi = a.id_sesi and vdivroom.id_ruang = a.id_ruang WHERE vsesi.id_thn = ".get_id_active_year()." AND vsesi.id_acara = ".$acara_id." AND (ifnull(vdivroom.max_kuota-a.jumlah,vdivroom.max_kuota)) <> 0 ") ;
                $mahasiswa2 = db_read("SELECT n.npm FROM mahasiswa n WHERE n.konfirmasi='Y' AND n.id_thn = ".get_id_active_year()." AND n.id_prodi not in(15,16,3,6,7,20,22,21,4,8)");
                $index_sesi = 0;
                $index_mahasiswa = 0;
                while($index_mahasiswa < count($mahasiswa2)){
                    if($sesi_ruang2[$index_sesi]['kuota'] == 0)
                        $index_sesi++;
                    $data['npm'] = $mahasiswa2[$index_mahasiswa]['npm'];
                    $data['id_sesi'] = $sesi_ruang2[$index_sesi]['id_sesi'];
                    $data['id_ruang'] = $sesi_ruang2[$index_sesi]['id_ruang'];
                    if(db_insert('acara_ruang_person',$data)){
                        $index_mahasiswa++;
                        $sesi_ruang2[$index_sesi]['kuota']--;
                        $sukses++;
                    } else {
                        $gagal++;
                    }
                }
                echo "Total sukses : ".$sukses." dan Total Gagal : ".$gagal;*/
                
                /* --------------- START UPDATE 7 AGUSTUS 2022 ------------------ */
                //$def_table = "acara_ruang_kelompok_tes";
                $newLine = "\r\n";
                
                $kloter  = db_read("SELECT * FROM `kloter` WHERE id_thn = ".get_id_active_year());
                foreach ($kloter as $key => $value) {
                    $sesi = db_read("SELECT * FROM `vsesi_kloter` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year()." AND id_kloter = ".$value['id']);
                    $jm_sesi = count($sesi);
                    if($jm_sesi == 0){
                        echo 'tidak ditemukan sesi '.$value['nama_kloter'].$newLine;
                    }else{
                        $kelompok = db_read("SELECT kelompok.id as id_kelompok, ifnull(count(mahasiswa.npm),0) as jumlah FROM kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok  WHERE kelompok.id_kloter = ".$value['id']." AND mahasiswa.id_thn = ".get_id_active_year()." GROUP BY kelompok.id ORDER BY kelompok.id");
                        $jml_kelompok = count($kelompok);
                        $kontrol = $jml_kelompok;
                        $per_sesi = ceil($jml_kelompok/$jm_sesi);
                        $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY prioritas DESC, id_ruang ASC");
                        $jum_ruang = count($ruang);
                        $sukses = 0;
                        $gagal = 0;
                        echo 'jumlah sesi '.$jm_sesi.' jumlah kelompok '.$jml_kelompok.' jumlah ruang '.$jum_ruang.$newLine;
                        $s = 0;
                        $i_ruangan = 0;
                        $kuota = $ruang[0]['max_kuota'];
                        
                        for($i = 0; $i < $jml_kelompok; $i++){
                            pindah_ruang3: 
                            if($i_ruangan == $jum_ruang){
                                $s++;
                                $i_ruangan = 0;
                                $kuota = $ruang[$i_ruangan]['max_kuota'];
                                if($s == $jm_sesi){
                                    break;
                                }
                            }
                            if($kuota >= $kelompok[$i]['jumlah']){
                                
                                //Cek Data terlebih Dahulu
                                $cek = db_read("SELECT id_kelompok FROM acara_ruang_kelompok WHERE id_kelompok = ".$kelompok[$i]['id_kelompok']." AND id_sesi=".$sesi[$s]['id_sesi']);
                                if(count($cek)>0){
                                    $gagal++;
                                }else{
                                
                                    $data = array(
                                                'id_sesi' => $sesi[$s]['id_sesi'],
                                                'id_ruang' => $ruang[$i_ruangan]['id_ruang'],
                                                'id_kelompok' => $kelompok[$i]['id_kelompok']
                                            );      
                                   
                                    if(db_insert($def_table,$data)){
                                        $sukses++;
                                        $kuota -= $kelompok[$i]['jumlah'];
                                    } else {
                                        $gagal++;
                                    }
                                }
                                
                            } else {
                                $i_ruangan++;
                                $kuota = $ruang[$i_ruangan]['max_kuota'];
                                goto pindah_ruang3;
                            }
                        }
                        echo "Berhasil : ".$sukses." kelompok dan Gagal : ".$gagal.$newLine;
                    }
                }
                /* --------------- END UPDATE 7 AGUSTUS 2022 ------------------ */
                
            } elseif ($sql[0]['method_th']==4) {

                //4. Pembagian by prodi
                // 11, 61 => gabungan1
                // 12, 62 => gabungan2
                // 96, 67 => gabungan3
                // 82, 60 => gabungan4
                $gb1 = array(11, 61, 21);
                $gb2 = array(12, 62, 22);
                $gb3 = array(96, 67);
                $gb4 = array(82, 60);

                
                
                $newLine = "\r\n";
                $sesi = db_read("SELECT * FROM `vsesi` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year());
                $jm_sesi = count($sesi);
                $prodi = db_read("SELECT p.kode as kode, ifnull(count(m.npm),0) as jumlah 
                                        FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id 
                                        JOIN `fakultas` f ON p.id_fakultas=f.id 
                                        WHERE m.id_thn = ".get_id_active_year()."
                                        GROUP BY p.kode ORDER BY p.id_fakultas ASC");
                $prodi_mhs = array();
                foreach ($prodi as $key => $value) {
                    $prodi_mhs[$value['kode']] = $value['jumlah'];
                }
                //Urutkan dari yang terbanyak
                arsort($prodi_mhs);
                
                $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY max_kuota DESC, id_ruang ASC");
                $jum_ruang = count($ruang);
                $dt_ruang = array();
                foreach ($ruang as $key => $value) {
                    $dt_ruang[$value['id_ruang']] = $value['max_kuota'];
                }
                //Urutkan dari yang terbanyak
                arsort($dt_ruang);

                $prodi  = db_read("SELECT * FROM `prodi`");
                $dt_prodi = array();
                foreach ($prodi as $key => $value) {
                    $kode = $value['kode'];
                    if(in_array($kode, $gb1)){
                        $txt = implode("",$gb1);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb2)){
                        $txt = implode("",$gb2);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb3)){
                        $txt = implode("",$gb3);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb4)){
                        $txt = implode("",$gb4);
                        $dt_prodi[$txt][] = $value;
                    }else{
                        $dt_prodi[$kode][] = $value;
                    }
                }
                
                //////////////////////////////////////////
                $s=0; //sesi hanya 1

                foreach($dt_prodi as $key => $arrData){
                    
                    $jml_total_mhs_prodi = 0;
                    $nama_kode_prodi = array();
                    $dt_mhs_prodi = array();
                    foreach($arrData as $idx => $value){
                        //Get Jumlah Mahasiswa Per Prodi Yang dikonfirmasi
                        $dt_mhs_prodi[$value['id']] = db_read("SELECT npm, nama_prodi, p.kode FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id JOIN `fakultas` f ON p.id_fakultas=f.id WHERE m.id_thn = ".get_id_active_year()." AND m.konfirmasi='Y' AND p.id=".$value['id']);
                        $jml_mhs_prodi = count($dt_mhs_prodi[$value['id']]);
                        $jml_total_mhs_prodi += $jml_mhs_prodi;
                        
                        $nama_kode_prodi[] = $value['nama_prodi'];
                    }
                    
                    $sukses = 0;
                    $gagal = 0;
                    
                    //CARI RUANGAN KUOTA YANG SESUAI

                    $counter_sisa_mhs = $jml_total_mhs_prodi;
                    $arr_ruangan = [];

                    while ( $counter_sisa_mhs > 0) {
                        $cari = getClosest($counter_sisa_mhs, $dt_ruang);
                        $counter_sisa_mhs -= $cari['val'];

                        $arr_ruangan[] = $cari;
                        unset($dt_ruang[$cari['idx']]);
                    }

                    // var_dump($arr_ruangan);

                    $indeks_ruang = 0;
                    foreach($dt_mhs_prodi as $id_prodi=>$arrDataProdiMhs){

                        $urt_mhs = 1;

                        foreach($arrDataProdiMhs as $idx=>$value){

                            $sql = "SELECT npm FROM acara_ruang_fakultas WHERE npm = '".$value['npm']."' AND id_sesi=".$sesi[$s]['id_sesi'];

                            $cek = db_read($sql);
                            if(count($cek)>0){
                                $gagal++;
                            }else{
                                $data = array(
                                    'npm' => $value['npm'],
                                    'id_ruang' => $arr_ruangan[$indeks_ruang]['idx'],
                                    'id_sesi' => $sesi[$s]['id_sesi']
                                );      

                                // echo "<hr/> $urt_mhs . ";
                                // var_dump($data);
                                // echo "<hr/>";


                                if(db_insert($def_table_fakultas,$data)){

                                    $sukses++;

                                } else {

                                    $gagal++;

                                }
                            }

                            $arr_ruangan[$indeks_ruang]['val']--;
                            $urt_mhs++;
                            if ($arr_ruangan[$indeks_ruang]['val'] == 0) {
                                $indeks_ruang++;
                                $urt_mhs = 1;
                            }

                            /*if ($indeks_ruang >= count($arr_ruangan)) {
                                break;
                            }*/
                        }                 
                        
                    }                    
                    
                    echo "Total Mahasiswa prodi ".implode(",",$nama_kode_prodi)." : $jml_total_mhs_prodi, Berhasil : ".$sukses." mahasiswa dan Gagal : ".$gagal.$newLine.'<br>';
                    
                }
                
                
            
            } elseif ($sql[0]['method_th']==404) {
                //4. Pembagian by prodi
                // 11, 61 => gabungan1
                // 12, 62 => gabungan2
                // 96, 67 => gabungan3
                // 82, 60 => gabungan4
                $gb1 = array(11, 61, 21);
                $gb2 = array(12, 62, 22);
                $gb3 = array(96, 67);
                $gb4 = array(82, 60);
                
                $newLine = "\r\n";
                $sesi = db_read("SELECT * FROM `vsesi` WHERE id_acara=".$acara_id." AND id_thn =".get_id_active_year());
                $jm_sesi = count($sesi);
                $prodi = db_read("SELECT p.kode as kode, ifnull(count(m.npm),0) as jumlah 
                                        FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id 
                                        JOIN `fakultas` f ON p.id_fakultas=f.id 
                                        WHERE m.id_thn = ".get_id_active_year()."
                                        GROUP BY p.kode ORDER BY p.kode");
                $prodi_mhs = array();
                foreach ($prodi as $key => $value) {
                    $prodi_mhs[$value['kode']] = $value['jumlah'];
                }
                //Urutkan dari yang terbanyak
                arsort($prodi_mhs);
                
                $ruang = db_read("SELECT id_ruang, max_kuota FROM vdivroom WHERE id_acara = ".$acara_id." AND id_thn=".get_id_active_year()." ORDER BY max_kuota DESC");
                $jum_ruang = count($ruang);
                $dt_ruang = array();
                foreach ($ruang as $key => $value) {
                    $dt_ruang[$value['id_ruang']] = $value['max_kuota'];
                }
                //Urutkan dari yang terbanyak
                arsort($dt_ruang);

                $prodi  = db_read("SELECT * FROM `prodi`");
                $dt_prodi = array();
                foreach ($prodi as $key => $value) {
                    $kode = $value['kode'];
                    if(in_array($kode, $gb1)){
                        $txt = implode("",$gb1);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb2)){
                        $txt = implode("",$gb2);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb3)){
                        $txt = implode("",$gb3);
                        $dt_prodi[$txt][] = $value;
                    }else if(in_array($kode, $gb4)){
                        $txt = implode("",$gb4);
                        $dt_prodi[$txt][] = $value;
                    }else{
                        $dt_prodi[$kode][] = $value;
                    }
                }
                
                //////////////////////////////////////////
                $s=0; //sesi hanya 1

                foreach($dt_prodi as $key => $arrData){
                    
                    $jml_total_mhs_prodi = 0;
                    $nama_kode_prodi = array();
                    $dt_mhs_prodi = array();
                    foreach($arrData as $idx => $value){
                        //Get Jumlah Mahasiswa Per Prodi
                        $dt_mhs_prodi[$value['id']] = db_read("SELECT npm, nama_prodi, p.kode FROM `mahasiswa` m JOIN `prodi` p ON m.id_prodi=p.id JOIN `fakultas` f ON p.id_fakultas=f.id WHERE m.id_thn = ".get_id_active_year()." AND p.id=".$value['id']);
                        $jml_mhs_prodi = count($dt_mhs_prodi[$value['id']]);
                        $jml_total_mhs_prodi += $jml_mhs_prodi;
                        
                        $nama_kode_prodi[] = $value['nama_prodi'];
                    }
                    
                    $sukses = 0;
                    $gagal = 0;
                    
                    //CARI RUANGAN KUOTA YANG SESUAI
                    $cari = getClosest($jml_total_mhs_prodi, $dt_ruang);
                    $kuota = $cari['val'];
                    echo 'Kuota '.$kuota.', jml = '.$jml_total_mhs_prodi.' => ';

                    echo "<br/>";
                    // echo json_encode($dt_mhs_prodi);
                    echo "<br/>";
                    
                    foreach($dt_mhs_prodi as $id_prodi=>$arrDataProdiMhs){
                        
                        foreach($arrDataProdiMhs as $idx=>$value){
                            
                            if($kuota >= $jml_total_mhs_prodi){

                                // echo $kuota.'<br/>';
                                
                                if($kuota==0) break;
                                
                                //Cek Data terlebih Dahulu
                                $sql = "SELECT npm FROM acara_ruang_fakultas WHERE npm = '".$value['npm']."' AND id_sesi=".$sesi[$s]['id_sesi'];

                                // echo $sql;
                                $cek = db_read($sql);
                                if(count($cek)>0){
                                    $gagal++;
                                }else{
                                    $data = array(
                                                'npm' => $value['npm'],
                                                'id_ruang' => $cari['idx'],
                                                'id_sesi' => $sesi[$s]['id_sesi']
                                            );      
                                   
                                    if(db_insert($def_table_fakultas,$data)){
                                        $sukses++;
                                        $jml_total_mhs_prodi -= 1;
                                        $kuota -= 1; // kurangi satu karena tiap mahasiswa
                                    } else {
                                        $gagal++;
                                        
                                    }
                                }
                            }else {
                                unset($dt_ruang[$cari['idx']]);
                                
                                if(empty($dt_ruang)) break;
                                
                                //$cari = getClosest($jml_total_mhs_prodi, $dt_ruang);
                                //$kuota = $cari['val'];
                            }
                        }
                    }
                    
                    unset($dt_ruang[$cari['idx']]);
                    
                    echo "Berhasil : ".$sukses." mahasiswa prodi ".implode(",",$nama_kode_prodi)." dan Gagal : ".$gagal.$newLine.'<br>';
                    
                }
                
                
            } else{
                echo "Tidak ada method";
            } 
            
            
        }elseif($op == "read"){
            
            if(!is_null($acara_id)){
                // echo json_encode(db_read("SELECT mahasiswa.nama, mahasiswa.npm, `vjadwalbykelompok`.* FROM mahasiswa RIGHT JOIN `vjadwalbykelompok` ON mahasiswa.id_kelompok = `vjadwalbykelompok`.id_kelompok where mahasiswa.konfirmasi = 'Y' and vjadwalbykelompok.id_acara = $acara_id and mahasiswa.id_thn = ".$thn));
                //echo json_encode(db_read("SELECT nama, npm,nama_kelompok,tanggal,jam_mulai,nama_ruang FROM vjadwalperson WHERE id_acara = $acara_id AND id_thn =".get_id_active_year()));
                
                //UPDATE AGUSTUS 2022
                //Cek Acara Method
                $method = $sql[0]['method_th'];
                
                if($method==1){
                    echo json_encode(db_read("SELECT nama, npm,nama_kelompok,tanggal,jam_mulai,nama_ruang FROM vjadwalpersonsesi WHERE id_acara = $acara_id AND id_thn =".get_id_active_year()));
                }else if($method==2 || $method==4){
                    echo json_encode(db_read("SELECT nama, npm,tgl_mulai as tanggal,jam_mulai,nama_ruang FROM vjadwalbyfakultas WHERE id_acara = $acara_id AND id_thn =".get_id_active_year()));
                }else if($method==3){
                    echo json_encode(db_read("SELECT nama, npm,nama_kelompok,tanggal,jam_mulai,nama_ruang FROM vjadwalperson WHERE id_acara = $acara_id AND id_thn =".get_id_active_year()));
                }else{
                    echo json_encode(db_read("SELECT nama, npm,nama_kelompok,tanggal,jam_mulai,nama_ruang FROM vjadwalperson WHERE id_acara = $acara_id AND id_thn =".get_id_active_year()));
                }
            }
        } elseif($op == "reset"){
            //$def_table = "acara_ruang_kelompok_tes";
            $today = strtotime(date('Y-m-d'));
            $acara_thn = db_read("SELECT id as sesi,tgl_mulai as tgl, method_th FROM acara_tahun WHERE id_acara = $acara_id and id_thn=".get_id_active_year());
            $batas = strtotime($acara_thn[0][tgl]);
            if($today < $batas){
                
                //Method
                $method = $acara_thn[0]['method_th'];
                if($method==1){
                    $sesi = db_read("SELECT id_sesi FROM sesi WHERE id_acara_thn=".$acara_thn[0]['sesi']);
                    foreach ($sesi as $key => $value) {
                        db_delete($def_table, array('id_sesi' => $value['id_sesi']));
                    }
                    echo "Berhasil reset data";
                }else if($method==2){
                    $sesi = db_read("SELECT id_sesi FROM sesi WHERE id_acara_thn=".$acara_thn[0]['sesi']);
                    foreach ($sesi as $key => $value) {
                        db_delete($def_table_fakultas, array('id_sesi' => $value['id_sesi']));
                    }

                    echo "Berhasil reset data";
                }else if($method==3){
                    $sesi = db_read("SELECT id_sesi FROM sesi WHERE id_acara_thn=".$acara_thn[0]['sesi']);
                    foreach ($sesi as $key => $value) {
                        db_delete($def_table, array('id_sesi' => $value['id_sesi']));
                    }
                    echo "Berhasil reset data";
                }else if($method==4){
                    $sesi = db_read("SELECT id_sesi FROM sesi WHERE id_acara_thn=".$acara_thn[0]['sesi']);
                    foreach ($sesi as $key => $value) {
                        db_delete($def_table_fakultas, array('id_sesi' => $value['id_sesi']));
                    }
                    echo "Berhasil reset data";
                    
                }else{
                    echo "Tidak ditemukan method";
                }
                
            }
        } elseif($op == "pindah"){
            $kelompok = db_read("select * from kelompok");
            foreach($kelompok as $k_kel => $v_kel){
                if($v_kel['id_kloter'] == 1){
                    $id_om = 42;
                    $id_presentasi = 50;
                } else {
                    $id_om = 43;
                    $id_presentasi = 51;
                }
                $query = "UPDATE `acara_ruang_kelompok` SET `id_ruang` = (select * from (SELECT `id_ruang` FROM `acara_ruang_kelompok` WHERE `id_sesi` = ".$id_om." AND `id_kelompok` = ".$v_kel['id'].") a) WHERE  `id_sesi` = ".$id_presentasi." AND `id_kelompok` = ".$v_kel['id'];
                if(db_free_query($query)){
                    echo 'sukses';
                } else {
                    echo 'gagal';
                }
            }
        } else{
            echo "op salah";
            include "error/page_404.php";
            
        }
    } else {
        echo "acara salah";
        include "error/page_404.php";
    }
    
    } else {
        echo "gak ada id acara";
        include "error/page_404.php";
    }
}
