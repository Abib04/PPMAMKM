<?php
include "lib/db_lib.php";
sess_start();
init_();
session_save_path(getcwd() . "/logs");
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Penggalian Potensi Mahasiswa | UNIVERSITAS AMIKOM Yogyakarta</title>
	<link rel="shortcut icon" href="resource/assets/images/fav.png">
	<link rel="stylesheet" href="resource/assets/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/bootstrap-datepicker.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/bootstrap.timepicker.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/jquery.dataTables.min.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/custom.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/docs.css" type="text/css">
	<link rel="stylesheet" href="resource/assets/css/superfish.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="resource/assets/css/dataTables.bootstrap.min.css">
	<script src="resource/assets/js/jquery.min.js"></script>
	<script src="resource/assets/js/jquery.validate.min.js"></script>
	<script src="resource/assets/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
	<script src="resource/assets/js/bootstrap.timepicker.js"></script>
	<script src="resource/assets/js/jquery.dataTables.min.js"></script>
	<script src="resource/assets/js/dataTables.bootstrap.min.js"></script>
	<script src="resource/assets/js/javascript.cookie.js"></script>
</head>

<body>
	<!--<div style="width: 100%; padding: 12px; background: #e74c3c; color: #fff; text-align: center; font-size: 14px; margin-bottom: 48px;">
        Kamu berada di website lama PPM. Pendaftaran PPM <?php echo date('Y') ?> dialihkan ke website
        <strong><a href="https://ppm.amikom.id" style="color: #ffe740">ppm.amikom.id</a></strong>
    -->

	</div>
	<div class="container" style="margin: 0px auto;">
		<div class="header">
			<div class="row">
				<div class="col-xs-6">
					<!--<div id="logo_stmik_amikom"></div>-->
					<a href="http://www.amikom.ac.id/index.php/main" target="_blank">
						<img src="resource/assets/images/logo_stmik_amikom2.jpg" />
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-9" id="title_page">
					<div id="menu_main">PPM <?php echo get_active_year(); ?></div>
				</div>
			</div>
			<div class="row" style="height: 135px;background: #FFF;padding:0; border-top-left-radius:3em;border-top-right-radius:0.8em;">
				<div class="col-xs-9" style="padding-left: 0; padding-right: 0">
					<a href="http://kemahasiswaan.amikom.ac.id" target="_blank">
						<div style="background: transparent url(<?php echo base_url("resource/assets/images/header_web_ppm2023-old.webp"); ?>) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 135px; outline-color: rgb(255, 0, 0); outline-width: 1px; background-size:cover;border-top-left-radius: 0.8em;"></div>
					</a>
				</div>
				<div class="col-xs-3" id="student">
					<!--<div class="title">LOGIN AREA</div>-->
					<form id="formlogin" method="post" action="<?php echo ($_SESSION['login'] == 1) ? rules("act_logout") : rules("act_login"); ?>">

						<?php
						if ($_SESSION['login']) :
							if ($_SESSION['logged_as'] == 'super_admin' or $_SESSION['logged_as'] == 'ddi' or $_SESSION['logged_as'] == 'mentor') :
						?>
								<div style="padding-left: 6px">
									<b>Hai, <?php echo $_SESSION['username']; ?></b>
									<br />
									<br />
									(<?php echo $_SESSION['logged_as']; ?>)
								</div>
							<?php
							else :
							?>
								<div style="padding-left: 6px">
									<b><?php echo $_SESSION['fullname']; ?></b>
									<br />
									<br />
									(<?php echo $_SESSION['username']; ?>)
								</div>
							<?php
							endif;
							if (isset($_SESSION['is_admin']))
								echo "<a href='" . base_url('login_mhs_admin.php?id=' . $_SESSION['is_admin']) . "' data-toggle='back_akun' class='login' style='margin-right: 68px;'>Back to Admin</a>";
							echo "<a href='" . rules('act_logout') . "' class='login'>Logout</a>";
						else :
							?>

							<label>Nomor Mahasiswa</label>
							<input name="username" size="15" id="usr" class="usr" type="text" placeholder="__.__.____">
							<label>Password</label>
							<input name="password" size="15" id="pwd" class="pwd" type="password">
							<br />
							<input value=" Login " class="login" type="submit">
							<?php
							//aktifkan komentar untuk close
							// $aktif = "buka";
							if ($aktif == "buka") { ?>
								<a href="<?php echo rules("reg_mhs"); ?>" class="login" style="margin-right: 68px;"><b style="font-size: 11px;">Registrasi PPM</b></a>
							<?php } else {
							?>
								<a onClick="alert('Maaf, pendaftaran sudah ditutup ya kak!')" class="login" style="margin-right: 50px;"><b style="font-size: 11px;">Registrasi Tutup</b></a>
							<?php
							}
							?>

						<?php

						endif;
						?>

					</form>
				</div>
				<div class="col-xs-12" id="menu_a" style="border-bottom-left-radius:0.8em;border-bottom-right-radius:0.8em;">
					<div id="menu_domain">
						<?php include "pages/layouts/menu.php"; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="border-radius:0.8em; margin-top:5%; background: #FFF; padding-top: 20px">
			<div class="col-xs-3">
				<?php include "pages/layouts/left.php"; ?>
			</div>
			<div class="col-xs-9">
				<?php include "pages/layouts/right.php"; ?>
			</div>
			<div class="col-xs-12" style="border-top: 1px solid #D0D4D4">
				<?php include "pages/layouts/footer.php"; ?>
			</div>
		</div>
	</div>

	<script src="resource/assets/js/superfish.js"></script>
	<script src="resource/assets/js/bootstrap-datepicker.js"></script>
	<script src="resource/assets/js/jquery.bootstrap.wizard.js"></script>
	<script src="resource/assets/js/js_lib.js"></script>
	<!--<script src="resource/assets/js/jquery.masked.min.js"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
	<script>
		$(document).ready(function() {
			//		$('ul.sf-menu').superfish();

			$("#formlogin").submit(function() {
				var uname = $("input[name=username]").val();
				var password = $("input[name=password]").val();

				if (uname == "" || password == "") {
					alert("Isi username dan password dengan benar.");
				} else {
					var method = $(this).attr('method');
					var target = $(this).attr('action');
					var data = $(this).serialize();

					$.ajax({
						type: method,
						data: data,
						url: target,
						beforeSend: function() {
							$(".login").attr("disabled", "disabled");
						}
					}).done(function(response) {
						if (response == "true") {
							$(".login").removeAttr("disabled");
							location.href = '<?php echo base_url(); ?>';
						} else {
							$(".login").removeAttr("disabled");
							alert(response);
						}
					});
				}

				return false;
			});
		});
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox();
		});
		$(document).on('click', '[data-toggle="change_akun"]', function(event) {
			event.preventDefault();
			console.log($(this).attr('href'));
			$.get($(this).attr('href'), function(data) {
				if (data == 'true')
					window.open('<?= base_url(); ?>', '_blank');
			});
		})
		$(document).on('click', '[data-toggle="back_akun"]', function(event) {
			event.preventDefault();
			console.log($(this).attr('href'));
			$.get($(this).attr('href'), function(data) {
				if (data == 'true')
					window.close();
			});
		})
	</script>
</body>

</html>
