<?php
    // $total_mhs = count(db_read("select npm from mahasiswa where id_thn='" . get_year(get_active_year()) . "' and konfirmasi = 'Y'"));
	$total_mhs = count(db_read("select npm from mahasiswa where id_thn='" . get_year(get_active_year()) . "'"));
	$sudah_konfirm = count(db_read("select npm from mahasiswa where id_thn='" . get_year(get_active_year()) . "' and konfirmasi = 'Y'"));
    $sudah_isi = count(db_read("select DISTINCT(potensi.npm) from potensi join mahasiswa on mahasiswa.npm = potensi.npm and konfirmasi = 'Y' where mahasiswa.id_thn='" . get_year(get_active_year()) . "'"));
    $belum_isi = $total_mhs - $sudah_isi;
?>

<div class="row">
	<div class="col-xs-12">
		<table class="table">
		<tr>
			<td>Total Pendaftar</td>
			<td> : </td>
			<td><b class="total-pendaftar"><?php echo $total_mhs; ?></b></td>

			<td style="padding-left:50px">Laki-Laki</td>
			<td> : </td>
			<td><b><?php echo count(db_read("select npm from mahasiswa where jk = 'laki-laki'  and id_thn='" . get_year(get_active_year()) . "'")); ?></b></td>
			
			<td style="padding-left:50px">Perempuan</td>
			<td> : </td>
			<td><b><?php echo count(db_read("select npm from mahasiswa where jk = 'perempuan' and id_thn='" . get_year(get_active_year()) . "'")); ?></b></td>
		</tr>
		<tr>
			<td>Sudah Konfirmasi </td>
			<td>:</td>
			<td><b class="total-konfirmasi"><?php echo $sudah_konfirm; ?></b></td>

			<td>Belum Konfirmasi </td>
			<td>:</td>
			<td><b class="total-remain"><?php echo ($total_mhs - $sudah_konfirm); ?></b></td>
			
			<td>Sudah Mengisi Data PPM</td>
			<td> : </td>
			<td><b><?php echo $sudah_isi ?></b></td>
			
		</tr>
		<!-- <tr>
			<td>Belum Konfirmasi </td>
			<td>:</td>
			<td><b class="total-remain"><?php //echo ($total_mhs - $sudah_konfirm); ?></b></td>

			<td>Belum Mengisi Potensi</td>
			<td>:</td>
			<td><b class="total-remain"><?php //echo $belum_isi; ?></b></td>
			</tr> -->
			<!--<tr>-->
			<!--	<td>Pendaftar Tahun <?php //echo get_active_year(); ?> </td>-->
			<!--	<td>:</td>-->
			<!--	<td><b><?php //echo count(db_read("select npm from mahasiswa where npm like '" . substr(get_active_year(), -2) . ".%'")); ?></b></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<td>Pendaftar Selain Tahun <?php //echo get_active_year(); ?> </td>-->
			<!--	<td>:</td>-->
			<!--	<td><b><?php //echo count(db_read("select npm from mahasiswa where npm not like '" . substr(get_active_year(), -2) . ".%'")); ?></b></td>-->
			<!--</tr>-->
		</table>
	</div>
</div>

<hr />
<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#form_daftar_ulang" title="Daftar Ulang"><i class="fa fa-history" aria-hidden="true"></i> Daftar Lagi</button>
<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#form_reset_passwd" title="Reset Password"><i class="fa fa-key" aria-hidden="true"></i> Reset Pass</button>
<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#form_double" title="Cek data double"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> Double </button>
<a href="<?php echo BASE_URL; ?>rekap.php?op=rekap_pendaftar" target="_blank" class="btn btn-success btn-sm" title="Rekap Semua data mahasiswa."><i class="fa fa-file-text-o" aria-hidden="true"></i> Semua</a>
<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#form_cetak_kelompok" title="Rekap data per kelompok"><i class="fa fa-file-text-o" aria-hidden="true"></i> Kelompok</button>
<button class="btn btn-primary btn-sm" title="Bagikan Sertifikat."><i class="fa fa-certificate" aria-hidden="true"></i> Sertifikat</button>

<?php if ($_SESSION['logged_as'] == "super_admin") : ?>

	<label for="tahun"><select name="tahun" id="filter_tahun" class="form-control">
			<?php
			$thn = db_read("select * from tahun order by thn desc");
			foreach ($thn as $key => $value) {
				$no = ($value['status'] == y) ? 'selected' : '';
				echo "<option value=\"" . $value['id_thn'] . "\" " . $no . " >" . $value['thn'] . "</option> ";
			}
			?>
		</select>
	</label>

<?php endif; ?>

<div class="form-group inline"></div>
<div class="modal fade" id="form_daftar_ulang" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo BASE_URL ?>data.php?module=mod_mahasiswa&op=reset_mhs" method="post" class="form-group-sm" id="reset_mhs">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Daftarkan Ulang Peserta</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="npm">NPM</label>
						<input type="text" maxlength="10" name="npm" class="form-control" required />
					</div>
					<p id="msg"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Daftarkan Ulang</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="form_reset_passwd" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo BASE_URL ?>data.php?module=mod_mahasiswa&op=reset_passwd" method="post" class="form-group-sm" id="reset_passwd">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Reset Password Mahasiswa</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="npm">NPM</label>
						<input type="text" maxlength="10" name="npm" class="form-control" required />
					</div>
					<p id="message"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="form_cetak_kelompok" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-3">
						<div class="form-group">
							<label for="tahun">Tahun : </label>
							<select name="tahun" id="tahun" class="form-control">

								<?php
								$thn = db_read("select * from tahun order by thn desc");
								foreach ($thn as $key => $value) {
									echo "<option value=\"" . $value['id_thn'] . "\" >" . $value['thn'] . "</option> ";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row" id="list_kelompok">
					<?php
					$data = db_read("select * from vkelompok where id_thn=" . get_year(get_active_year()));
					foreach ($data as $key => $value) {
						echo "<div class=\"col-xs-6 kelompok \" ><a target=\"_blank\" href=\"" . BASE_URL . "rekap.php?op=rekap_pendaftar&kel=" . $value['id_kelompok'] . "\" class=\"btn\">" . $value['nama_kelompok'] . "</a></div>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="form_double" tabindex="-1">
	<div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Data Double (Nama/HP/Email)</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-striped table-hover table-bordered">
							<thead>
								<tr>
									<th>NIM</th>
									<th>Nama</th>
									<th>HP</th>
									<th>Email</th>
									<th>Konfirmasi & ID Potensial</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								/*$q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM `mahasiswa` WHERE `id_thn` = ".get_id_active_year()." AND mahasiswa.email not in('-','',' ') AND (SELECT count(a.nama) from mahasiswa a where a.`id_thn` = ".get_id_active_year()." AND (a.nama = mahasiswa.nama and (a.hp = mahasiswa.hp or a.email = mahasiswa.email or a.tgl_lahir = mahasiswa.tgl_lahir))) > 1  
				 	ORDER BY `mahasiswa`.`nama`,mahasiswa.hp, mahasiswa.email ASC");*/

								//Ubah Query Biar Proses Cepat
								/*
				 	$q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM `mahasiswa` 
WHERE `id_thn` = ".get_id_active_year()." AND mahasiswa.email not in('-','',' ') 
AND
(
SELECT count(a.nama) 
from mahasiswa a 
where a.`id_thn` = ".get_id_active_year()." 
GROUP BY a.nama, a.hp, a.email, a.tgl_lahir
HAVING 
count(a.nama) > 1
AND (count(a.hp) > 1 OR count(a.email) > 1 OR count(a.tgl_lahir) > 1)
) > 1
ORDER BY `mahasiswa`.`nama`,mahasiswa.hp, mahasiswa.email ASC");*/

								// ===== QUERY LAMA =====
								// $q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM `mahasiswa` a
								// WHERE `id_thn` = " . get_id_active_year() . " AND a.email not in('-','',' ') 

								// GROUP BY a.nama, a.hp, a.email, a.tgl_lahir
								// HAVING 
								// count(a.nama) > 1
								// AND (count(a.hp) > 1 OR count(a.email) > 1 OR count(a.tgl_lahir) > 1)

								// ORDER BY `a`.`nama`,a.hp, a.email ASC");

								// ===== QUERY BARU =====
								// 								$z = db_read("SELECT nama 
								// FROM mahasiswa 
								// WHERE npm IN  (SELECT npm  FROM mahasiswa GROUP BY nama HAVING count(*) > 1)");

								// 								$q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` 
								// FROM 'mahasiswa' a
								// WHERE 'npm' IN  (SELECT 'npm'  FROM 'mahasiswa' a GROUP BY a.nama, a.hp, a.email, a.tgl_lahir HAVING count(a.nama) > 1 AND (count(a.hp) > 1 OR count(a.email) > 1 OR count(a.tgl_lahir) > 1)");

								// $q = db_read("SELECT nama FROM mahasiswa GROUP BY nama HAVING COUNT(nama) > 1");

								$q = db_read("SELECT id_potensi,mahasiswa.npm,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM mahasiswa LEFT JOIN potensi ON potensi.npm = mahasiswa.npm WHERE nama IN (SELECT nama FROM mahasiswa WHERE mahasiswa.id_thn = " . get_id_active_year() . " AND mahasiswa.email not in('-','',' ') GROUP BY mahasiswa.nama HAVING COUNT(mahasiswa.nama) > 1 OR COUNT(mahasiswa.hp) > 1 OR COUNT(mahasiswa.email) > 1) ORDER BY mahasiswa.nama");

								// $q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM mahasiswa WHERE npm IN (SELECT `npm` FROM mahasiswa GROUP BY name HAVING count(nama) > 1 OR count(hp) > 1");
								// var_dump($q);

								//$q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM `mahasiswa` WHERE `id_thn` = ".get_id_active_year()."");
								//$q = db_read("SELECT `npm`,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM `mahasiswa` WHERE `id_thn` = ".get_id_active_year()." AND id_negara = 1012");
								foreach ($q as $k => $v) {
								?>
									<tr>
										<td><?= $v['npm'] ?></td>
										<td><?= $v['nama'] ?></td>
										<td><?= $v['hp'] ?></td>
										<td><?= $v['email'] ?></td>
										<td>
											<?php echo ($v['konfirmasi'] == 'Y') ? '<span class="label label-success">
                                                    SUDAH
                                                </span>' : '<span class="label label-danger">
												BELUM
											</span>';  
											
											echo '<br/>'.$v['id_potensi'];
											?>
										</td>
										<td width="150px">
											<a class="btn btn-primary btn-sm" href="<?php echo rules('detail_mhs'); ?>&npm=<?= $v['npm']; ?>" target="_blank">Lihat</a>
											<a class="btn btn-danger btn-sm" href="<?php echo rules('act_delete_mhs'); ?>&id=<?= $v['npm']; ?>" class='delete'>Hapus</i></a>

											<!-- <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#form_daftar_ulang" title="Daftar Ulang"><i class="fa fa-history" aria-hidden="true"></i> Daftar Lagi</button> -->
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<hr />

<table class="table table-bordered table-hovered" id="data_mhs">
	<thead>
		<tr>
			<th>Nama Mahasiswa</th>
			<th>NPM</th>
			<th>No. Telepon</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Nama Mahasiswa</th>
			<th>NPM</th>
			<th>No. Telepon</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	$(document).ready(function() {

		var table = $("#data_mhs").DataTable({
			"ajax": "<?php echo BASE_URL; ?>data.php?module=mod_mahasiswa&op=read_spesial&th=" + <?php echo get_year(get_active_year()) ?>,
			"deferRender": true,
			"processing": true,
			"serverSide": true,
			"columns": [{
					"data": "nama"
				},
				{
					"data": "npm"
				},
				{
					"data": "hp"
				},
				{
					"render": function(data, type, row) {

						var labelBelum = "<span class='label label-danger'>Belum Konfirmasi</span>";
						var labelSudah = "<span class='label label-success'>Sudah Konfirmasi</span>";

						if (row.konfirmasi == "N") {
							return labelBelum;
							// return "Belum Konfirmasi";
						} else {
							return labelSudah;
							// return "Sudah Konfirmasi";
						}

					}
				},
				{
					"render": function(data, type, row) {
						var konfirmasi = (row.konfirmasi == "N") ? "<li><a href='<?php echo rules('act_conf_mhs'); ?>&id=" + row.npm + "'>Konfirmasi</a></li>" : "";
						var hp = 62 + row.hp.substr(1);

						var mn_dm = "<div class='dropdown'>" +
							"<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' id='action'>" +
							"-- Pilih -- <span class='caret'></span>" +
							"</button>" +
							"<ul class='dropdown-menu' aria-labelledby='action'>" +
							"<li><a href='<?php echo rules('detail_mhs'); ?>&npm=" + row.npm + "'>Detail</a></li>" +
							"<li><a href='https://wa.me/" + hp + "' target='_blank'>WhatsApp</a></li>" +
							"<li><a href='<?= base_url('login_mhs_admin.php?id=') ?>" + row.npm + "<?= ($_SESSION['logged_as'] == 'super_admin') ? '&editable' : ''; ?>' data-toggle='change_akun' >Login As Mahasiswa</a></li>" +
							"<li><a href='<?php echo rules('act_delete_mhs'); ?>&id=" + row.npm + "' class='delete'>Hapus</a></li>" +
							konfirmasi +
							"<li><a href='<?php echo BASE_URL; ?>sertifikat.php?op=mahasiswa&id=" + row.npm + "' target='_blank'>Cetak Sertifikat</a></li>" +
							"</ul>" +
							"</div>";

						return mn_dm;
					}
				}
			]
		});

		$("#data_mhs").on('click', '.delete', function() {
			var url = $(this).attr("href");
			var c = confirm("Yakin ingin menghapus data ini?");
			if (c == true) {
				$.get(url, function(data, status) {
					if (data == "true") {
						alert("Berhasil dihapus.");
						table.ajax.reload();
					} else {
						alert(data);
						table.ajax.reload();
					}
				});
			}

			return false;
		});
		$("#form_double").on('click', '.delete', function() {
			var url = $(this).attr("href");
			var c = confirm("Yakin ingin menghapus data ini?");
			if (c == true) {
				$.get(url, function(data, status) {
					if (data == "true") {
						alert("Berhasil dihapus.");
						table.ajax.reload();
					} else {
						alert(data);
						table.ajax.reload();
					}
				});
			}

			return false;
		});
		$("#tahun").change(function() {
			//$(".kelompok a")
			var thn = $(this).val();
			var res = "";
			$.get("<?php echo rules('act_read_kelompok'); ?>&thn=" + thn + "", function(data, status) {
				var json = $.parseJSON(data);
				$.each(json, function(key, value) {
					res += "<div class='col-xs-3 kelompok' ><a target='_blank' href='rekap.php?op=rekap_pendaftar&kel=" + value['id_kelompok'] + "' class='btn'>" + value['nama_kelompok'] + "</a></div>";
				});
				$("#list_kelompok").html(res);
			});


		});
		<?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
			$("#filter_tahun").change(function() {
				$.get("<?php echo rules("act_read_mhs"); ?>&th=" + $(this).val(), function(data, status) {
					var json = $.parseJSON(data);
					var res = "";
					$.each(json, function(key, value) {
						res += "";
						$("input[name=thn]").val(value['thn']);
						$("input[name=status_tahun]:radio[value=" + value['status'] + "]").prop("checked", true);
					});
				});


				// return false;
				thn = $(this).val();
				$.get("<?php echo rules("act_read_mhs_jumlah"); ?>&th=" + thn, function(data, status) {
					var json = $.parseJSON(data);
					$.each(json, function(key, value) {
						$(".total-pendaftar").html(value['total']);
						$(".total-konfirmasi").html(value['konfirmasi']);
						$(".total-remain").html(value['belum']);
					});
				});
				//table.ajax.url( "<?php echo rules("act_read_mhs"); ?>&th="+$(this).val() ).load();
				table.ajax.url("<?= base_url('data.php?module=mod_mahasiswa&op=read_spesial'); ?>&th=" + $(this).val()).load();
			});
		<?php endif; ?>
		$("#reset_mhs").submit(function() {
			var method = $(this).attr("method");
			var data = $(this).serialize();
			var target = $(this).attr("action");
			$("#msg").html("");
			$.ajax({
				type: method,
				url: target,
				data: data,
				beforeSend: function() {
					$("#reset_mhs button[type=submit]").attr("disabled", "disabled");
					$("#reset_mhs button[type=submit]").html("Menunggu...");
				}
			}).done(function(response) {
				$("#reset_mhs button[type=submit]").html("Daftarkan Ulang");
				$("#reset_mhs button[type=submit]").removeAttr("disabled");
				if (response == "true") {
					$("#msg").html("Mahasiswa sudah di daftarkan kembali dengan Password baru : <b>ppmamikom</b>");
				} else {
					$("#msg").html(response);
				}
			});

			return false;
		});
		$("#reset_passwd").submit(function() {
			var method = $(this).attr("method");
			var data = $(this).serialize();
			var target = $(this).attr("action");
			$("#message").html("");
			$.ajax({
				type: method,
				url: target,
				data: data,
				beforeSend: function() {
					$("#reset_passwd button[type=submit]").attr("disabled", "disabled");
					$("#reset_passwd button[type=submit]").html("Menunggu...");
				}
			}).done(function(response) {
				$("#reset_passwd button[type=submit]").html("Simpan");
				$("#reset_passwd button[type=submit]").removeAttr("disabled");
				if (response == "true") {
					$("#message").html("Password berhasil di-reset. Silahkan gunakan password <b>ppmamikom</b>");
				} else {
					$("#message").html(response);
				}
			});

			return false;
		});
	});
</script>
