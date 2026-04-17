<?php
$conf = ($_SESSION['mhs_confirm'])? TRUE : get_confirm();
if($conf){
?>
<div class="row form-group-sm" style="margin-top: 10px;">
	<form action="<?php echo rules('act_insert_potensi'); ?>&t=potensi" method="post" id="formPotensi" class="form-group-sm">
		<div class="col-xs-5">
			

			<div class="form-group">
				<label for="jenis_potensi">Jenis Potensi</label>
				<select name="jenis_potensi" class="form-control">
					<option value="">-- Pilih --</option>
					<?php 
					$sql = db_read("select id_jenis, jenis_potensi from jenis_potensi where 1");
					foreach ($sql as $key => $value): ?>
						<option value="<?php echo $value['id_jenis']; ?>"><?php echo $value['jenis_potensi']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="form-group">
				<label for="id_pb">Bidang</label>
				<select name="id_pb" class="form-control">
					<option value="">-- Pilih --</option>
				</select>
			</div>
			
			<div class="form-group">
				<label for="potensi">Potensi</label>
				<input type="text" class="form-control" name="potensi" />
			</div>
		</div>
		<div class="col-xs-12">
			<p>
				<button type="submit" id="simpan_potensi" class="btn btn-primary btn-sm">Tambahkan</button>
				<button type="reset" id="reset_potensi" class="btn btn-default btn-sm">Reset</button>
			</p>
		</div>
	</form>
	<div class="col-xs-12">
		<table class="table table-bordered table-hovered" id="table_potensi">
			<tr>
				<th>Jenis Potensi</th>
				<th>Bidang</th>
				<th>Potensi</th>
				<th>Aksi</th>
			</tr>
			<?php
				if($_SESSION['logged_as'] == "mahasiswa"){
					$sql = db_read("select * from vpotensi where npm='".$_SESSION['username']."'");
				}else{
					$sql = db_read("select * from vpotensi where npm='".$_GET['npm']."'");
				}

				foreach ($sql as $key => $value) {
					echo "<tr>
							<td>".$value['jenis_potensi']."</td>
							<td>".$value['nama_bidang']."</td>
							<td>".$value['potensi']."</td>
							<td>
								<a href='".rules("act_read_potensi")."&t=potensi&id=".$value['id_potensi']."' class='edit'>Edit</a>
								<a href='".rules("act_delete_potensi")."&t=potensi&id=".$value['id_potensi']."' class='delete'>Hapus</a>
							</td>
						  </tr>";
				}
			?>
		</table>
	</div>
</div>


<script type="text/javascript">
	function change_jenis(id=""){
	    $('select[name="jenis_potensi"]').on('change', function() {
            $('select[name="id_pb"]').find('option').not(':first').remove();
            $.ajax({
                url: '<?php echo rules('get_potensi_bidang'); ?>',
                type: 'GET',
                data: {'id_jenis' : $(this).val(), 'id_pb':id},
                success: function(response) {
                    $('select[name="id_pb"]').html(response);
                }
            }).done(function(result){
                $("select[name=id_pb]").val(id);
            });
        }).change();
	}
	
	$(document).ready(function(){
		change_jenis();
		
		$("#formPotensi").submit(function(){
			if($("input[name=jenis_potensi]").val() == "" || $("select[name=id_pb]").val() == "" || $("select[name=potensi]").val() == ""){

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
	                    $("#simpan_potensi").attr("disabled","disabled");
	                    $("#simpan_potensi").html("Menunggu...");
	                }
	            }).done(function(response){
	                if(response == "true"){
	                    alert("Berhasil disimpan");
	                    location.reload();
	                }else{
	                    alert(response);
	                    $("#simpan_potensi").removeAttr("disabled");
	                    $("#simpan_potensi").html("Tambahkan");
	                }
	            });

			}

			$(this).attr("action","<?php echo rules('act_insert_potensi'); ?>&t=potensi");

			return false;
		});

		$("#reset_potensi").click(function(){
			$("#formPotensi").attr("action","<?php echo rules('act_insert_potensi'); ?>&t=potensi");
			$("#simpan_potensi").html("Tambahkan");
		});

		$("#table_potensi").on('click','.edit', function(){
			var url = $(this).attr("href");
			$.get(url, function(data, status){
				var json = $.parseJSON(data);

				$.each(json, function(key,value){
					$("input[name=potensi]").val(value['potensi']);
					$("select[name=jenis_potensi]").val(value['id_jenis']);
					change_jenis(value['id_pb']);
					
				});
			});

			$("#formPotensi").attr("action",url.replace("read","update"));
			$("#simpan_potensi").html("Perbarui");
			return false;
		});

		$("#table_potensi").on('click','.delete', function(){
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
    echo '<h4 style="color:red;"><b>Akun Anda Belum Aktif, Silahkan Lakukan Konfirmasi Pendaftaran PPM untuk melanjutkan penginputan data dengan menghubungi Whatsapp Hotline PPM <a href="https://wa.me/6285133359681" target="_blank">+62 851-3335-9681</a></b></h4>
    
    <p><b>Format Konfirmasi : </b><br/><br/>
    
    Nama : xxxxxx <br/>
    NIM : xx.xx.xxxx <br/><br/>
    
    Mengkonfirmasi akan bergabung dan menghadiri acara PPM tahun 2025</p>';
}
?>
