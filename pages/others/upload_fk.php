<?php
	$mhs = db_read("select npm,nama,foto from mahasiswa where npm='".$_SESSION['username']."'");
	$ortu = 
?>
<legend>Foto Mahasiswa</legend>
<table class="table table-bordered">
	<tr>
		<th>NIM</th>
		<th>Nama Mahasiswa</th>
		<th>Status</th>
		<th>Aksi</th>
	</tr>
	<tr>
		<td><?php echo $mhs[0]['npm']; ?></td>
		<td><?php echo $mhs[0]['nama'];?></td>
		<td>
			<?php 
				if($mhs[0]['foto'] == NULL){
					echo "Tidak ada foto";
				}else{
					echo "Foto sudah di-upload.";
				}
			?>
		</td>
		<td>
			<form action="<?php echo rules('act_submit_foto'); ?>&o=foto_mhs" class="form-inline">
				<div class="form-group">
					<label for="img_mhs" class="btn btn-default btn-sm">Pilih Foto...</label>
					<input type="file" name="img_mhs" id="img_mhs" style="display: none;"required />
				</div>
				<button type="submit" id="kirim_foto_mhs" class="btn btn-primary btn-sm">Kirim</button>
			</form>
		</td>
	</tr>
</table>

<hr />

