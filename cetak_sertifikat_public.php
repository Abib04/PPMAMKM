<?php
	include "lib/db_lib.php";
	require('lib/qr_lib_gen/qrlib.php');

	session_start();

	$_SESSION["pesan_error"] = '';

	if ($_POST['page'] != 'cetak_sertifikat') {
		header("Location: ".base_url('media.php?page=public_sertifikat'));
		die();
	}

	$nim_ppm = $_POST['nim_ppm'];
	$nim_skrng = $_POST['nim_skrng'];
	$tgl_lahir = $_POST['tgl_lahir'];

	$data = db_read("SELECT * from mahasiswa where npm = '" . $nim_ppm . "' and tgl_lahir = '" . $tgl_lahir . "'");

	if (count($data) < 1) {
		$_SESSION["pesan_error"] = "NIM Tidak Terdaftar, Cek Kembali NIM PPM dan Tanggal Lahir. Hubungi hotline PPM jika butuh bantuan";
		header("Location: ".base_url('media.php?page=public_sertifikat'));
		die();
	}

	$data_sert = db_read("SELECT * from sertifikat where npm = '".$nim_ppm."'");

	if (count($data_sert) < 1) {
		$_SESSION["pesan_error"] = "Anda tidak berhak mencetak sertifikat karena tidak menghadiri PPM";
		header("Location: ".base_url('media.php?page=public_sertifikat'));
		die();
	}

	$_SESSION['cetak_sertif'] = 1;
	$_SESSION['nim_ppm'] = $nim_ppm;
	$_SESSION['mhs_thn_ke'] = $data['0']['id_thn'];

	if ($nim_skrng != '') {
		$_SESSION['nim_skrng'] = $nim_skrng;
	} else {
		$_SESSION['nim_skrng'] = $nim_ppm;
	}
	

	$cekfile = "resource/mahasiswa/qr_code/".$nim_ppm.".png";
	
	if (file_exists($cekfile)){
		header("location: cert_public.php");
		die();
	}else{

		$folder = "resource/mahasiswa/qrcode_sertif/";
		$qrisi = base_url("media.php?page=cek_cert&no=".$data_sert[0]['no_cert']);
		$qrnamafile = $nim_ppm.".png";
		$quality = 'M'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 3;

		QRCode::png($qrisi,$folder.$qrnamafile,$quality,$ukuran,$padding);

		header("location: cert_public.php");
		die();
	}
?>
