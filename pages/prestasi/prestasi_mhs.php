<?php
$cek_potensi = ($_SESSION['cek_potensi']>0)? TRUE : cek_potensi();
if($cek_potensi){
?>
<div class="row form-group-sm" style="margin-top: 10px;">
	<form action="<?php echo rules('act_insert_prestasi'); ?>&t=prestasi" method="post" id="formPrestasi" class="form-group-sm">
		<div class="col-xs-5">
			<div class="form-group">
				<label for="nama_prestasi">Nama Prestasi</label>
				<input type="text" class="form-control" name="nama_prestasi" />
			</div>

			<div class="form-group">
				<label for="cak_prestasi">Cakupan Prestasi</label>
				<select name="cak_prestasi" class="form-control">
					<option value="">-- Pilih --</option>
					<option value="Internasional">Internasional</option>
					<option value="Nasional">Nasional</option>
					<option value="Region">Region</option>
					<option value="Lokal">Lokal</option>
				</select>
			</div>

			<div class="form-group">
				<label for="bid_prestasi">Bidang Prestasi</label>
				<select name="bid_prestasi" class="form-control">
					<option value="">-- Pilih --</option>
					<?php 
						$sql = db_read("select id_bid_prestasi, nama_bid from bid_prestasi where status='Y'");
						foreach ($sql as $key => $value): ?>
							
							<option value="<?php echo $value['id_bid_prestasi']; ?>"><?php echo $value['nama_bid']; ?></option>
						
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="col-xs-12">
			<p>
				<button type="submit" id="simpan_prestasi" class="btn btn-primary btn-sm">Tambahkan</button>
				<button type="reset" id="reset_prestasi" class="btn btn-default btn-sm">Reset</button>
			</p>
		</div>
	</form>
	<div class="col-xs-12">
		<table class="table table-bordered table-hovered" id="table_prestasi">
			<tr>
				<th>Nama Prestasi</th>
				<th>Cakupan Prestasi</th>
				<th>Bidang Prestasi</th>
				<th>Aksi</th>
			</tr>
			<?php
				if($_SESSION['logged_as'] == "mahasiswa"){
					$sql = db_read("select * from vprestasi where npm='".$_SESSION['username']."'");
				}else{
					$sql = db_read("select * from vprestasi where npm='".$_GET['npm']."'");
				}

				foreach ($sql as $key => $value) {
					echo "<tr>
							<td>".$value['nama_prestasi']."</td>
							<td>".$value['cak_prestasi']."</td>
							<td>".$value['nama_bid']."</td>
							<td>
								<a href='".rules("act_read_prestasi")."&t=prestasi&id=".$value['id_prestasi']."' class='edit'>Edit</a>
								<a href='".rules("act_delete_prestasi")."&t=prestasi&id=".$value['id_prestasi']."' class='delete'>Hapus</a>
							</td>
						  </tr>";
				}
			?>
		</table>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#formPrestasi").submit(function(){
			if($("input[name=nama_prestasi]").val() == "" || $("select[name=bid_prestasi]").val() == "" || $("select[name=cak_prestasi]").val() == ""){

				alert("Lengkapi form.");

			}else{
				var method = $(this).attr("method");
	            var data = $(this).serialize();
	            var target = $(this).attr("action");

	            $.ajax({
	                type: method,
	                url: target,
	                data: data,
	                beforeSend: function(){
	                    $("#simpan_prestasi").attr("disabled","disabled");
	                    $("#simpan_prestasi").html("Menunggu...");
	                }
	            }).done(function(response){
	                if(response == "true"){
	                    alert("Berhasil disimpan");
	                    location.reload();
	                }else{
	                    alert(response);
	                    $("#simpan_prestasi").removeAttr("disabled");
	                    $("#simpan_prestasi").html("Tambahkan");
	                }
	            });

			}

			$(this).attr("action","<?php echo rules('act_insert_prestasi'); ?>&t=prestasi");

			return false;
		});

		$("#reset_prestasi").click(function(){
			$("#formPrestasi").attr("action","<?php echo rules('act_insert_prestasi'); ?>&t=prestasi");
			$("#simpan_prestasi").html("Tambahkan");
		});

		$("#table_prestasi").on('click','.edit', function(){
			var url = $(this).attr("href");
			$.get(url, function(data, status){
				var json = $.parseJSON(data);
				$.each(json, function(key,value){
					$("input[name=nama_prestasi]").val(value['nama_prestasi']);
					$("select[name=bid_prestasi]").val(value['id_bid_prestasi']);
					$("select[name=cak_prestasi]").val(value['cak_prestasi']);
				});
			});

			$("#formPrestasi").attr("action",url.replace("read","update"));
			$("#simpan_prestasi").html("Perbarui");
			return false;
		});

		$("#table_prestasi").on('click','.delete', function(){
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
<?php
    
}else{
    echo '<h4 style="color:red;"><b>Data Potensi</b> Harus diisi terlebih dahulu minimal satu</h4>';
}
?>
