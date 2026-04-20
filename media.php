<?php
// session_save_path(getcwd() . "/logs");
include "lib/db_lib.php";
sess_start();
init_();
$aktif = "tutup"; // Definisi variabel aktif agar tidak error
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
	<link rel="stylesheet" href="resource/assets/css/custom.css?v=2.0.1" type="text/css">
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
	<div class="hero-header">
		<div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; width: 100%;">
			<a href="http://www.amikom.ac.id/index.php/main" target="_blank" style="display: inline-block; margin-bottom: 20px;">
				<img src="<?php echo base_url("resource/assets/images/Logo_Amikom_color.png"); ?>" class="top-brand" style="max-height: 110px; filter: brightness(0) invert(1) drop-shadow(0 4px 10px rgba(0,0,0,0.3));" alt="Universitas Amikom" />
			</a>
			<br>
			<!-- Framed PPM 2025 Banner -->
			<div style="animation: float 4s ease-in-out infinite; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.2); padding: 5px; border-radius: 25px; display: block; width: 100%; box-shadow: 0 15px 35px rgba(0,0,0,0.3); position: relative; z-index: 2; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
				<img src="<?php echo base_url("resource/assets/images/header_temp_2025.png"); ?>" style="max-height: 200px; max-width: 100%; border-radius: 20px; display: block; margin: 0 auto;" alt="PPM 2025 Banner">
			</div>
		</div>
	</div>

	<div class="container" style="position: relative;">
		
		<!-- Navigation Section -->
		<div class="nav-wrapper">
			<div id="menu_a">
				<div id="menu_domain">
					<?php include "pages/layouts/menu.php"; ?>
				</div>
			</div>
			
			<!-- Nav Auth Buttons added per client request -->
			<div class="nav-auth-btns" style="margin-left: 15px;">
				<?php if (!isset($_SESSION['login']) || !$_SESSION['login']) : ?>
					<?php if ($aktif == "buka") : ?>
						<a href="<?php echo rules("reg_mhs"); ?>" class="btn-nav btn-register">Registrasi</a>
					<?php endif; ?>
					<a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" class="btn-nav btn-login">Masuk</a>
				<?php else: ?>
					<a href="<?php echo rules('act_logout'); ?>" class="btn-nav btn-login" style="background:var(--primary); color:white; border:none;">Keluar</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Main Content Section (Now Section 2) -->
		<div class="content-card">
			<?php include "pages/layouts/right.php"; ?>
		</div>

		<!-- Login Section (Moved to Section 3) -->
		<!-- Login Modal Section -->
		<?php if (!$_SESSION['login']) : ?>
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" style="z-index: 9999;">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 24px; border: none; background: transparent; box-shadow: none;">
			      <div class="login-section" style="margin: 0 auto; width: 100%;">
			      	<h3 class="text-center mb-4">LOGIN AREA</h3>
			      	<form id="formlogin" method="post" action="<?php echo rules("act_login"); ?>">
			      		<label>Nomor Mahasiswa</label>
			      		<input name="username" size="15" id="usr" class="usr" type="text" placeholder="__.__.____">
			      		<label>Password</label>
			      		<input name="password" size="15" id="pwd" class="pwd" type="password">
			      		<button type="submit" class="login btn-block mt-3" style="width: 100%; border-radius: 14px;"> Login </button>
			      	</form>
			      	<div class="text-center mt-3">
			      		<?php if ($aktif == "buka") : ?>
			      			<a href="<?php echo rules("reg_mhs"); ?>" class="text-muted small">Registrasi PPM</a>
			      		<?php else : ?>
							<a onClick="alert('Maaf, pendaftaran sudah ditutup ya kak!')" class="text-muted small">Registrasi Tutup</a>
						<?php endif; ?>
			      	</div>
			      </div>
                </div>
              </div>
            </div>
		<?php else: ?>
			<div class="text-center mb-4">
				<div class="nav-wrapper p-3 d-inline-block" style="margin-bottom: 20px;">
					<span>Hai, <b><?php echo $_SESSION['username']; ?></b> (<?php echo $_SESSION['logged_as']; ?>)</span>
					<a href="<?php echo rules('act_logout'); ?>" class="btn btn-sm btn-danger ml-3" style="background: #e74c3c; color: white; border: none; padding: 5px 15px; border-radius: 5px; text-decoration: none;">Keluar</a>
				</div>
			</div>
		<?php endif; ?>

		<!-- Info Section (Section 4) -->
		<div class="content-card">
			<?php include "pages/layouts/left.php"; ?>
		</div>

	</div>

	<footer>
		<div class="container">
			<?php include "pages/layouts/footer.php"; ?>
		</div>
	</footer>

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
							location.href = 'redirect.php';
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
