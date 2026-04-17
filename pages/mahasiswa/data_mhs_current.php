<?php
$sql = db_read("select * from mahasiswa where npm='".$_SESSION['username']."'");
if(get_id_active_year() == $sql[0]['id_thn']){
	echo (isset($_SESSION['no_edit']) and $_SESSION['no_edit'])? '' : '<form action="'.rules("act_update_mhs").'&id='.$_SESSION['username'].'" method="post" id="formMhs" class="form-group-sm">';
} ?>


	<div class="row">

	    <div class="col-xs-6">

	        <div class="form-group">

	            <label for="npm">NPM</label>

	            <input type="text" class="form-control" name="npm" value="<?php echo $sql[0]['npm']; ?>" disabled="disabled" required />

	        </div>

	        <div class="form-group">

	            <label for="nama">Nama Lengkap</label>

	            <input type="text" class="form-control" name="nama" value="<?php echo $sql[0]['nama']; ?>" data-toggle="tooltip" data-placement="bottom" title="Masukkan Nama Lengkap." required />

	        </div>

	        <div class="form-group" style="margin-bottom:33px">

	            <label>Jenis Kelamin : </label><br />

	            <label class="radio-inline">

	              <input type="radio" name="jk" value="laki-laki"> Laki-Laki

	            </label>

	            <label class="radio-inline">

	              <input type="radio" name="jk" value="perempuan"> Perempuan

	            </label>

	        </div>

	        <div class="form-group">

                <label>Tempat/Tgl Lahir</label>

                <div class="row">

                    <div class="col-xs-5">

                        <input type="text" name="tempat_lahir" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan Tempat Kelahiran." value="<?php echo $sql[0]['tempat_lahir']; ?>" required />  

                    </div>

                    <div class="col-xs-7">

                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">

                            <input type="text" class="form-control" name="tgl_lahir" data-toggle="tooltip" data-placement="bottom" title="Masukkan Tanggal Lahir" value="<?php echo $sql[0]['tgl_lahir']; ?>" required>

                            <div class="input-group-addon">

                                <span class="glyphicon glyphicon-th"></span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

	        <div class="form-group">

	            <label for="agama">Agama</label>

	                <select name="agama" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Pilih sesuai dengan agama anda." required>

	                    <option value="">-- Pilih --</option>

	                    <?php

	                        $agama = db_read("select * from agama where status='Y'");

	                        foreach($agama as $val){

	                            echo "<option value='".$val['id_agama']."'>".$val['nama_agama']."</option>";

	                        }

	                    ?>

	                </select>			

	        </div>

	        <div class="form-group">

	            <label for="alamat_asal">Alamat Asal</label>

	            <textarea class="form-control" row="3" name="alamat_asal" data-toggle="tooltip" data-placement="bottom" title="Masukkan Alamat asal sesuai dengan KTP." required></textarea>

	        </div>

	        <div class="form-group">

	            <label for="negara">Kewarganegaraan</label>

	            <select name="negara" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Pilih kewarganegaraan." required>

	            	<option value="">-- Pilih --</option>

	                    <?php

	                        $negara = db_read("select * from negara where status='Y'");

	                        foreach($negara as $val){

	                            echo "<option value='".$val['id_negara']."'>".$val['nama_negara']."</option>";

	                        }

	                    ?>

	            </select>

	        </div>

	    </div>

	    <div class="col-xs-6">

	        <div class="form-group">

	            <label for="daerah">Asal Daerah</label>

	            <select name="daerah" class="form-control" title="Pilih daerah sesuai dengan KTP anda." data-toggle="tooltip" data-placement="bottom" >

	            <option value="">-- Pilih --</option>

	                    <?php

	                        $daerah = db_read("select * from daerah where status='Y'");

	                        foreach($daerah as $val){

	                            echo "<option value='".$val['id_daerah']."'>".$val['nama_daerah']."</option>";

	                        }

	                    ?>

	            </select>

	        </div>

	        <div class="form-group">

                    <label for="kabupaten">Kabupaten</label>

                    <select name="kabupaten" class="form-control" title="Pilih kabupaten sesuai dengan KTP anda." data-toggle="tooltip" data-placement="bottom">

                    	<option value=''>-- Pilih --</option>

                    	<?php

	                        $kab = db_read("select * from kabupaten where status='Y' and id_daerah='".$sql[0]['id_daerah']."'");

	                        foreach($kab as $val){

	                            echo "<option value='".$val['id_kab']."'>".$val['nama_kab']."</option>";

	                        }

	                    ?>

                    </select>

                </div>

	        <div class="form-group">

	            <label for="kode_pos">Kode Pos</label>

	            <input type="text" class="form-control" name="kode_pos" maxlength="5" value="<?php echo $sql[0]['kode_pos']; ?>" data-toggle="tooltip" data-placement="bottom" title="Masukkan Kode Pos sesuai dengan tempat tinggal di KTP." required />

	        </div>

	        <div class="form-group">

	            <label for="slta_asal">Asal SLTA</label>

	            <input type="text" class="form-control" name="slta_asal" value="<?php echo $sql[0]['slta_asal']; ?>" data-toggle="tooltip" data-placement="bottom" title="Masukkan asal SLTA anda." required />

	        </div>

	        <div class="form-group">

	            <label for="hp">No. Telepon</label>

	            <input type="text" class="form-control" name="hp" value="<?php echo $sql[0]['hp']; ?>" data-toggle="tooltip" data-placement="bottom" title="Masukkan No. Telp. yang bisa dihubungi" maxlength="12" required />

	        </div>

	        <div class="form-group" style="margin-top: 17px;">

	            <label for="email">E-mail</label>

	            <input type="text" class="form-control" name="email" value="<?php echo $sql[0]['email']; ?>" data-toggle="tooltip" data-placement="bottom" title="Masukkan E-mail aktif." required />

	        </div>

	        <div class="form-group">

	            <label for="alamat_yk">Alamat di Yogyakarta</label>

	            <textarea class="form-control" row="3" name="alamat_yk" data-toggle="tooltip" data-placement="bottom" title="Masukkan Alamat anda di Yogyakarta" required></textarea>

	        </div>

	        <p align="right">
				<?php if(get_year(get_active_year()) == $sql[0]['id_thn']){ ?>
	        		<button type="submit" id="simpan_mhs" class="btn btn-primary btn-sm">Simpan</button>
				<?php } ?>
	        </p>

	    </div>

	</div>
	<?php if(get_year(get_active_year()) == $sql[0]['id_thn']){ 
		echo (isset($_SESSION['no_edit']) and $_SESSION['no_edit'])? '' : '</form>';
	 } ?>


<script type="text/javascript">

	$(document).ready(function(){

		$('[data-toggle="tooltip"]').tooltip();



		if("<?php echo $sql[0]['jk']; ?>" == "laki-laki"){

			$("input:radio[value=laki-laki]").prop("checked",true);

		}else{

			$("input:radio[value=perempuan]").prop("checked",true);

		}

		$("select[name=agama]").val("<?php echo $sql[0]['id_agama']; ?>");

		$("select[name=negara]").val("<?php echo $sql[0]['id_negara']; ?>");

		$("select[name=daerah]").val("<?php echo $sql[0]['id_daerah']; ?>");

		$("select[name=kabupaten]").val("<?php echo $sql[0]['id_kab']; ?>");

		$("textarea[name=alamat_asal]").val("<?php echo $sql[0]['alamat_asal']; ?>");

		$("textarea[name=alamat_yk]").val("<?php echo $sql[0]['alamat_yk']; ?>");



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



        $("#formMhs").submit(function(){

            var method = $(this).attr("method");

            var data = $(this).serialize();

            var target = $(this).attr("action");



            $.ajax({

                type: method,

                url: target,

                data: data,

                beforeSend: function(){

                    $("#simpan_mhs").attr("disabled","disabled");

                    $("#simpan_mhs").html("Menunggu...");

                }

            }).done(function(response){

                if(response == "true"){

                    alert("Berhasil disimpan");

                    $("#simpan_mhs").removeAttr("disabled");

                    $("#simpan_mhs").html("Simpan");

                }else{

                    alert(response);

                    $("#simpan_mhs").removeAttr("disabled");

                    $("#simpan_mhs").html("Simpan");

                }

            });



            return false;

        });

	});

</script>
