<?php 
	require_once("koneksi.php");
	$sql = mysqli_query($db, "SELECT * FROM sesi LEFT JOIN acara_tahun ON acara_tahun.id = sesi.id_acara_thn WHERE sesi.id_sesi BETWEEN 95 AND 98");
	$sql1 = mysqli_query($db, "SELECT * FROM `ruang` WHERE id_ruang NOT IN(1,2,8,11,44,45,46,47,48,50,51)");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mini Presensi</title>
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<link rel="stylesheet" type="text/css" href="css/bulma.min.css">
	<link rel="stylesheet" type="text/css" href="css/style3.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div class="container"  style="margin-top: 40px;margin-bottom: 40px;">

		<div class="columns">
			<div class="column">
				<form method="POST" action="">
					<div class="field">
						<div class="control">
							    <div class="select is-multiple">
                                    <select name="sesi" multiple size="5">
                                        <?php while($data = mysqli_fetch_assoc($sql)) : ?>
							               <option value="<?= $data['id_sesi'] ?>"><?= $data['keterangan'] ?> : <?= $data['nama_sesi'] ?> - <?= $data['tanggal'] ?> <?= $data['jam_mulai'] ?></option>
							            <?php endwhile; ?>
                                    </select>
                                </div>
						</div>
					</div>
					<div class="select">
                        <select name="ruang">
                            <?php while($data = mysqli_fetch_assoc($sql1)) : ?>
                                <option value="<?= $data['id_ruang'] ?>"><?= $data['nama_ruang'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div><br>
					<div class="field">
						<div class="control">
							<textarea class="textarea" placeholder="NIM" rows="10" name="npm"></textarea>
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input type="submit" name="submit" class="button is-primary" value="Simpan" style="width: 100%;">
						</div>
					</div>
				</form>
			</div>
			
			<div class="column">
					<?php 
						if (isset($_POST['submit'])) {
							$npm = $_POST['npm'];
							$arr_npm = explode ("\n",$npm);
							$id_sesi = $_POST['sesi'];
							$id_ruang = $_POST['ruang'];
							$sql2 = mysqli_query($db, "SELECT * FROM ruang where id_ruang = $id_ruang");
                            $data = mysqli_fetch_assoc($sql2);
                    ?>
                    
                        <div class="notification is-warning">                            
					
					<?php
							foreach ($arr_npm as $npm1) {
								$sql = mysqli_query($db, "INSERT INTO acara_ruang_person(npm, id_sesi, id_ruang) VALUES('$npm1','$id_sesi','$id_ruang')");
								if ($sql) {
								    echo "Menambahkan data ke ruang <b>".$data['nama_ruang']."</b><br><br>";
									echo "$npm1 | Berhasil <br/>";
								}else{
									echo "$npm1 | Gagal <br/>";
								}
							};
						}
					?>
					 
				 </div>
			</div>
		</div>
	</div>

</body>
</html>
