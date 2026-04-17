<?php
session_start();
	$id_acara = $_SESSION['acara'];
	$id_ruang = $_SESSION['ruang'];
        include '../koneksi.php';
         $myArray = array();
        if($_GET['aksi'] == 'cek'){
        	$id = $_POST['id'];
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
					$query = $db->query("SELECT * from vsesi_oh where npm = $id and id_thn = 12");
					$data = $query->fetch_assoc();
							
				// 	if ($query->NUM_ROWS > 0) {
					    $sql2 = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$id', '$id_acara', 0, '$tanggal', '$jam', 12)");
						
						$myArray['status'] = 'sukses';
						$myArray['ket'] = '<b>Nama : '.$nama.' </b><br/>Berhasil Masuk';
				    // }
				// 	else
				// 	{
				// 		$myArray['status'] = 'gagal';
				//   		$myArray['ket'] = '<span><center>Gagal</b></center></span>';
				// 	}
					
					echo json_encode($myArray);
			

                    
        }
?>
