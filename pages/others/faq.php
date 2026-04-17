

<div>
<div id="easyPaginate"> <?php
$query = "SELECT * FROM faq";
$faqs = db_read($query);
foreach($faqs as $key => $value){?>
    <div class="bs-callout bs-callout-info ">
      <h4><?=$value['pertanyaan']?>
<?php 
if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
?>
<a href="<?= rules('act_del_faq')."&id=".$value['id'] ?>" type="button" class="close delete" aria-hidden="true">&times;</a>
<?php } ?>
</h4>
<p><?=$value['jawaban']?></p>
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
<form method="post" action="<?= rules('act_add_faq') ?>" id="faq">
<div class="form-group">
<lable for="pertanyaan">Pertanyaan : </lable>
<input type="text" name="pertanyaan" id="pertanyaan" class="form-control" />
</div>
<div class="form-group">
<lable for="jawaban">Jawaban : </lable>
<textarea name="jawaban" id="jawaban" class="form-control" ></textarea>
</div>
<button class="btn btn-mini btn-info tambah" type="submit">Tambah</button>
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
   $("#faq").submit(function(){
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
