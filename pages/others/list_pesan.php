<table class="table table-bordered" id="table_ks">
	<thead>
		<tr>
			<th>Nama</th>
			<th>E-mail</th>
			<th>Pesan</th>
			<!--<th>Waktu</th>-->
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql = db_read("select * from kritik_saran where id_thn='".get_year(get_active_year())."'");
			foreach ($sql as $key => $value) {
				echo "<tr>
							<td>".$value['nama']."</td>
							<td>".$value['email']."</td>
							<td>".$value['pesan']."</td>".
				 			//<td>".$value['waktu']."</td>
							"<td>
								<a href='".base_url('media.php?page=detail_pesan&id='.$value['id_ks'])."'>Detail</a>
								<a href='".base_url('data.php?module=mod_ks&op=delete&id='.$value['id_ks'])."' class='delete'>Hapus</a>
							</td>
						</tr>";
			}
		?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$("#table_ks").DataTable();
		$("#table_ks").on('click','.delete', function(){
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
