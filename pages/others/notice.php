<div class="tab-content" style="margin-top: 10px;">
	<div id="notice" class="tab-pane active">
		<form action='<?php echo rules("notice"); ?>&id=<?php echo $_GET['id']; ?>' method="post" class="form-group-sm" enctype="multipart/form-data">
		    <?php
    		    $id=$_GET['id'];
    		    $sql="select * from pengumuman where id=".$id;
    		    $query = mysqli_query($sql);
    		    $data = mysqli_fetch_array($query);
    		    echo "<h2>".$data['id']."</h2>";
    		    echo "<h2>".$data['judul']."</h2>";
		    ?>
		</form>
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
