<div>
<div id="easyPaginate"> <?php
$query = "SELECT * FROM temporary_storage";
$faqs = db_read($query);
foreach($faqs as $key => $value){?>
    <div class="bs-callout bs-callout-info ">
      <h4><?=$value['judul']?>
<a href="<?= rules('act_del_temporary_storage')."&id=".$value['id'] ?>" type="button" class="close delete" aria-hidden="true">&times;</a>
<?php } ?>
</h4>
<p><?=$value['isi']?></p>
</div>
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
<hr />
<form method="post" action="<?= rules('act_add_temporary_storage') ?>" id="pengumuman">
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
