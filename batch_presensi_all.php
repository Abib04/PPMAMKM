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

if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
	$conn = konek_db();   

	$id_thn = get_id_active_year();
	$id_acara = $_GET['id_acara'];

	$sql = "SELECT * FROM mahasiswa WHERE konfirmasi='Y' AND id_thn = $id_thn";
	$result = mysqli_query($conn, $sql);
	
// 	var_dump($result);
// 	die();

	$gagal = 0;

	if (mysqli_num_rows($result) > 0) {

		// delete all presensi pada acara
		$sql_reset = 'DELETE FROM `presensi` WHERE `id_acara` = '.$id_acara.' AND `id_thn` = '.$id_thn;
		$conn->query($sql_reset);
              // output data of each row
		$no = 1;

		$cek_jadwal_acara = 'SELECT sesi.jam_mulai, sesi.tanggal FROM `acara_tahun` LEFT JOIN sesi ON sesi.id_acara_thn = acara_tahun.id WHERE acara_tahun.`id_thn` = '.$id_thn.' AND acara_tahun.`id_acara` = '.$id_acara;
		$result_acara = mysqli_query($conn, $cek_jadwal_acara);
		$data_acara = mysqli_fetch_assoc($result_acara);
		$jam = $data_acara['jam_mulai'];
		$tgl = $data_acara['tanggal'];

// 		var_dump($data_acara);
// 		die();

		while($row = mysqli_fetch_assoc($result)) {
		  //  var_dump($row);
		  //  die();
		
			$nim = $row["npm"];
			$id_kelompok = $row["id_kelompok"];

			$sql_insert = "INSERT INTO `presensi`(`npm`, `id_acara`, `id_kelompok`, `tgl`, `jam_msk`, `id_thn`) VALUES ('$nim','$id_acara','$id_kelompok','$tgl','$jam','$id_thn')";

			if ($conn->query($sql_insert) !== TRUE) {
				$gagal++;
				echo $no.' Nim '.$nim.' GAGAL <br/>';
			}     

			echo $no.' Nim '.$nim.'<br/>';
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
