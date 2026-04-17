<?php
session_start();
	$id_acara = $_SESSION['acara'];
	$id_ruang = $_SESSION['ruang'];
        include '../koneksi.php';
         $myArray = array();
        if($_GET['aksi'] == 'cek'){
        	$id_qr = mysqli_real_escape_string($db,@$_POST['id']);
		  //TIMEZONE
		  date_default_timezone_set('Asia/Jakarta');
		  $jam = date('H:i:s');
		  $tanggal = date('Y/m/d');
		  //CONVERT TANGGAL INDONESIA
					function tanggal_indo($tanggal)
					{
						$bulan = array (1 =>   
									'Januari',
									'Februari',
									'Maret',
									'April',
									'Mei',
									'Juni',
									'Juli',
									'Agustus',
									'September',
									'Oktober',
									'Nopember',
									'Desember'
								);
						$split = explode('-', $tanggal);
						return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
					}
					$tanggalv2 = tanggal_indo(date('Y-m-d')); 
					$myArray['jam'] = $jam;
				  	$myArray['tanggal'] = $tanggalv2;
			  
			  //CEK DATA
					if(!isset($_SESSION['data_barcode'])){
						$_SESSION['data_barcode'] = array();
						$sql = $db->query("SELECT m.npm, b.qr_code, m.id_kelompok,m.id_prodi,m.id_thn,m.nama FROM barcode b JOIN mahasiswa m ON m.npm = b.npm and m.konfirmasi = 'Y'");
						while ($a = $sql->fetch_assoc()) {
							$_SESSION['data_barcode'][$a['qr_code']] = array(
								'npm' => $a['npm'],
								'id_kelompok' => $a['id_kelompok'],
								'id_prodi' => $a['id_prodi'],
								'nama' => $a['nama'],
								'id_thn' => $a['id_thn']
							);
						}
					}

			//   $sql = $db->query("SELECT m.npm, b.qr_code, m.id_kelompok,m.id_prodi,m.id_thn,m.nama FROM barcode b JOIN mahasiswa m ON m.npm = b.npm and m.konfirmasi = 'Y' WHERE b.qr_code='$id_qr'");
			//   if(!$sql){
			//     die($db->error);
			//   }
			  
			//    $num = $sql->num_rows;
			  //OUTPUT QR CODE JSON, KE STATUS/LOG
			// while ($row = $sql->fetch_assoc())
			// {
				  	$myArray[] = $_SESSION['data_barcode'][$id_qr];
			// }
			// echo $id_qr;
			// echo json_encode($_SESSION['data_barcode']);
				if(isset($_SESSION['data_barcode'][$id_qr])){
					//AMBIL ID MAHASISWA
					// $cek3 = $db->query("SELECT * FROM barcode b LEFT JOIN mahasiswa m ON m.npm = b.npm WHERE qr_code='$id_qr'");
					//   if(!$cek3){
					//     die($db->error);
					//   }
					// $value 	= $cek3->fetch_assoc();
					$nama = $_SESSION['data_barcode'][$id_qr]['nama'];
					$npm = $_SESSION['data_barcode'][$id_qr]['npm'];
					$kelompok = $_SESSION['data_barcode'][$id_qr]['id_kelompok'];
					//CEK4 acara
					
					if(!isset($_SESSION['presensi'])){
						$_SESSION['presensi'] = array();
						$q = $db->query("SELECT * FROM `presensi`");
						while ($a = $q->fetch_assoc()) {
							$_SESSION['presensi'][$a['npm'].'_'.$a['id_acara']] = array(
								'npm'=> $a['npm'], 
								'id_acara'=> $a['id_acara'], 
								'id_kelompok'=> $a['id_kelompok'], 
								'tgl'=> $a['tgl'], 
								'jam_msk'=> $a['jam_msk'], 
								'id_thn'=> $a['id_thn']
							);
						}
					}

					// $cek4=$db->query("SELECT * FROM `presensi` WHERE `npm` = '$npm' AND id_acara = '$id_acara'");
			        // if(!$cek4){
					// 	die($db->error);
					// }
			        // $value = $cek4->fetch_assoc();
			        // $acara = $value['id_acara'];
			        // Cek ruang
					$cek5=$db->query("SELECT * FROM `vjadwalperson` WHERE npm = '$npm' AND id_acara = ".$id_acara);
			        if(!$cek5){
						die($db->error);
					}
			        $value1 = $cek5->fetch_assoc();
			        $ruang  = $value1['id_ruang'];
			        $nruang = $value1['nama_ruang'];
			        $thn    = 12;
					//PRESENSI MASUK
			        if(isset($_SESSION['presensi'][$npm.'_'.$id_acara]))
					{
						$myArray['status'] = 'gagal';
				  		$myArray['ket'] = '<span><center><b>Anda sudah melakukan presensi</b></center></span>';
					}
				// 	elseif($id_ruang == $ruang OR ($id_ruang == 46 and $id_acara == 4))
				// 	{
				// 		  $sql2 = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$npm', '$id_acara', '$kelompok', '$tanggal', '$jam', '$thn')");
				// 		  $_SESSION['presensi'][$npm.'_'.$id_acara] = array(
				// 			'npm'=> $npm, 
				// 			'id_acara'=> $id_acara, 
				// 			'id_kelompok'=> $kelompok, 
				// 			'tgl'=> $tanggal, 
				// 			'jam_msk'=> $jam, 
				// 			'id_thn'=> $thn
				// 		);
						
				// 		// Double presensi untuk acara Perkenalan ORMA
				// 		if ($id_acara == 12 || $id_acara == 14) {
				// 		    $id_acara2 = ($id_acara == 12 ? 14 : 12);
				// 		    $sql2d = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$npm', '$id_acara2', '$kelompok', '$tanggal', '$jam', '$thn')");
				// 		}
						
				// 		$myArray['status'] = 'sukses';
				// 		  $myArray['ket'] = '<b>Nama : '.$nama.' </b><br/>Berhasil Masuk';
				// 	}
				// Double presensi untuk acara Perkenalan ORMA
					elseif ($id_acara == 12 || $id_acara == 14) {
					    $sql2 = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$npm', '$id_acara', '$kelompok', '$tanggal', '$jam', '$thn')");
					    $id_acara2 = ($id_acara == 12 ? 14 : 12);
						$sql2d = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$npm', '$id_acara2', '$kelompok', '$tanggal', '$jam', '$thn')");
						
						$_SESSION['presensi'][$npm.'_'.$id_acara] = array(
							'npm'=> $npm, 
							'id_acara'=> $id_acara, 
							'id_kelompok'=> $kelompok, 
							'tgl'=> $tanggal, 
							'jam_msk'=> $jam, 
							'id_thn'=> $thn
						);
						
						$myArray['status'] = 'sukses';
						$myArray['ket'] = '<b>Nama : '.$nama.' </b><br/>Berhasil Masuk';
				    }
					else
					{
						$myArray['status'] = 'gagal';
				  		$myArray['ket'] = '<span><center>Anda Salah ruang, anda ruang <b>'.$nruang.'</b></center></span>';
					}
					
					echo json_encode($myArray);
			}
        }
			elseif($_GET['aksi'] == 'gagal'){
				$id = $_POST['id'];
				//CEK DATA
			 	$sql = $db->query("SELECT * FROM presensi WHERE npm = '$id' AND id_acara = ".$id_acara);
			  	$value = $sql->fetch_assoc();
			   	$num = mysqli_num_rows($sql);
			  	//OUTPUT QR CODE JSON, KE STATUS/LOG
				while ($row = $sql->fetch_assoc())
					  {
					  	$myArray[] = $row;
					  }
				if($num > 0)
				{
					$delete = $db->query("DELETE FROM presensi where npm = '$id' AND id_acara = '$id_acara'");
					unset($_SESSION['presensi'][$id.'_'.$id_acara]);
					echo 'berhasil';
				}else{
					echo "gagal";
				}
			}
?>
