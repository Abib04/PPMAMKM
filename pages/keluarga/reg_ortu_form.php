<?php
$cek_potensi = ($_SESSION['cek_potensi']>0)? TRUE : cek_potensi();
if($cek_potensi){
?>
<form action="<?php echo rules("act_insert_klg"); ?>&t=keluarga<?php echo isset($_GET['npm']) ? "&npm=".$_GET['npm'] : ""; ?>" method="post" id="formKel" class="form-group-sm">
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">
				<label for="nama_kel">Nama Ayah / Ibu / Wali di Yogyakarta</label>
				<input type="text" name="nama_kel" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan nama ayah, ibu, atau wali." required />
			</div>
			<div class="form-group">
				<label for="telepon">No. Telepon</label>
				<input type="tel" name="telepon" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan no. telp. yang bisa dihubungi." required />
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan no. email yang valid." required />
			</div>
			<div class="form-group" style="margin-bottom:33px">
	            <label>Jenis Kelamin : </label><br />
	            <label class="radio-inline">
	              <input type="radio" name="jk_kel" value="laki-laki"> Laki-Laki
	            </label>
	            <label class="radio-inline">
	              <input type="radio" name="jk_kel" value="perempuan"> Perempuan
	            </label>
	        </div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label for="pekerjaan">Pekerjaan</label>
				<input type="text" name="pekerjaan" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan nama pekerjaan" required />
			</div>
	        <div class="form-group">
	            <label for="alamat">Alamat</label>
	            <input class="form-control" type="text" name="alamat" data-toggle="tooltip" data-placement="bottom" title="Masukkan alamat tempat tinggal yang bersangkutan" required >
	        </div>
	        <div class="form-group">
	            <label for="hub_keluarga">Hubungan Keluarga</label>
	                <select name="hub_kel" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Pilih hubungan anda dengan yang bersangkutan." required >
	                    <option value="">-- Pilih --</option>
	                    <?php
	                        $agama = db_read("select * from hub_keluarga where status='Y'");
	                        foreach($agama as $val){
	                            echo "<option value='".$val['id_hub_kel']."'>".$val['nama_hub_kel']."</option>";
	                        }
	                    ?>
	                </select>			
	        </div>
		</div>
	</div>
	<p align="right">
    	<button type="submit" id="simpan_kel" class="btn btn-primary btn-sm">Tambahkan</button>
    	<button type="reset" id="reset_kel" class="btn btn-default btn-sm">Reset</button>
    </p>
    <table class="table table-hovered table-bordered" id="table_keluarga">
    	<tr>
    		<th>Nama</th>
    		<th>No. Telp</th>
    		<th>Email</th>
    		<th>Pekerjaan</th>
    		<th>Hub. Keluarga</th>
    		<th>Aksi</th>
    	</tr>
    	<?php
    		if($_SESSION['logged_as'] == "mahasiswa"){
    			$sql = db_read("select * from vkeluarga where npm='".$_SESSION['username']."'");
    		}else{
    			$sql = db_read("select * from vkeluarga where npm='".$_GET['npm']."'");
    		}
    		foreach ($sql as $key => $value) {
    			echo "<tr>
    					<td>".$value['nama_kel']."</td>
    					<td>".$value['telepon']."</td>
    					<td>".$value['email']."</td>
    					<td>".$value['pekerjaan']."</td>
    					<td>".$value['nama_hub_kel']."</td>
    					<td>
    						<a href='".rules("act_read_klg")."&t=keluarga&id=".$value['id_kel']."' class='edit'>Edit</a>
    						<a href='".rules("act_delete_klg")."&t=keluarga&id=".$value['id_kel']."' class='delete'>Hapus</a>
    					</td>
    				</tr>";
    		}
    	?>
    </table>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

		$("#formKel").submit(function(){
			var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_kel").attr("disabled","disabled");
                    $("#simpan_kel").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_kel").removeAttr("disabled");
                    $("#simpan_kel").html("Tambahkan");
                }
            });

			return false;
		});

		$("#reset_kel").click(function() {
			$("#formKel").attr("action", "<?php echo rules('act_insert_klg'); ?>&t=keluarga");
			$("#simpan_kel").html("Tambahkan");
		});

		$("#table_keluarga").on('click','.edit', function(){
			var url = $(this).attr("href");
			$.get(url, function(data, status){
				var json = $.parseJSON(data);
				$.each(json, function(key,value){
					$("input[name=nama_kel]").val(value['nama_kel']);
					$("input[name=telepon]").val(value['telepon']);
					$("input[name=email]").val(value['email']);
					$("input[name=pekerjaan]").val(value['pekerjaan']);
					$("select[name=hub_kel]").val(value['id_hub_kel']);
					$("input[name=alamat]").val(value['alamat']);
					<?php if(count($sql) > 0) : ?>
						$("input[name=jk_kel]:radio[value=<?php echo $sql[0]['jk']; ?>]").prop("checked",true);
					<?php endif; ?>
				});
			});

			$("#formKel").attr("action",url.replace("read","update"));
			$("#simpan_kel").html("Perbarui");
			return false;
		});

		$("#table_keluarga").on('click','.delete', function(){
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
