<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>

<?php endif; ?>
<ul class="nav nav-pills">
	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<li role="presentation" class="active"><a href="#fakultas" data-toggle="tab">Fakultas</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<li role="presentation"><a href="#prodi" data-toggle="tab">Prodi</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<li role="presentation"><a href="#agama" data-toggle="tab">Agama</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#bid_prestasi" data-toggle="tab">Bidang Prestasi</a></li>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#jenis_potensi" data-toggle="tab">Jenis Potensi</a></li>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#bid_potensi" data-toggle="tab">Bidang Potensi</a></li>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#detail_potensi" data-toggle="tab">Detail Potensi</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#hub_keluarga" data-toggle="tab">Hubungan Keluarga</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#negara" data-toggle="tab">Negara</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#provinsi" data-toggle="tab">Provinsi</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#kabupaten" data-toggle="tab">Kabupaten</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#penyakit" data-toggle="tab">Penyakit</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<li role="presentation"><a href="#posisi_panitia" data-toggle="tab">Posisi Panitia</a></li>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<li role="presentation"><a href="#tahun" data-toggle="tab">Tahun</a></li>
	<?php endif; ?>
</ul>
<hr />
<div class="tab-content">
	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="fakultas" class="tab-pane fade in active">
			<?php include "pages/fakultas/form_fakultas.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="prodi" class="tab-pane fade in ">
			<?php include "pages/fakultas/form_prodi.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="agama" class="tab-pane fade in ">
			<?php include "pages/agama/form_agama.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="bid_prestasi" class="tab-pane fade in">
			<?php include "pages/prestasi/bid_prestasi.php"; ?>
		</div>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="jenis_potensi" class="tab-pane fade in">
			<?php include "pages/potensi/jenis_potensi.php"; ?>
		</div>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="bid_potensi" class="tab-pane fade in">
			<?php include "pages/potensi/bid_potensi.php"; ?>
		</div>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="detail_potensi" class="tab-pane fade in">
			<?php include "pages/potensi/detail_potensi.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="hub_keluarga" class="tab-pane fade in">
			<?php include "pages/keluarga/hub_keluarga.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="negara" class="tab-pane fade in">
			<?php include "pages/negara/negara.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="provinsi" class="tab-pane fade in">
			<?php include "pages/daerah/form_daerah.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="kabupaten" class="tab-pane fade in">
			<?php include "pages/daerah/form_kabupaten.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<div id="penyakit" class="tab-pane fade in">
			<?php include "pages/penyakit/penyakit.php"; ?>
		</div>
	<?php endif; ?>
	
	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="posisi_panitia" class="tab-pane fade in">
			<?php include "pages/panitia/posisi.php"; ?>
		</div>
	<?php endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="tahun" class="tab-pane fade in">
			<?php include "pages/tahun/form_tahun.php"; ?>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  e.target // newly activated tab
		  e.relatedTarget // previous active tab
		})
	});
</script>
