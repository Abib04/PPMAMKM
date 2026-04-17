<?php
//ini_set('display_errors', 1);

@session_start();

require('lib/qr_lib_gen/qrlib.php');
require('lib/db_lib.php');

if($_SESSION['login'] != 1 ){
    exit("Maaf, anda tidak bisa mengakses halaman ini.");
}

$npm = (is_npm($_SESSION['username']))? $_SESSION['username']:'';
$data = db_read("SELECT * from sertifikat where npm = '".$npm."'");

$cekfile = "resource/mahasiswa/qr_code/".$npm.".png";
    if (file_exists($cekfile)){
    	header("location: cert.php");
    }else{

$folder = "resource/mahasiswa/qrcode_sertif/";
$qrisi = base_url("media.php?page=cek_cert&no=".$data[0]['no_cert']);
$qrnamafile = $npm.".png";
$quality = 'M'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
$padding = 3;

    QRCode::png($qrisi,$folder.$qrnamafile,$quality,$ukuran,$padding);

        header("location: cert.php");
}


?>
