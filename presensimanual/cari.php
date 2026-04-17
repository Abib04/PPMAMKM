<?php 
	require_once("koneksi.php");

	$search = strip_tags($_GET['search']);

	if($search==""){
		echo"<a class='panel-block' style='font-size: 1.5rem;'>
				Masukan Nama Kelompok
			</a>";
	}else{
	    $query = mysqli_query($db, "SELECT * FROM kelompok where nama_kelompok like '%$search%' AND id > 251"); 
		$result = mysqli_num_rows($query);
		if($result > 0){
			while($rows = mysqli_fetch_assoc($query)){
				echo"<a href=index.php?id_kelompok=$rows[id] class='panel-block' style='font-size: 1.3rem;'>
						$rows[nama_kelompok]
					</a>";
			};
		}else{
			$hasil = " <h4 style='color:red'>Artikel tidak ditemukan!</h4>";
		}
	}
?>
