<?php
	include "../koneksi.php";
	
	$npm 	= $_POST['npm'];
	
	$ambil = $db->query("SELECT * FROM presensi1 WHERE npm = '$npm'");
	$cek = mysqli_num_rows($ambil);
	
	$ambilmhs = $db->query("SELECT * FROM mahasiswa WHERE npm = '$npm'");
	$cekmhs = mysqli_num_rows($ambilmhs);
	
	$response = array();
	
    if($cekmhs < 1) {
        
		$response['message'] = "Anda Belum Terdaftar Pada Acara PPM.";
        
    }elseif($cek > 0) {

        $response['message'] = "Anda Sudah melakukan Presensi.";
	
        
    }else{
	
        $insert = $db->query("INSERT INTO presensi1 VALUES(NULL, '$npm', NULL, 12)");
	    
	    $response['message'] = "Success ! Presensi Berhasil";
	}
	
		echo json_encode($response);
 ?>
