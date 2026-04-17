<?php

session_start();

include 'koneksi.php';



if(!empty($_SESSION['acara'])) {

    header('Location: index.php');

}



$sql = mysqli_query($db, "SELECT * FROM acara");

$sql2 = mysqli_query($db, "SELECT * FROM ruang"); 



?>



<!DOCTYPE html>

<html>

<head>

	<title>Login Absensi</title>

	<link rel="stylesheet" type="text/css" href="css/bulma.min.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>

	<section class="hero is-fullheight has-background-white-ter">

		<div class="hero-body">

			<div class="container">

				<center>

					<form method="POST" class="login-width" action="proses.php">

						<p class="title is-1 has-text-weight-bold">Presensi</p>

						<div class="field">

							<?php if (@$_GET['a'] == 'salahl'){

								echo "<font color=red>Password / Username salah</font>";

							 }elseif (@$_GET['a'] == 'pilihr') {

							 	echo "<font color=red>Pilih ruang / Acara dulu</font>";

							 }

							?>

							<div class="control">

								<input type="text" value="" name="username" placeholder="Username" class="input" autofocus></input>

							</div>

						</div>

						<div class="field">

							<div class="control">

								<input type="password" value="" name="password" class="input" placeholder="Password"></input>

							</div>

						</div>

						<div class="field">

							<div class="control">

								<div class="select">

									<select name="acara" id="acara">

										<option value="" style="display: none;">Pilih Acara</option>

										<?php

											while($data = mysqli_fetch_assoc($sql)) { 

											?>

											<option value="<?= $data['id_acara']; ?>"><?= $data['nama_acara']; ?></option>

										<?php } ?>

									</select>

								</div>

								<div class="select is-pulled-right ">

									<select name="ruang" id="ruang">

											<option value="">Pilih Ruang</option>

									</select>

								</div>

							</div>

						</div>

						<div class="field">

							<div class="control">

								<button type="submit" name="masuk" class="button is-primary" style="width: 100%;">Masuk</button>

							</div>

						</div>

					</form>	

				</center>		

			</div>

		</div>

	</section>

</body>

</html>



<script src="js/jquery.js"></script>

<script>

	$(document).ready(function() {

		$('#acara').change(function() {

		var acara_id = $(this).val();



		$.ajax({

			type: 'POST',

			url: 'aksi/ruang.php',

			data: 'acara_id='+acara_id,

			success: function(response) {

				$('#ruang').html(response);

			}

		});

	})

});

</script>
