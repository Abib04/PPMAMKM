<form action="<?php echo rules('act_insert_sesi'); ?>&t=sesi" method='post' class="form-group-sm" id="formSesi">
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">
				<label for="nama_sesi">Nama Sesi</label>
				<input type="text" name="nama_sesi" class="form-control" />
			</div>
			<div class="form-group">
				<label for="jam_mulai">Jam Mulai</label>
				<div class="input-group bootstrap-timepicker timepicker">
					<input id="jam_mulai" class="form-control" data-template="modal" data-minute-step="1" data-modal-backdrop="true" type="text" name="jam_mulai" />
				</div>
			</div>
			<div class="form-group">
				<label for="jam_akhir">Jam Selesai</label>
				<div class="input-group bootstrap-timepicker timepicker">
					<input id="jam_akhir" class="form-control" data-template="modal" data-minute-step="1" data-modal-backdrop="true" type="text" name="jam_akhir" />
				</div>
			</div>
			<div class="form-group">
				<label for="acara">Acara</label>
				<select name="acara" class="form-control">
					<option value="">-- Pilih --</option>
					<?php
						$sql = db_read("select id_acara_thn, nama_acara from vacara where id_thn=".get_year(get_active_year()));
						foreach ($sql as $key => $value) {
							echo "<option value='".$value['id_acara_thn']."'>".$value['nama_acara']."</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for='tanggal'>Tanggal</label>
				<select name="tanggal" class="form-control" disabled></select>
			</div>
		</div>
	</div>
	<p>
    	<button type="submit" id="simpan_sesi" class="btn btn-primary btn-sm">Tambahkan</button>
    	<button type="reset" id="reset_sesi" class="btn btn-default btn-sm">Batal</button>
    </p>
</form>
<!-- <hr />
<div class="form-group form-inline form-group-sm">
	<label for="cetak_sesi">Cetak Sesi : </label>
	<select name="cetak_sesi" class="form-control">
		<option value="">-- Pilih --</option>
		<?php
			// $sql = db_read("select id_acara, nama_acara from acara");
			// foreach ($sql as $key => $value) {
			// 	echo "<option value='".$value['id_acara']."'>".$value['nama_acara']."</option>";
			// }
		?>
	</select>
</div> -->
<hr />
<table class="table table-bordered" id="table_sesi">
	<thead>
		<tr>
			<th>Nama Sesi</th>
			<th>Nama Acara</th>
			<th>Jam Mulai</th>
			<th>Jam Selesai</th>
			<th>Tanggal</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql = db_read("SELECT * FROM `vsesi` WHERE `id_thn`='".get_year(get_active_year())."' order by tanggal ASC");
			foreach ($sql as $key => $value) {
				echo "<tr>
						<td>".$value['nama_sesi']."</td>
						<td>".$value['nama_acara']."</td>
						<td>".$value['jam_mulai']."</td>
						<td>".$value['jam_akhir']."</td>
						<td>".$value['tanggal']."</td>
						<td>
						<a href='".rules("act_read_sesi")."&t=sesi&id=".$value['id_sesi']."' class='edit'>Edit</a>
    						<a href='".rules("act_delete_sesi")."&t=sesi&id=".$value['id_sesi']."' class='delete'>Hapus</a>
						</td>
					</tr>";
			}
		?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$("#table_sesi").DataTable();
	    $('#jam_mulai, #jam_akhir').timepicker({
            minuteStep: 1,
            template: 'modal',
            appendWidgetTo: 'body',
            showSeconds: true,
            showMeridian: false,
            defaultTime: false
        });

        $("select[name=acara]").change(function(){
        	$.get("<?php echo rules('act_read_acara_thn'); ?>&id="+$(this).val(), function(data, status){
        		var json = $.parseJSON(data);
        		var res = "<option value=''>-- Pilih --</option>";
        		$.each(json, function(key, value){
        			var dates = getDates(new Date(value['tanggal_mulai']), new Date(value['tanggal_selesai']));
        			for(var i = 0; i < dates.length; i++){
        				var tanggal = formatDate(dates[i]);
						res += "<option value='"+tanggal+"'>"+tanggal+"</option>";	  	
					}
        		});
	        	$("select[name=tanggal]").html(res);
	        	$("select[name=tanggal]").removeAttr("disabled");
        	});
        });

        $("#formSesi").submit(function(){
			var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_sesi").attr("disabled","disabled");
                    $("#simpan_sesi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_sesi").removeAttr("disabled");
                    $("#simpan_sesi").html("Tambahkan");
                }
            });

			return false;
		});

		$("#reset_sesi").click(function(){
			$("#formSesi").attr("action","<?php echo rules('act_insert_sesi'); ?>&t=sesi");
			$("#simpan_sesi").html("Tambahkan");
			$("select[name=tanggal]").html("");
			$("select[name=tanggal]").attr("disabled","disabled");
		});

		$("#table_sesi").on('click','.edit', function(){
			var url = $(this).attr("href");
			$.get(url, function(data, status){
				var json = $.parseJSON(data);
				$.each(json, function(key,value){
					$("input[name=nama_sesi]").val(value['nama_sesi']);
					$("input[name=jam_mulai]").val(value['jam_mulai']);
					$("input[name=jam_akhir]").val(value['jam_akhir']);
					$("select[name=acara]").val(value['id_acara_thn']);
					$.get("<?php echo rules('act_read_acara_thn'); ?>&id="+value['id_acara_thn'], function(data, status){
		        		var json = $.parseJSON(data);
		        		var res = "<option value=''>-- Pilih --</option>";
		        		$.each(json, function(key, value){
		        			var dates = getDates(new Date(value['tanggal_mulai']), new Date(value['tanggal_selesai']));
		        			for(var i = 0; i < dates.length; i++){
		        				var tanggal = formatDate(dates[i]);
								res += "<option value='"+tanggal+"'>"+tanggal+"</option>";	  	
							}
		        		});
			        	$("select[name=tanggal]").html(res);
			        	$("select[name=tanggal]").removeAttr("disabled");
		        	});
				});
			});

			$("#formSesi").attr("action",url.replace("read","update"));
			$("#simpan_sesi").html("Perbarui");
			return false;
		});

		$("#table_sesi").on('click','.delete', function(){
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
