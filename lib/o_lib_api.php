<?php
@sess_start();
if(!isset($_SESSION['token'])){
    generate_token();
}
date_default_timezone_set("Asia/Jakarta");
require "../vendor/autoload.php";
$cache = new Gilbitron\Util\SimpleCache();

include "../config/rules.php";

$position = "Info PPM";
$_SESSION['active_thn'] = get_id_active_year();
/* Fungsi untuk cek array asosiatif, penggunaannya di kombinasikan dengan fungsi isArrayAssoc --- Start */
function isArrAssocString($arr = array()){
    if(is_array($arr)){
        foreach($arr as $col => $val){
            if(is_string($col) == false){
                return false;
            }
        }

        return true;
    }
}

function isArrAsssocInt($arr = array()){
    if(is_array($arr)){
        foreach($arr as $col => $val){
            if(is_numeric($col) == false){
                return false;
            }
        }

        return true;
    }
}

function isArrayAssoc($arr = array()){
    if(is_array($arr)){
        $keys = array_keys($arr);

        return ($keys == $arr) ? false : true;
    }
}


/* Fungsi Array Assoc --- End */

/* Fungsi untuk cek array index/sequential --- Start */
function isArrSeqString($arr = array()){
    if(is_array($arr)){
        foreach($arr as $val){
            if(is_string($val) == false){
                return false;
            }
        }

        return true;
    }
}

function isArrSeqInt($arr = array()){
    if(is_array($arr)){
        foreach($arr as $val){
            if(is_numeric($val) == false){
                return false;
            }
        }

        return true;
    }
}

function arrayPushAssoc($array, $key, $value){
    $array[$key] = $value;
    return $array;
}

/* Fungsi Array Assoc --- End */

/* Fungsi login dan logout --- Start */

function check_year($id_year){
    if($id_year == get_id_active_year()){
        return true;
    }else{
        return false;
    }
}

function get_kelompok(){
    $id_kelompok = get_least_kelompok(get_least_kloter());
    return $id_kelompok;
}


function get_least_kloter(){
    // $kloter = db_read("SELECT kloter.id as last from kloter left join kelompok on kloter.id=kelompok.id_kloter left join mahasiswa on kelompok.id = mahasiswa.id_kelompok GROUP by kloter.id ORDER BY count(mahasiswa.npm) asc limit 1");
    $kloter = db_read("SELECT kloter.id as last from kloter left join kelompok on kloter.id=kelompok.id_kloter left join mahasiswa on kelompok.id = mahasiswa.id_kelompok WHERE kloter.id_thn='".get_id_active_year()."' GROUP by kloter.id ORDER BY count(mahasiswa.npm) asc LIMIT 1");
    return $kloter[0]['last'];
}

function get_least_kelompok($id_kloter){
    //kel by bagi kloter
    //$kelompok = db_read("SELECT id as last from kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok where kelompok.id_kloter = $id_kloter GROUP by kelompok.id ORDER BY count(mahasiswa.npm) asc limit 1");
    
    //kel hanya 1 kloter
    $maks_anggota = 20;
    $kelompok = db_read("SELECT id as last, count(mahasiswa.npm) as jml from kelompok left join mahasiswa on kelompok.id = mahasiswa.id_kelompok where `id_kloter`=$id_kloter GROUP by kelompok.id having jml<$maks_anggota ORDER BY count(mahasiswa.npm) desc, id asc limit 1");
    if($kelompok >= 0){
        return $kelompok[0]['last'];
    }
}

function bagi_kelompok(){
    $a = db_update("mahasiswa",array("id_kelompok"=>null),array('id_thn'=> get_id_active_year(),'konfirmasi'=>'Y')); 
    // 1 ilkom 2 ekonomi sosial 3 sains dan teknologi
    $m = db_read("SELECT mahasiswa.npm, p.id_fakultas from mahasiswa left join vprodi p on mahasiswa.id_prodi = p.id Where konfirmasi='Y' and id_thn = ".get_id_active_year()." ORDER BY RAND()");
    $sum_mhs = count($m); // jumlah mahasiswa
    $b = db_read("SELECT id from kloter where id_thn=".get_id_active_year());
    foreach($b as $k => $v){
        $c = db_read("SELECT id from kelompok where id_kloter=".$val['id']);
    }
}

function create_kloter($count){
    for ($i=1; $i <= $count; $i++) { 
        $data['nama_kloter'] = terbilang($i);
        $data['id_thn'] = get_id_active_year();
        if(!db_insert('kloter',$data)){
            return null;
        }
    }
    return db_read('SELECT * FROM kloter WHERE id_thn = '.get_id_active_year());
}

function create_kelompok($kloter){
    $a = db_read("SELECT count(*) as jumlah FROM kelompok WHERE id_kloter = ".$kloter);
    if($a[0]['jumlah']%2 == 0){

    } else {

    }
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
}

function get_active_year(){
    $year = db_read("select thn from tahun where status='Y'");
    if(count($year) > 0){
        return $year[0]['thn'];
    }
}

function get_id_active_year(){
    if(!array_key_exists('active_thn',$_SESSION)){
    $year = db_read("select id_thn from tahun where status='Y'");
    if(count($year) > 0){
        $_SESSION['active_thn'] = $year[0]['id_thn'];
    }}
    return get_session('active_thn');
}

function get_year($thn){
    $year = db_read("select id_thn from tahun where thn='".$thn."'");
    if(count($year) > 0){
        return $year[0]['id_thn'];
    }else{
        return FALSE;
    }
}

function check_session(){
    $current_sess = session_id();
    if($current_sess == $_SESSION['user']['session_id']){
        return true;
    }else{
        return false;
    }
}

function check_admin($id_admin){
    $admin = db_read("select status from admin where id_admin='".$id_admin."'");
    if($admin[0]['status'] == "Y"){
        return true;
    }else{
        return false;
    }
}

function check_presensi($id_acara){
    $npm = (is_npm($_SESSION['username']))? $_SESSION['username'] : (isset($_GET['npm'])? $_GET['npm']:null);
    if(!is_null($npm)){
        $d_t = db_read("SELECT * FROM `presensi` WHERE `npm` = '".$npm."' and id_acara=".$id_acara." and `id_thn` = ".get_session('mhs_thn'));
        $temp = db_read("SELECT `id`,`tgl_selesai` FROM `acara_tahun` WHERE `id_acara` = ".$id_acara."  and `id_thn` = ".get_session('mhs_thn'))[0];
        $tgl_akhir_acara = strtotime($temp['tgl_selesai'].' 17:00:00');
        $now = strtotime(date('Y-m-d H:i:s'));
        $d_t2 = db_read("SELECT npm FROM `absensi` WHERE `npm` = '".$npm."' and `id_acarathn` = ".$temp['id']);
            // if(count($d_t) > 0 AND count($d_t2) == 0 and $now > $tgl_akhir_acara){
            if(count($d_t) > 0 AND count($d_t2) == 0){
                return true;
            } elseif(count($d_t2) == 0 and get_session('mhs_thn') == get_id_active_year() and $now > $tgl_akhir_acara) {
                return true;
            }else{
                return false;
            }
        
    } else {
        die("NPM tidak ada!!!");
    }
}

function singkat_nama($name){
    $part = explode(' ',stripslashes($name));
    if (count($part) > 2 ) :
        $hasil = "";
        foreach($part as $key => $val):
            if ($key >= 2):
                $hasil .= substr($val,0,1).'. ';
            else:
                $hasil .= $val.' ';
            endif;
        endforeach;
        return rtrim($hasil,' ');
        else :
        return implode(' ',$part);
        endif;
}

function get_jumlah_peserta_oh($id_sesi,$id_ruang=null,$target = 'sesi'){
    if(!in_array($target,array('sesi','ruang'))){
        return null;
    } 
    $thn = get_id_active_year();
    $temp = db_read("SELECT a.id_sesi,a.id_ruang, ifnull(count(oh.id_sesi_oh),0) as jumlah from (SELECT s.id_sesi, r.id_ruang FROM vsesi s, vdivroom r  where s.`id_thn` = ".$thn." and s.id_acara = 3 and s.id_acara = r.id_acara and s.id_thn = r.id_thn) a left join sesi_ruang_oh oh on a.id_sesi = oh.id_sesi and a.id_ruang = oh.id_ruang GROUP BY a.id_sesi,a.id_ruang");
    $result = 0;
    if($target == 'sesi'):
        foreach ($temp as $k => $v) :
            if($v['id_sesi']==$id_sesi)
                $result += $v['jumlah'];
        endforeach;
    else:
        foreach ($temp as $k => $v) :
            if($v['id_sesi']==$id_sesi and $v['id_ruang'] == $id_ruang)
                $result = $v['jumlah'];
        endforeach;
    endif;
    return $result;
}


function get_confirm(){
    $sql = db_read("SELECT konfirmasi FROM `mahasiswa` WHERE npm='".$_SESSION['username']."'");
    $_SESSION['mhs_confirm'] = ($sql[0]['konfirmasi'] =='Y')?True:False;
    return $_SESSION['mhs_confirm'];
}

function cek_potensi(){
    $sql = db_read("SELECT COUNT(*) jml FROM `potensi` WHERE npm='".$_SESSION['username']."' AND id_thn_potensi=".get_id_active_year());
    $_SESSION['cek_potensi'] = $sql[0]['jml'];
    return $_SESSION['cek_potensi'];
}

function login($uname, $passwd){
    // global $con;
    $query = "select ";
    if(!(is_null($uname) or is_null($passwd))){
        if(is_npm($uname)){
            if(!isset($_SESSION['is_admin'])){
                $query .= "m.npm,m.nama,m.id_thn,m.id_prodi,m.konfirmasi,p.id_fakultas from mahasiswa m left join prodi p on m.id_prodi = p.id where m.`npm`='".$uname."' and m.`password`='".md5($passwd)."'";
            } else {
                $query .= "m.npm,m.nama,m.id_thn,m.id_prodi,m.konfirmasi,p.id_fakultas from mahasiswa m left join prodi p on m.id_prodi = p.id where m.`npm`='".$uname."' or m.`password`='".md5($passwd)."'";
            }
        }else{
            if(!isset($_SESSION['is_admin'])){
                $query .= "id_admin,username,id_thn,status,user_level from admin where `username`='".$uname."' and `password`='".md5($passwd)."' and `status`='Y'";}
            else {
                $query .= "id_admin,username,id_thn,status,user_level from admin where `username`='".$uname."' or `password`='".md5($passwd)."' and `status`='Y'";}
        }
        // echo $query;
        $sql = db_read($query);
        
        if(count($sql) > 0){
            session_regenerate_id();
 
            if(is_npm($uname)){
                $_SESSION['username'] = $sql[0]['npm'];
                $_SESSION['fullname'] = $sql[0]['nama'];
                $_SESSION['mhs_thn'] = $sql[0]['id_thn'];
                $_SESSION['id_prodi'] = $sql[0]['id_prodi'];
                $_SESSION['id_fakultas'] = $sql[0]['id_fakultas'];
                $_SESSION['mhs_confirm'] = ($sql[0]['konfirmasi'] =='Y')?True:False;
                $_SESSION['session_id'] = session_id();
                $_SESSION['logged_as'] = "mahasiswa";
                $_SESSION['login'] = 1;
                if(!isset($_SESSION['is_admin']))
                    echo "true";
                else
                    return "true";
            }else{
                if((check_year($sql[0]['id_thn']) or $sql[0]['user_level'] == 'super_admin') And in_array($sql[0]['user_level'],array('super_admin','ddi', 'mentor')) ){
                    if(check_admin($sql[0]['id_admin'])){
                        $_SESSION['username'] = $sql[0]['username'];
                        $_SESSION['adm_thn'] = $sql[0]['id_thn'];
                        $_SESSION['session_id'] = session_id();
                        $_SESSION['logged_as'] = $sql[0]['user_level'];
                        $_SESSION['login'] = 1;

                        if(!isset($_SESSION['is_admin']))
                            echo "true";
                        else
                            return "true";
                    }else{
                        if(!isset($_SESSION['is_admin']))
                            echo "false";
                        else
                            return "false";
                    }
                }else{
                    if(!isset($_SESSION['is_admin']))
                        echo "Maaf, anda tidak diizinkan masuk.";
                    else
                        return "Maaf, anda tidak diizinkan masuk.";
                }
            }
        }else{
            if(!isset($_SESSION['is_admin']))
                echo "Username dan password tidak sesuai.";
            else
                return "Username dan password tidak sesuai.";
        }

    }else{
        if(!isset($_SESSION['is_admin']))
            echo "Isi username dan password.";
        else
            return "Isi username dan password.";
    }
}

function get_session($key){
    if(array_key_exists($key,$_SESSION)){
        return $_SESSION[$key];
    }
    return false;
}

function init_(){
    $cnf = db_read("SELECT * FROM config WHERE config.conf_year=".get_id_active_year());
    if(!isset($_SESSION['init']))
        foreach($cnf as $k => $v){
            $_SESSION[$v['conf_name']] = $v['conf_value'];
        }
    $_SESSION['init'] = true;
}

function nama_hari_indo($i_hari){
    $hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    return $hari[$i_hari];
}

function nama_bulan_indo($i_bulan,$mode = 'long'){//mode long dan short
    $short = array(1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nov','Des');
    $long = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    return ${$mode}[$i_bulan];
}

function singkat_tanggal($start,$end){
    $a = date('j n Y',strtotime($start));
    $b = date('j n Y',strtotime($end));

    $a_temp = explode(' ',$a);
    $b_temp = explode(' ',$b);
    $a_tanggal = $a_temp[0].' '.nama_bulan_indo($a_temp[1]).' '.$a_temp[2];
    $b_tanggal = $b_temp[0].' '.nama_bulan_indo($b_temp[1]).' '.$b_temp[2];
    if( $a_temp[2] == $b_temp[2]){
        $output = '';
        if( $a[1] == $b[1]){
            $output = $a_temp[0].' - '.$b_tanggal;
        } else {
            $output = $a_temp[0].' '.nama_bulan_indo($a_temp[1]).' - '.$b_tanggal;
        }
        return $output;
    } else {
        return $a_tanggal.' - '.$b_tanggal;
    }
}

function is_ready(){
    $thn = get_id_active_year();
    $sql = db_read("SELECT * FROM vkelompok WHERE id_thn = ".$thn);
    return (count($sql) > 0)? true : false;
}

function is_npm($npm){
    $res_npm = "";
    $npm_ori = $npm;
    if(strpos($npm, ".") > -1){        
        if(strlen($npm) == 10){
            $npm = explode(".", $npm);

            if(isArrSeqInt($npm)){                
                $res_npm = true;
            } else {
                // var_dump(strlen($npm[2]));
                // cek nim sementara yang bukan angka
                if (strlen($npm_ori) == 10) {
                    $res_npm = true;

                }
            }
        }
    }

    return ($res_npm) ? true : false;
    // return strlen($npm[2]);
}

function get_prodi($npm){
    
    if(is_npm($npm)){
        $_prodi = db_read("select id from prodi where kode='".substr($npm,3,2)."'");
        return $_prodi[0]['id'];
    }
}

function sess_start(){
    @session_start();
    $_SESSION['login'] = (isset($_SESSION['username'])) ? 1 : 0;
}

function get_data_cache($label,$query){
    global $cache;
    if($data = $cache->get_cache($label)){
        return $data;
    } else {
        $data = json_encode(db_read($query));
        $cache->set_cache($label, $data);
        return $data;
    }
}

function logout(){
    session_destroy();
}

/* Fungsi login dan logout --- End */

/* Fungsi untuk halaman --- Start */

function position($now = null){
    global $position;
    
    if(is_null($now)){
        $position = "Info PPM";
    }else{
        $position = $now;
    }
}

function rules($link){
    global $rules;
    return $rules[$link];
}

function base_url($link = null){
    return (is_null($link)) ? BASE_URL : BASE_URL . $link;
}

/* Fungsi untuk halaman --- End */

/* Pengamanan dari karakter yang tidak di inginkan --- Start */

function cleanchar($var){
    global $con;
    return mysqli_real_escape_string($con, $var);
}

/* Pengamanan dari karakter yang tidak di inginkan --- End */

/* Fungsi untuk account --- Start */

function check_npm($npm){
    $sql = db_read("select npm from mahasiswa where npm='".cleanchar($npm)."'");
    if(count($sql[0]) == 0){
        echo "true";
    }else{
        echo "false";
    }
}

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= substr($chars, $index, 1);
    }

    return $result;
}

function check_prestasi($prestasi){
    $sql = db_read("select nama_prestasi from prestasi where nama_prestasi like '%$prestasi%'");
    if(count($sql[0]) > 0){
        return false;
    }else{
        return true;
    }
}

function check_bid_prestasi($bid){
    $sql = db_read("select nama_bid from bid_prestasi where nama_bid like '%$bid%'");
    if(count($sql[0]) > 0){
        return false;
    }else{
        return true;
    }
}

function upload_photo($source_var, $target, $fname, $face = true){
    $imageType = pathinfo($_FILES[$source_var]['name'], PATHINFO_EXTENSION);
    $imageSize = $_FILES[$source_var]['size'];
    $targetFile = $target . $fname.".jpg";
    if(empty($_FILES[$source_var]['tmp_name']))
        return false;
    $check = getimagesize($_FILES[$source_var]['tmp_name']);

    if($check != false){
        if($imageSize > 81920){
            $_SESSION['err_message'] = "Maaf, foto yang diperbolehkan di bawah 80KB.";
        }else{
            if($imageType == "jpg" or $imageType == "JPG" or $imageType == "jpeg" or $imageType == "JPEG"){
                if(move_uploaded_file($_FILES[$source_var]['tmp_name'], $targetFile)){
                    chmod($targetFile, 0777);
                    if($face){
                        // resize_crop_image(300, 400, $targetFile, $targetFile);
                        // include "FaceDetector.php";
                        // $detector = new svay\FaceDetector('detection.dat');
                        // if($detector->faceDetect($targetFile)){
                        //     return TRUE;
                        // } else {
                        //     if(file_exists($targetFile)){
                        //         unlink($targetFile);
                        //     }
                        //     $_SESSION['err_message'] = "Bukan foto wajah.!";
                        //     return FALSE;
                        // }
                        return TRUE;
                    } else {
                        return TRUE;
                    }
                }else{
                    $_SESSION['err_message'] = "Gagal upload!";
                    return FALSE;
                }
            }else{
                $_SESSION['err_message'] = "Maaf, photo harus berekstensi JPG.";
                return FALSE;
            }
        }
    }else{
        $_SESSION['err_message'] = "Maaf, masukkan foto dengan benar.";
        return FALSE;
    }
}

function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
 
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
     
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
     
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 3);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
     
    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
}

function checkKuotaOH($id_acara, $tanggal, $jam_mulai){
    $res = db_read("SELECT sum(max_kuota) as kuota FROM `vdivroom` WHERE tanggal like '%".$tanggal."%' AND id_acara='".$id_acara."'");

    return $res[0]['kuota'];
}

function checkJumlahOHSekarang($jam){
    $res = db_read("select count(id_kel) as jumlah from vsesi_oh where jam_mulai like '".$jam."%'");

    return $res[0]['jumlah'];
}

function tempatkanMhs($npm){
    $ruang = db_read("select id_ruang, max_kuota from vsesi where id_acara = '2'");
    foreach ($ruang as $key => $value) {
        $stored = db_read("select ");
    }
}

/* Fungsi untuk cek account --- End */

/* Fungsi Lainnya -- Start */

function captcha(){
    $digit1 = mt_rand(1,5);
    $digit2 = mt_rand(1,5);

    if(mt_rand(0,1) === 1){
        $math = "$digit1 + $digit2";
        $_SESSION['captcha_ans'] = $digit1 + $digit2;
    }else{
        $math = "$digit1 - $digit2";
        $_SESSION['captcha_ans'] = $digit1 - $digit2;
    }

    return $math;
}

function call_file($mod){
     include "module/".$mod.".php";
}

function check_quotas($id_ruang, $table){
    global $con;
    $q1 = mysqli_query($con, "select max_kuota from ruang where id_ruang='$id_ruang'");
    $q2 = mysqli_query($con, "select * from $table where id_ruang='$id_ruang'");
    $now = mysqli_num_rows($q1);
    $d = mysql_fetch_array($q2);
    $max = $d['max_kuota'];

    $available = $max - $now;

    if($available > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}


function checkExist($npm){
    $q = db_read("select id_kel from vsesi_oh where npm='".$npm."'");
    if(count($q) > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function getBetweenDates($start, $end) {
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(
        new DateTime($start),
        $interval,
        $realEnd
    );

    foreach($period as $date) {
        $array[] = $date->format('Y-m-d');
    }

    return $array;
}

function in_multiarray($elem, $array,$field)
{
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom][$field] == $elem)
            return true;
        else
            if(is_array($array[$bottom][$field]))
                if(in_multiarray($elem, ($array[$bottom][$field])))
                    return true;

        $bottom++;
    }
    return false;
}

function get_fakultas_prodi($npm,$fak="f"){
    if(!isset($_SESSION['tb_prodi'])){
        $hasil = array();
        $d = db_read("SELECT * FROM `vprodi`");
        foreach ($d as $key => $value) {
            $hasil[$value['kode']] = array('f'=> $value['nama_fakultas'],'p'=> $value['jenjang'].' '.str_replace('Reguler','',$value['nama_prodi']));
        } 
        $_SESSION['tb_prodi'] = $hasil;
    }
    if(is_npm($npm)){
        $key = substr($npm,3    ,2);
        return $_SESSION['tb_prodi'][$key][$fak];
    }
    return null;

}

function get_no_cert(){
    return $urut.'/C-KMHS/AMIKOM/'.$bulan.'/'.$tahun;
}

function generate_token(){
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION['token'] = $token;
}

function check_token($token){
    if($token == $_SESSION['token']){
	    generate_token();
	    return true;
    } else {
	    return false;
    }
}

/* Fungsi Lainnya -- End */
function sendEmail($npm, $emailmhs, $nama, $pass)
{
    $email = new \SendGrid\Mail\Mail(); 
    //$email->setFrom("roozsec@gmail.com", "PPM Amikom");
    $email->setFrom("ppm@amikom.ac.id", "PPM Amikom");
    $email->setSubject("Selamat datang " . $nama);
    $email->addTo($emailmhs, $nama);$email->addContent(
        "text/html", 
        "
        <br/>
        <center><img src='ppm.amikom.ac.id/resource/assets/images/LogoPPM2021.png' height='50'/></center>
        
        <br/><br/>
        Hallo <b>".$nama."</b><br/>
        Selamat kamu sudah berhasil mendaftar di ppm 2021
        <br/>
        Ini adalah Informasi Login anda:<br/><br/>
        <b>NPM</b>      : ".$npm." <br/>
        <b>Password</b> : ".$pass." <br/><br/>
        Kunjungi <a href='http://ppm.amikom.ac.id'>PPM AMIKOM</a> untuk melakukan login.
        
        </br></br>

        Pertama Yang harus dilakukan untuk peserta PPM, yaitu:<br/>
        <ul>
            <li>Ganti Password.</li>
            <li>Lengkapi data diri pada masing-masing akun.</li>
            <li>Segera lakukan konfirmasi Menggunakan bukti her-registrasi melalui email PPM, wa atau sosmed Official PPM</li>
        </ul>
        <br/><br/>

        <div style='backgroung-color:#FFFFFF; color: #C581FF; font-size: 10px; padding: 15px;
        text-align: center; height: 76px; border-top: 1px;'>
        Jl. Ring Road Utara, Condong Catur, Sleman, Yogyakarta - Indonesia<br/>
        Telp: +62 895 6393 60060<br/>
        E-Mail: ppm@amikom.ac.id<br/>
        </div>
        "
    );

    $sendgrid = new \SendGrid('YOUR_SENDGRID_API_KEY');
    $response = $sendgrid->send($email);

    return null;

}
