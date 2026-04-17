<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "keluarga";
$id = isset($_GET['id']) ? cleanchar($_GET['id']) : NULL;
$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;
if($_SESSION['login'] != 1){
	echo "<script>
			alert('Maaf, anda tidak bisa memggunakan ini.');
			location.href='".base_url()."';
		</script>";
}else{
	if(!is_null($id)){
		if(upload_photo('konfirmasi',getcwd().'/resource/mahasiswa/file_kehadiran_ortu/', $_SESSION['username'],false)){
			if(db_update($def_table, array("file_kehadiran" => $_SESSION['username'].".jpg"), array("id_kel" => $id))){
				echo "<script>
					alert('Berhasil disimpan');
					location.href='".base_url('media.php?page=data_mhs_reg_oh')."';
				</script>";
			}else{
				echo "<script>
		            alert('".$_SESSION['err_message']."');
		            window.history.go(-1);
		        </script>";
			}

		}else{
			echo "<script>
		            alert('".$_SESSION['err_message']."');
		            window.history.go(-1);
		        </script>";
		}
	}else{
		echo "<script>
			alert('Maaf, anda tidak bisa memggunakan ini.');
			location.href='".base_url()."';
		</script>";
	}
}

