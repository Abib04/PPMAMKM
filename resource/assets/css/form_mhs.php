<?php
	if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"){
		$sql = db_read("select * from mahasiswa where npm='".$_SESSION['username']."'");
	}elseif($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
		$sql = db_read("select * from mahasiswa where npm='".$_GET['npm']."'");
	}
?>

<script>

	function showImg(){

		var filesSelected = document.getElementById("img_mhs").files;
		if(filesSelected.length > 0){
			var fileToLoad = filesSelected[0];
			var fileReader = new FileReader();
			fileReader.onload = function(fileLoadedEvent)
			{
				var textAreaFileContents = document.getElementById("img_preview");

				textAreaFileContents.src = fileLoadedEvent.target.result;
			};

			fileReader.readAsDataURL(fileToLoad);
		}

		$(".thumbnail").show();
	}
</script>
<div class="row">
	<div class="col-xs-8" style="border-right: 1px solid #ddd; border-top: 1px solid #ddd; padding-top: 10px;">
		<div class="form-group">
			<label for="nama">Nama Anda <i class="required">*</i></label>
			<input type="text" name="nama" class="form-control" value="<?php echo (isset($sql[0]['nama'])) ? $sql[0]['nama'] : ""; ?>" required />
		</div>
		<?php if($_SESSION['login'] != 1) : ?>
			<div class="form-group">
				<label for="npm">NPM <i class="required">*</i></label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" name="npm" class="form-control" required />
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="form-group">
	        <label>Tempat/Tgl Lahir <i class="required">*</i></label>
	        <div class="row">
	            <div class="col-xs-4">
	                <input type="text" name="tempat_lahir" class="form-control" value="<?php echo (isset($sql[0]['tempat_lahir'])) ? $sql[0]['tempat_lahir'] : ""; ?>" required />
	            </div>
	            <div class="col-xs-5">
	                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
	                    <input type="text" class="form-control" name="tgl_lahir" value="<?php echo (isset($sql[0]['tgl_lahir'])) ? $sql[0]['tgl_lahir'] : ""; ?>" required>
	                    <div class="input-group-addon">
	                        <span class="glyphicon glyphicon-th"></span>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="form-group" style="margin-bottom:33px">
	        <label>Jenis Kelamin :  <i class="required">*</i></label><br />
	        <label class="radio-inline">
	          <input type="radio" name="jk_mhs" value="laki-laki"> Laki-Laki
	        </label>
	        <label class="radio-inline">
	          <input type="radio" name="jk_mhs" value="perempuan"> Perempuan
	        </label>
	    </div>
	    <div class="form-group">
		    <label for="agama">Agama <i class="required">*</i></label>
		        <select name="agama" class="form-control" required>
		            <option value="">-- Pilih --</option>
		            <?php
		                $agama = db_read("select * from agama where status='Y'");
		                foreach($agama as $val){
		                    echo "<option value='".$val['id_agama']."'>".$val['nama_agama']."</option>";
		                }
		            ?>
		        </select>
		</div>
		<!-- <div class="form-group">
			<label for="negara">Kewarganegaraan <i class="required">*</i></label>
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">WNI <span class="caret"></span></button>
			        <ul class="dropdown-menu">
			          <li><a href="#">WNI</a></li>
			          <li><a href="#">WNA</a></li>
			        </ul>
				</div>
				<input type="text" name="negara" class="form-control" aria-label="..." />
			</div>
		</div> -->
		<div class="form-group">
                <label for="negara">Kewarganegaraan <i class="required">*</i></label>
                <select name="negara" class="form-control" required>
                <option value="">-- Pilih --</option>
                        <?php
                            $negara = db_read("select * from negara where status='Y'");
                            foreach($negara as $val){
                                echo "<option value='".$val['id_negara']."'>".$val['nama_negara']."</option>";
                            }
                        ?>
                </select>
            </div>
		<div class="form-group">
            <label for="alamat_asal">Alamat Asal <i class="required">*</i></label>
            <textarea class="form-control" row="3" name="alamat_asal" required><?php echo (isset($sql[0]['alamat_asal'])) ? $sql[0]['alamat_asal'] : ""; ?></textarea>
        </div>
        <div class="form-group">
        	<label>RW / RT</label>
        	<div class="row">
        		<div class="col-xs-3">
        			<input type="number" name="rw" min="0" class="form-control" value="<?php echo (isset($sql[0]['rw'])) ? $sql[0]['rw'] : ""; ?>" />
        		</div>
        		<div class="col-xs-3">
        			<input type="number" name="rt" min="0" class="form-control" value="<?php echo (isset($sql[0]['rt'])) ? $sql[0]['rt'] : ""; ?>" />
        		</div>
        	</div>
        </div>
        <div class="form-group">
            <label for="daerah">Provinsi <i class="required">*</i></label>
            <select name="daerah" class="form-control" required>
            <option value="">-- Pilih --</option>
                    <?php
                        $daerah = db_read("select * from daerah where status='Y' order by nama_daerah asc");
                        foreach($daerah as $val){
                            echo "<option value='".$val['id_daerah']."'>".$val['nama_daerah']."</option>";
                        }
                    ?>
            </select>
        </div>
        <div class="form-group">
            <label for="kabupaten">Kabupaten <i class="required">*</i></label>
            <select name="kabupaten" class="form-control" disabled>
            	<?php
            		if($_SESSION['login'] == 1){
						echo "<option value=''>-- Pilih --</option>";
						$kab = db_read("select * from kabupaten where status='Y' and id_daerah='".$sql[0]['id_daerah']."'");
                        foreach($kab as $val){
                            echo "<option value='".$val['id_kab']."'>".$val['nama_kab']."</option>";
                        }
            		}
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="kecamatan">Kecamatan <i class="required">*</i></label>
            <input type="text" name="kecamatan" class="form-control" value="<?php echo (isset($sql[0]['kecamatan'])) ? $sql[0]['kecamatan'] : ""; ?>" disabled />
        </div>
        <div class="form-group">
            <div class="row">
            	<div class="col-xs-3">
            		<label for="kode_pos">Kode Pos</label>
            		<input type="text" class="form-control" name="kode_pos" value="<?php echo (isset($sql[0]['kode_pos'])) ? $sql[0]['kode_pos'] : ""; ?>" maxlength="5" />
            	</div>
            </div>
        </div>
        <div class="form-group">
            <label for="alamat_yk">Alamat di Yogyakarta</label>
            <textarea class="form-control" row="3" name="alamat_yk"><?php echo (isset($sql[0]['alamat_yk'])) ? $sql[0]['alamat_yk'] : ""; ?></textarea>
        </div>
        <div class="form-group" style="margin-top: 20px">
            <label for="slta_asal">Asal SLTA <i class="required">*</i></label>
            <input type="text" class="form-control" name="slta_asal" value="<?php echo (isset($sql[0]['slta_asal'])) ? $sql[0]['slta_asal'] : ""; ?>" required />
        </div>
        <div class="form-group">
            <label for="hp">No. Telepon <i class="required">*</i></label>
            <input type="tel" class="form-control" name="hp" maxlength="12" value="<?php echo (isset($sql[0]['hp'])) ? $sql[0]['hp'] : ""; ?>" required />
        </div>
        <div class="form-group">
            <label for="email">E-mail <i class="required">*</i></label>
            <input type="text" class="form-control" name="email" value="<?php echo (isset($sql[0]['email'])) ? $sql[0]['email'] : ""; ?>" required />
        </div>
	</div>
	<div class="col-xs-4" style="border-top: 1px solid #ddd; padding-top: 10px;">
		<?php
			if($_SESSION['login'] == 1):
				$img = isset($_GET['npm']) ? $_GET['npm'] : $_SESSION['username'];
		?>

				<div class="thumbnail">
					<img src="<?php echo base_url("resource/mahasiswa/foto_mhs/".$img.".jpg"); ?>">
				</div>
				<?php else: ?>
					<div class="thumbnail">
						<img id="img_preview">
					</div>
		<?php endif;?>
		<div class="form-group" style="text-align: center;">
			<label for="img_mhs" class="btn btn-default btn-sm">Pilih Foto...</label>
			<input type="file" name="img_mhs" onchange="return showImg();" id="img_mhs" style="display: none;" <?php echo ($_SESSION['login'] != 1) ? "required" : ""; ?> />
		</div>
		<p>
			<b>Syarat Foto:</b>
			<ul style="margin:0; padding:0;">
				<li>Berpakaian Sopan dan Rapi</li>
				<li>Posisi badan tegap dan menghadap ke depan.</li>
				<li>Ukuran foto 3x4.</li>
				<li>Maksimal besar foto 100kb.</li>
				<li>Ekstensi foto jpg.</li>
			</ul>
		</p>
	</div>
	<div class="col-xs-12" style="border-top: 1px solid #ddd; padding-top: 10px;">
		<div class="row">
			<div class="col-xs-5" style="text-align: right; padding-top: 10px; font-weight: bold;">Berapa <?php echo captcha(); ?> ?</div>
			<div class="col-xs-2">
				<input type="number" class="form-control" name="captcha" required />
			</div>
			<div class="col-xs-5" style="text-align: right;">
				<button class="btn btn-primary btn-sm" id="reg_ppm" type="submit">Daftar Sekarang &raquo;</button>
			</div>
		</div>
	</div>
	<div class="col-xs-6">*) Wajib diisi!</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    	$("select[name=negara]").val('101');

		<?php if($_SESSION['login'] != 1) : ?>
		$(".thumbnail").hide();
		<?php endif;?>

        // $("select[name=kabupaten]").html("<option value=''>-- Pilih --</option>");

        $("select[name=negara]").change(function(){
            if($("select[name=negara]").val() == "101"){
                $("select[name=daerah]").removeAttr("disabled");
                $("select[name=daerah]").attr("title","Pilih Daerah anda.");
            }else{
                $("select[name=daerah]").attr("disabled","disabled");
                $("select[name=daerah]").attr("title","Silahkan pilih kewarganegaraan terlebih dahulu.");
            }
        });

        $("select[name=daerah]").change(function(){
            $.get("<?php echo rules('get_kabupaten'); ?>"+"&daerah="+$(this).val(), function(data, status){
                var json = $.parseJSON(data);
                var res = "<option value=''>-- Pilih --</option>";

                $.each(json, function(key,value){
                    res += "<option value='" + value['id_kab'] + "'>" + value['nama_kab'] + "</option>";
                })

                $("select[name=kabupaten]").html(res);
                $("select[name=kabupaten]").removeAttr("disabled");
            });
        });

        $("select[name=kabupaten]").change(function(){
        	$("input[name=kecamatan]").removeAttr("disabled");
        });

        <?php if($_SESSION['login'] == 1) : ?>
        	$("input[name=kecamatan]").removeAttr("disabled");
        	$("select[name=kabupaten]").removeAttr("disabled");
			$("input[name=jk_mhs]:radio[value=<?php echo $sql[0]['jk']; ?>]").prop("checked",true);
			$("select[name=agama]").val("<?php echo $sql[0]['id_agama']; ?>");
			$("select[name=negara]").val("<?php echo $sql[0]['id_negara']; ?>");
			$("select[name=daerah]").val("<?php echo $sql[0]['id_daerah']; ?>");
			$("select[name=kabupaten]").val("<?php echo $sql[0]['id_kab']; ?>");
			$("#reg_ppm").html("Simpan");
        <?php endif; ?>

		<?php if($_SESSION['login'] == 0) : ?>
			$("#reg_ppm").click(function(){
				var form_val = $("#formMhs").serialize();
				var val_split = form_val.split("&");
				$.each(val_split, function(key, value){
					var res = value.split("=");
					setCookie(res[0],res[1],1);
				});
				console.log(getCookie("kecamatan"));
			});
		<?php endif; ?>

        <?php if($_SESSION['login'] == 0) : ?>
            window.addEventListener("load", function(){
				$("input[name=kecamatan]").removeAttr("disabled");
				$("select[name=kabupaten]").removeAttr("disabled");

				$("input[name=kecamatan]").attr("required","required");
				$("select[name=kabupaten]").attr("required","required");
                if(getCookie("nama") != ""){
					$.get("<?php echo rules('get_kabupaten'); ?>"+"&daerah="+getCookie("daerah"), function(data, status){
						var json = $.parseJSON(data);
						var res = "<option value=''>-- Pilih --</option>";

						$.each(json, function(key,value){
							res += "<option value='" + value['id_kab'] + "'>" + value['nama_kab'] + "</option>";
						})

						$("select[name=kabupaten]").html(res);
						$("select[name=kabupaten]").removeAttr("disabled");
					});


                    $("input[name=nama]").val(getCookie("nama").split("+").join(" "));
                    $("input[name=npm]").val(getCookie("npm"));
                    $("input[name=tempat_lahir]").val(getCookie("tempat_lahir").split("+").join(" "));
                    $("input[name=tgl_lahir]").val(getCookie("tgl_lahir"));
                    $("input[name=jk_mhs]:radio[value="+getCookie("jk_mhs")+"]").prop("checked",true);
                    $("select[name=agama]").val(getCookie("agama"));
                    $("select[name=negara]").val(getCookie("negara"));
                    $("select[name=daerah]").val(getCookie("daerah"));
                    $("select[name=kabupaten]").val(getCookie("kabupaten"));
                    $("input[name=kecamatan]").val(getCookie("kecamatan").split("+").join(" "));
                    $("textarea[name=alamat_asal]").val(getCookie("alamat_asal").split("+").join(" "));
                    $("textarea[name=alamat_yk]").val(getCookie("alamat_yk").split("+").join(" "));
                    $("input[name=rt]").val(getCookie("rt"));
                    $("input[name=rw]").val(getCookie("rw"));
                    $("input[name=kode_pos]").val(getCookie("kode_pos"));
                    $("input[name=slta_asal]").val(getCookie("slta_asal").split("+").join(" "));
                    $("input[name=hp]").val(getCookie("hp"));
                    $("input[name=email]").val(decodeURIComponent(getCookie("email")));
                }

//                if(getCookie(""))
            }, false);
        <?php endif; ?>
    });
</script>
