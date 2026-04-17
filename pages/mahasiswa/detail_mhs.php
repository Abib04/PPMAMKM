<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#data_mhs" data-toggle="tab">Data Mahasiswa</a></li>
  <li role="presentation"><a href="#data_kel" data-toggle="tab">Data Keluarga</a></li>
  <li role="presentation"><a href="#data_penyakit" data-toggle="tab">Data Penyakit</a></li>
  <li role="presentation"><a href="#data_prestasi" data-toggle="tab">Data Prestasi</a></li>
  <li role="presentation"><a href="#data_potensi" data-toggle="tab">Data Potensi</a></li>
</ul>

<div class="tab-content" style="margin-top: 10px;">
	<div id="data_mhs" class="tab-pane active">
		<form action='<?php echo rules("act_update_mhs"); ?>&id=<?php echo $_GET['npm']; ?>' method="post" id="formMhs" class="form-group-sm" enctype="multipart/form-data">
			<?php include "pages/mahasiswa/form_mhs.php"; ?>
		</form>
	</div>
	<div id="data_kel" class="tab-pane">
		<?php include "pages/keluarga/reg_ortu_form.php"; ?>
	</div>
	<div id="data_penyakit" class="tab-pane">
		<?php include "pages/penyakit/penyakit_mhs.php"; ?>
	</div>
	<div id="data_prestasi" class="tab-pane">
		<?php include "pages/prestasi/prestasi_mhs.php"; ?>
	</div>
	<div id="data_potensi" class="tab-pane">
		<?php include "pages/potensi/potensi_mhs.php"; ?>
	</div>
</div>
