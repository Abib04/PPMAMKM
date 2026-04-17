<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>

<?php endif; ?>
<ul class="nav nav-pills">
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : 
    $sql = db_read("SELECT * FROM `vacara` WHERE `method_th`in (1,2,3,4) and id_thn='".get_year(get_active_year())."' order by tanggal_mulai asc");
    $_i = 1;
    foreach($sql as $ky => $val){
    $_cls = ($_i==1)? "active":"";
    ?>
		<li role="presentation" class="<?php echo $_cls;?>"><a href="#<?php echo str_replace(' ','_',$val['nama_acara']); ?>" data-toggle="tab"><?php echo $val['nama_acara']; ?></a></li>
	<?php
    $_i++;
    }
     endif; ?>

	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : ?>
		<li role="presentation"><a href="#oh" data-toggle="tab">Open House</a></li>
		<!-- <li role="presentation"><a href="#pk" data-toggle="tab">PK</a></li>
		<li role="presentation"><a href="#om" data-toggle="tab">OM</a></li> -->
	<?php endif; ?>

</ul>
<hr />
<div class="tab-content">
	<?php if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) : 
    $sql = db_read("SELECT * FROM `vacara` WHERE `method_th`in (1,2,3,4) and id_thn='".get_year(get_active_year())."' order by tanggal_mulai asc");
    $_i = 1;
    foreach($sql as $ky => $val){
    $_cls = ($_i==1)? "active":"";
    ?>
		<div id="<?php echo str_replace(' ','_',$val['nama_acara']); ?>" class="tab-pane fade in <?php echo $_cls;?>">
			<a class="btn btn-warning btn-sm reset" href="<?php echo rules("act_jadwal_reset")."&acara=".$val['id_acara']; ?>">Reset</a>
			<a id="bagi_<?php echo str_replace(' ','_',$val['nama_acara']); ?>" href="<?php echo rules("act_div_jadwal")."&acara=".$val['id_acara']; ?>" class="btn btn-success btn-sm div_room">Bagikan Ruangan</a> 
			<a href="<?= BASE_URL."presensi.php?op=acara&id=".$val['id_acara']; ?>" class="btn btn-primary btn-sm" target="_blank">Cetak Presensi</a>  
			<button type="button" data-target="#absen" data-link="<?= base_url("data.php?module=mod_presensi&op=create&id_acara_thn=".$val['id_acara_thn']); ?>" data-toggle="modal" class="btn btn-primary btn-sm" >Catat Absensi</button>
			<hr>
			<table id="tabel_<?php echo str_replace(' ','_',$val['nama_acara']); ?>" class="table table-bordered table-hovered">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Npm</th>
					<th>Tanggal</th>
					<th>Jam</th>
					<th>Ruang</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Nama</th>
					<th>Npm</th>
					<th>Tanggal</th>
					<th>Jam</th>
					<th>Ruang</th>
				</tr>
			</tfoot>
			</table>
		</div>

		<script type="text/javascript">
		$(document).ready(function(){
		var tb_<?php echo str_replace(' ','_',$val['nama_acara']); ?> = $("#tabel_<?php echo str_replace(' ','_',$val['nama_acara']); ?>").DataTable({
			"ajax":{
				"url" : "<?php echo BASE_URL; ?>data.php?module=mod_div_room_sesi&op=read&acara=<?php echo $val['id_acara'];?>&thn="+<?php echo get_year(get_active_year()) ?>,
				"dataSrc" : ""
			},
			"deferRender": true,
			"columns":[
				{"data":"nama"},
				{"data":"npm"},
				{"data":"tanggal"},
				{"data":"jam_mulai"},
				{"data":"nama_ruang"}
			],
		bAutoWidth: false});



		$("#bagi_<?php echo str_replace(' ','_',$val['nama_acara']); ?>").click(function(){
			$(this).attr("disabled","disabled");
			$(this).html("Sedang Proses...");
			
			$.post($(this).attr("href"), function(data, status){
				if(data == "true"){
					alert("Berhasil Diproses");
					$(this).removeAttr("disabled");
					$(this).html("Bagikan Ruangan");
				}else{
					alert(data);
				}

				location.reload();
				
			});
			return false;
		});
		});
		</script>
	<?php $_i++;
    }
    endif; ?>

	<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
		<div id="oh" class="tab-pane fade in ">
			<?php include "pages/others/peserta_oh.php"; ?>
		</div>
		<!-- <div id="pk" class="tab-pane fade in ">
			<?php //include "pages/others/peserta_pk.php"; ?>
		</div>
		<div id="om" class="tab-pane fade in ">
			<?php //include "pages/others/peserta_om.php"; ?>
		</div> -->
	<?php endif; ?>

</div>
<div class="modal fade" id="absen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	<form method="post" action="" id="form-absen">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Absensi PPM</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
           <lable for="npm">NPM : 
               <input class="form-control" name="npm" id="npm" />
           </lable>
        </div>
		<div class="row">
			<div class="col-md-6">
		<label class="checkbox-inline"><input type="radio" value="0" name="ket"> Alpha </label> 
		<label class="checkbox-inline"><input type="radio" value="1" name="ket"> Izin </label> 
		<label class="checkbox-inline"><input type="radio" value="2" name="ket"> Sakit </label>
			
			</div>
			<div class="col-md-6">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary simpan">Simpan</button>
			
			</div>
		</div>
      </div>
      <div class="modal-footer">
	  <table class="table table-striped table-absen" >
		  <thead>
			  <tr>
				  <th>NPM</th>
				  <th>Acara</th>
				  <th>Keterangan</th>
				  <th>Aksi</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
				$ket = array('Alpha','Ijin','Sakit');
				$absen = db_read("SELECT * FROM `vabsensi`");
				foreach ($absen as $key => $value) {?>
			  <tr>
				  <td><?= $value['npm']?></td>
				  <td><?= $value['acara']?></td>
				  <td><?= $ket[$value['keterangan']]?></td>
				  <td><a href="#" class="btn btn-sm btn-info">Batal</a></td>
			  </tr>
				<?php } ?>
		  </tbody>
	  </table>
      </div>
</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.table-absen').DataTable({bAutoWidth: false});
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  e.target // newly activated tab
		  e.relatedTarget // previous active tab
		})

		$('#absen').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget); 
		  var link = button.data('link'); 
		  $("#form-absen").attr('action',link);
		})

		$(".reset").click(function(){
			$(this).attr("disabled","disabled");
			$(this).html("Sedang Proses...");
			
			let text = "Apakah anda yakin mereset data!\n Pilih OK or Cancel.";
            if (confirm(text) == true) {
			
    			$.post($(this).attr("href"), function(data, status){
    				if(data == "true"){
    					alert("Berhasil Direset");
    					$(this).removeAttr("disabled");
    					$(this).html("Reset");
    				}else{
    					alert(data);
    				}
    
    				location.reload();
    				
    			});
            }else{
                $(this).removeAttr("disabled");
    			$(this).html("Reset");
            }
			return false;
		});

		$("#form-absen").submit(function(){
		  var target = $(this).attr('action');
		  var method = $(this).attr('method');
		  var data = $(this).serialize();
		  $.ajax({
				data : data,
				url : target,
				type : method,
				beforeSent : function(){
					$('.simpan').attr("disabled","disabled");
				}
			}).done(function(response){
				$('.simpan').removeAttr("disabled");
				alert(response);
			});
		  return false;
		});
	});

</script>
