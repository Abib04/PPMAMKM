<?php 
	require_once("koneksi.php");
	$sql = mysqli_query($db, "SELECT * FROM kelompok WHERE id > 126");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data</title>
</head>
<body>

	<form method="POST" action="">
		NPM : <textarea name="npm"></textarea> <br/><br/>
		Kelompok : 
		<select name="kelompok">
			<?php while ($data = mysqli_fetch_assoc($sql)) { ?>
				<option value="<?= $data['id']; ?>"><?= $data['nama_kelompok']; ?></option>
			<?php }; ?>
		</select> <br/><br/>
		<input type="submit" name="submit">
	</form>

	<?php 
		if (isset($_POST['submit'])) {
			$npm = $_POST['npm'];
			$arr_npm = explode ("\n",$npm);
			$id_acara = 2;
			$id_kelompok = $_POST['kelompok'];
			$tgl = "2018-09-04";
			$jam = "07:00:00";
			$id_thn = 11;

			foreach ($arr_npm as $npm1) {
				$sql = mysqli_query($db, "INSERT INTO presensi(npm,id_acara,id_kelompok,tgl,jam_msk,id_thn) VALUES('$npm1','$id_acara','$id_kelompok','$tgl','$jam','$id_thn')");
				if ($sql) {
					echo $npm1;
					echo " | berhasil <br/>";
				}else{
					echo $npm1;
					echo " | gagal <br/>";
				}
			};
		}
	 ?>

</body>
</html>
