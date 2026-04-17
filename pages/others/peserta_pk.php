<button type="button" class="btn btn-sm btn-primary" id="div_room">Bagikan Ruangan</button>
<a href="presensi.php?op=pk" class="btn btn-sm btn-success" target="_blank">Cetak Presensi</a>
<a href="rekap.php?op=penyakit_mhs&acara=1" class="btn btn-sm btn-warning" target="_blank">Rekap Penyakit</a>
<hr />

<table class="table table-bordered" id="table_pk">
	<thead>
		<tr>
			<th>Nama Mahasiswa</th>
			<th>NPM</th>
			<th>Tanggal</th>
			<th>Ruang</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			// print_r(db_free_query("select npm,nama,nama_ruang,tanggal from vsesi_pk"));
			$sql = db_read("select id_sesi_pk,npm,nama,nama_ruang,tanggal from vsesi_pk where id_thn='".get_year(get_active_year())."'");
			// $sql = db_read("select * from mahasiswa");
			// print_r($sql);
			foreach ($sql as $key => $value) {
				echo "<tr>
						<td>".$value['nama']."</td>
						<td>".$value['npm']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_ruang']."</td>
						<td>
							<a href='".rules('detail_mhs')."&npm=".$value['npm']."'>Detail</a>
							<a href='".rules('act_delete_sesi')."&t=sesi_ruang_pk&id=".$value['id_sesi_pk']."' class='delete'>Hapus</a>
						</td>
					</tr>";	
			}
		?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$("#table_pk").DataTable();

		$("#div_room").click(function(){
			$(this).attr("disabled","disabled");
			$(this).html("Sedang Proses...");
			$.post("<?php echo rules('act_insert_sesi'); ?>&t=sesi_ruang_pk", function(data, status){
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

		$("#table_pk").on('click','.delete', function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin menghapus data ini?");
            if(c == true){
                $.get(url, function(data, status){
                    if(data == "true"){
                        alert("Berhasil dihapus.");
                        location.reload();
                    }else{
                        alert(data);
                    }
                });
            }

            return false;
        });
	});
</script>
