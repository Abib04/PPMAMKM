<?php 
	require_once("koneksi.php");
	$sql = mysqli_query($db, "SELECT * FROM acara");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mini Presensi</title>
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<link rel="stylesheet" type="text/css" href="css/bulma.min.css">
	<link rel="stylesheet" type="text/css" href="css/style3.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div class="container"  style="margin-top: 40px;margin-bottom: 40px;">
		<form>
			<div class="field">
				<p class="control has-icons-left">
					<input class="input is-large search is-focused" placeholder="Search Kelompok" name="search" type="text"></input>
					<span class="icon is-large is-left">
						<i class="fas fa-search"></i>
					</span>
				</p>
			</div>
		</form>

		<div id="kelompok" class="panel">
			
		</div>

		<div class="columns">
			<div class="column">
				<form method="POST" action="">
					<div class="field">
						<div class="control">
							<input type="submit" name="submit" class="button is-primary" value="Simpan" style="width: 100%;">
						</div>
					</div>
					<div class="field">
						<div class="control">
							    <div class="select is-multiple">
                                    <select name="acara" multiple size="7">
                                        <?php while($data = mysqli_fetch_assoc($sql)) { ?>
							               <option value="<?= $data['id_acara'] ?>"><?= $data['nama_acara'] ?></option>
							            <?php } ?>
							        </select>
                                </div>
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input type="input" name="tgl" class="input" placeholder="Tanggal">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<input type="input" name="jam_msk" class="input" placeholder="Waktu">
						</div>
					</div>
					<div class="field">
						<div class="control">
							<textarea name="npm" class="textarea is-large" placeholder="Nomor Maahasiswa" rows="10"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="column">
				<div class="notification is-warning">
					<?php 
						if (isset($_POST['submit'])) {
							$npm = $_POST['npm'];
							$arr_npm = explode ("\n",$npm);
							$id_acara = $_POST['acara'];
				// 			$id_kelompok = $_GET['id_kelompok'];
				            $id_kelompok = 300;
							$tgl = date('Y-m-d');
							$jam = $_POST['jam_msk'];
							$id_thn = 12;

							foreach ($arr_npm as $npm1) {
								$sql2 = $db->query("INSERT INTO presensi (npm, id_acara, id_kelompok, tgl, jam_msk, id_thn) VALUES ('$npm1', '$id_acara', '$id_kelompok', '$tgl', '$jam', '$id_thn')");
					            if ($sql2) {
									echo "$npm1 | Berhasil <br/>";
								}else{
									echo "$npm1 | Gagal <br/>";
								}
							};
						}
					 ?>
				 </div>
			</div>
		</div>
	</div>

	<script type='text/javascript'>
		$(document).ready(function() {
        //$("#search_results").slideUp();
	        $("#button_find").click(function(event) {
	            event.preventDefault();
	            //search_ajax_way();
	            ajax_search();
	        });
	        $(".search").keyup(function(event) {
	            event.preventDefault();
	            //search_ajax_way();
	            ajax_search();
	            $(".search").addClass("rad-bottom");
	        });
	        $(".panel").click(function(event) {
	        	$(".panel").addClass("hidden");
	        });
	    });
	    function ajax_search() {
	 
	        var search = $(".search").val();
	        $.ajax({
	            url : "cari.php",
	            data : "search=" + search,
	            success : function(data) {
	                // jika data sukses diambil dari server, tampilkan di <select id=kota>
	                $("#kelompok").html(data);
	            }
	        });
	 
	    }
	</script>
</body>
</html>
