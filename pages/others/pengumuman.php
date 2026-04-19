<div>
<div id="easyPaginate"> <?php
$query = "SELECT * FROM pengumuman";
$faqs = db_read($query);
foreach($faqs as $key => $value){?>
    <div class="bs-callout bs-callout-info ">
      <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;"><?=$value['judul']?>
<?php 
if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
?>
<a href="<?= rules('act_del_pengumuman')."&id=".$value['id'] ?>" type="button" class="close delete" aria-hidden="true">&times;</a>
<?php } ?>
</h4>
<p style="font-size: 14px; line-height: 1.6; letter-spacing: -0.2px; white-space: pre-wrap; margin-bottom: 15px;"><?= str_replace('+62 851-3335-9681', '<span style="white-space: nowrap;">+62 851-3335-9681</span>', $value['isi']) ?></p>
</div>
<?php } ?>
</div>
</div>
<script src="resource/assets/js/jquery.easyPaginate.js"></script>
<script>
$(document).ready(function(){
$('#easyPaginate').easyPaginate({
    paginateElement: 'div',
    elementsPerPage: 6,
    effect: 'slide'
});
});
</script>
<?php 
if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
?>
<hr />
<form method="post" action="<?= rules('act_add_pengumuman') ?>" id="pengumuman">
<div class="form-group">
<lable for="judul">Judul : </lable>
<input type="text" name="judul" id="judul" class="form-control" />
</div>
<div class="form-group">
<lable for="isi">Isi : </lable>
<textarea name="isi" id="isi" class="form-control" ></textarea>
</div>
<button class="btn btn-mini btn-info tambah" type="submit">Terbitkan</button>
</form>

<?php 
} 
if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
?>
<script>
$(document).ready(function(){
   $(".delete").click(function(e){
      var url = $(this).attr('href');
      $.get(url, function(data, status){
          if(data == "true"){
               alert("Berhasil dihapus.");
               location.reload();
          }else{
               alert(data);
          }
       });
       return false;
   });
   $("#pengumuman").submit(function(){
      var url = $(this).attr('action');
      var data = $(this).serialize();
      var method = $(this).attr('method');
      $.ajax({
		type: method,
		data: data,
		url: url,
		beforeSend: function(){
		   $(".tambah").attr("disabled","disabled");
		}
	}).done(function(response){
		if(response == "true"){
		   $(".tambah").removeAttr("disabled");
		   alert(response);
		   location.reload();
		}else{
		   $(".tambah").removeAttr("disabled");
		   alert(response);
		}
	});
      return false;
   });
});
</script>
<?php } ?>
