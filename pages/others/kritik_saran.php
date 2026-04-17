<form action="<?php echo base_url('data.php?module=mod_ks&op=create'); ?>" method="post" name="kritik_pesan">
	<div class="form-group">
		<label for="nama">Nama</label>
		<input class="form-control" name="nama" type="text" required />
	</div>
	<div class="form-group">
		<label for="email">E-mail</label>
		<input class="form-control" name="email" type="email" required />
	</div>
	<div class="form-group">
		<label for="pesan">Kritik dan Pesan</label>
		<textarea name="pesan" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<label for="captcha">Hitunglah <span class="captcha"><?php echo captcha(); ?></span></label>
		<!--<img src="captcha.php" width="80" />-->
		<div class="row">
			<div class="col-xs-2">
				<input type="number" name="captcha" class="form-control" size="12" />
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary btn-sm" id="simpan_ks">Kirim</button>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$("form[name=kritik_pesan]").submit(function(){
			var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
            	type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_ks").attr("disabled","disabled");
                    $("#simpan_ks").html("Menunggu...");
                }
            }).done(function(response){
            	alert("Berhasil disimpan");
                $("#simpan_ks").removeAttr("disabled");
                $("#simpan_ks").html("Simpan");
            });

			return false;
		});
	});
</script>
