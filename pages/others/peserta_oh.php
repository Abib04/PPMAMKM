<a href="presensi.php?op=oh" class="btn btn-sm btn-success" target="_blank">Cetak Presensi</a>
<!--<a href="" class="btn btn-sm btn-info" >Bagikan Ruangan</a>-->
<hr />
<table>
	<tr>
		<td>Total Peserta </td>
		<td> : </td>
		<td><b><?php echo count(db_read("select nama_kel from vsesi_oh where id_thn='".get_year(get_active_year())."'"));?></b></td>
	</tr>
<!--	<tr>
		<td>Sudah Konfirmasi </td>
		<td>:</td>
		<td><b><?php //echo count(db_read("select file_kehadiran from vsesi_oh where file_kehadiran is not null and id_thn='".get_year(get_active_year())."'"));?></b></td>
	</tr>
	<tr>
		<td>Belum Konfirmasi </td>
		<td>:</td>
		<td><b><?php //echo count(db_read("select file_kehadiran from vsesi_oh where file_kehadiran is null and id_thn='".get_year(get_active_year())."'"));?></b></td>
	</tr>
	-->
</table>
<hr />
<table class="table table-bordered" id="table_oh" width="100%">
	<thead>
		<tr>
			<th>Nama Keluarga</th>
			<th>NPM</th>
			<th>Waktu Kegiatan</th>
            <th>Ruang Kegiatan</th>
			<!--<th>Status</th>-->
			<th>Aksi</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Nama Keluarga</th>
			<th>NPM</th>
			<th>Waktu Kegiatan</th>
            <th>Ruang Kegiatan</th>
			<!--<th>Status</th>-->
			<th>Aksi</th>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $("#table_oh").DataTable({
			"ajax":{
				"url" : "<?php echo BASE_URL; ?>data.php?module=mod_sesi&t=sesi_ruang_oh&op=read_full",
				"dataSrc" : ""
			},
			"deferRender": true,
			"columns": [
				{"data":"nama_kel"},
				{"data":"npm"},
				{"render":function(data, type, row){
					return row.jam_mulai+"-"+row.jam_akhir;
				}},
                {"data":"nama_ruang"},
				//{"render":function(data, type, row){
				//	if(row.file_kehadiran == null){
				//		return "Belum Konfirmasi";
				//	}else{
				//		return "Sudah Konfirmasi<br /><a href='<?php echo base_url('resource/mahasiswa/file_kehadiran_ortu/')?>"+row.npm+".jpg' data-toggle='lightbox'>Lihat File</a>";
				//	}
				//}},
				{"render": function(data, type, row){
					var mn_admin = "<a href='<?php echo rules('act_delete_sesi'); ?>&t=sesi_ruang_oh&id="+row.id_sesi_oh+"&npm="+row.npm+"&xhr' class='delete'>Hapus</a>";

					return mn_admin;
				}}
			],
		});

		$("#table_oh").on('click','.delete', function(){
			var url = $(this).attr("href");
			var c = confirm("Yakin ingin menghapus data ini?");
			if(c == true){
				$.get(url, function(data, status){
					if(data == "true"){
						alert("Berhasil dihapus.");
						table.ajax.reload();
					}else{
						alert(data);
					}
				});
			}

			return false;
		});

		$("#div_room").click(function(){
			$(this).attr("disabled","disabled");
			$(this).html("Sedang Proses...");
			$.post("<?php echo rules('act_insert_sesi'); ?>&t=sesi_ruang_oh&op=div_room", function(data, status){
				if(data == "true"){
					alert("Berhasil Diproses");
					$(this).removeAttr("disabled");
					$(this).html("Bagikan Ruangan");
				}else{
					alert(data);
				}

				location.reload();
			});
		});
	});
	$(document).ready(function() {
		$(".popup_image").click(function() {
			console.log("fired");
			w2popup.open({
				title: 'Image',
				body: '<div class="w2ui-centered"><img src="' + $(this).attr('src') + '"></img></div>'
			});
			return false;
		});
	});
</script>
