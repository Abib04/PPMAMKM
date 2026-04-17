<?php 
session_start();

function konek_db()
{
  // query ambil mahasiswa terkonfirmasi
//   $servername = "localhost";
//   $username = "root";
//   $password = "";
//   $dbname = "ppm_2023";

            $servername = "localhost";
            $username = "ppm_2020";
            $password = "";
            $dbname = "ppm_2020";

            // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  } else {
    return $conn;
  }
}

if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin")){
	$conn = konek_db();   

	$id_thn = get_id_active_year();
	
	$sql_config = "SELECT config.conf_value as tgl_cert FROM config WHERE config.conf_name = 'cert_date' and config.conf_year = $id_thn";
	$result_conf = mysqli_query($conn, $sql_config);
	$data_conf = mysqli_fetch_assoc($result_conf);
	
	$sql_thn = "SELECT tahun.thn as tahun FROM tahun WHERE tahun.id_thn = $id_thn";
	$result_thn = mysqli_query($conn, $sql_thn);
	$data_thn = mysqli_fetch_assoc($result_thn);

	$sql_mhs = "SELECT
        m.npm,
        p.jumlah,
        (SELECT
            COUNT(*)
        FROM
            absensi
        LEFT JOIN acara_tahun ON acara_tahun.id = absensi.id_acarathn
        WHERE
            absensi.npm = m.npm
        ) AS jumlah_absen
    FROM
        mahasiswa m
    RIGHT JOIN(
        SELECT
            presensi.npm AS npm,
            COUNT(*) AS jumlah
        FROM
            presensi
        WHERE
            presensi.id_thn = $id_thn
        GROUP BY
            presensi.npm
    ) p
    ON
        m.npm = p.npm";
        
	$result = mysqli_query($conn, $sql_mhs);
	
// 	var_dump(mysqli_fetch_assoc($result));
// 	die();

	$gagal = 0;

	if (mysqli_num_rows($result) > 0) {

		// delete all sertifikat pada tahun aktif
		$sql_reset = 'DELETE FROM `sertifikat` WHERE `id_thn` = '.$id_thn;
		$conn->query($sql_reset);
              // output data of each row
		$no = 1;

		while($row = mysqli_fetch_assoc($result)) {
		        
		    $total_hadir = $row['jumlah'] - $row['jumlah_absen'];
		    
		    if ($total_hadir >= 4) {
		        $predikat = "Sangat Baik";
		    } elseif ($total_hadir >= 2) {
		        $predikat = "Baik";
		    } elseif ($total_hadir >= 1) {
		        $predikat = "Cukup";
		    } else {
		        $predikat = "Kehadiran Kurang";
		    }
		    
		    $string_nomor = '0000'.$no;
		    $no_sert = substr($string_nomor, -4).'-'.$data_thn['tahun'].'-'.substr($row['npm'], -4);

			$sql_insert = "INSERT INTO `sertifikat`(`no_cert`, `npm`, `tanggal_terbit`, `predikat`, `id_thn`) VALUES ('".$no_sert."','".$row['npm']."','".$data_conf['tgl_cert']."','$predikat','$id_thn')";

			if ($conn->query($sql_insert) !== TRUE) {
				$gagal++;
				echo $no.' Nim '.$row['npm'].' GAGAL <br/>';
			}     

			echo $no.' Nim '.$row['npm'].'<br/>';
			$no++;
		}
	} else {
		echo "0 results";
	}

	mysqli_close($conn);



	if($gagal == 0){
		echo "Sukses Semua";
	}  else {
		echo 'Ada '.$gagal.' Yang Gagal !';
	}


} else {
	echo "<script>
	alert('Anda tidak diperkenankan melakukan aksi ini.');
	</script>";
}

function get_id_active_year(){
  if(!array_key_exists('active_thn',$_SESSION)){
    $year = db_read("select id_thn from tahun where status='Y'");
    if(count($year) > 0){
      $_SESSION['active_thn'] = $year[0]['id_thn'];
    }
  }
  return $_SESSION['active_thn'];
}

?>
