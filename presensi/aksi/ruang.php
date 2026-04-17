<?php 
include '../koneksi.php';

$acara_id = @$_POST['acara_id'];

$sql_acara = mysqli_query($db, "SELECT * FROM vdivroom WHERE id_acara = $acara_id AND id_thn = 15");

while ($data = mysqli_fetch_array($sql_acara)) {
echo '<option value="'.$data['id_ruang'].'">'.$data['nama_ruang'].'</option>';
}
?>
