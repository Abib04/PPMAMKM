<form id="cert" method="get" action="<?= base_url('media.php?page=cek_cert'); ?>" >
   <div class="form-group">
      <lable for="no">
	No. Sertifikat :
      
      <input type="hidden" name="page" value="cek_cert" />
      <div class="row">
      <div class="col-xs-8">
	      <input type="text" id="no" name="no" class="form-control" />
      </div>
      <div class="col-xs-2">
            <button type="submit" class="btn btn-success">Cek Validasi</button>
      </div>
      </div>
      </lable>
   </div>
</form> 
<div class="row">
<div class="col-xs-12">
<?php 
if(isset($_GET['no'])){
      $no = htmlspecialchars(cleanchar($_GET['no']));
      $data = db_read("SELECT * from vsertifikat where no_cert='".$no."' OR no='".$no."'");
      if(count($data) < 1){ ?>

<div class="alert alert-danger" role="alert">Sertifikat <?= $no ?> tidak valid!</div>
<?php } else {?>
<div class="alert alert-success" role="alert">
Serttifikat Anda Valid!<br />
Atas nama : <?= $data[0]['nama'] ?><br />
Sebagai : <?= $data[0]['posisi'] ?> <br />
Nomor Sertifikat : <?= $data[0]['no'] ?> <br />
Terbit pada : <?= $data[0]['tanggal_terbit'] ?><br />
</div>
<?php } } ?>
</div>
</div>
