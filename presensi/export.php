<?php 
session_start();
include 'koneksi.php';
$id_acara = $_SESSION['acara'];
$id_ruang = $_SESSION['ruang'];

$result = $db->query("SELECT * FROM acara WHERE id_acara = $_SESSION[acara]");
$acara = mysqli_fetch_assoc($result);

$result1 = $db->query("SELECT * FROM ruang WHERE id_ruang = $_SESSION[ruang]");
$ruang = mysqli_fetch_assoc($result1);



 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=PPM-2018-".$acara['nama_acara']."-ruang-".$ruang['nama_ruang'].".xls");
 header("Pragma: no-cache");
 header("Expires: 0");

 ?>

<?php

if ($id_acara == 4) {
        $result = $db->query("SELECT mahasiswa.*, presensi.* FROM presensi
        LEFT JOIN mahasiswa ON mahasiswa.npm = presensi.npm
        WHERE id_acara = 4 ORDER BY id DESC");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Mahasiswa <b>" .$acara['nama_acara']." (".$ruang['nama_ruang'].")</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Ruangan</th>
                    <th>Jam</th>
                </thead>

              <tbody>";

            if ($a < 1) {
                echo "<tr class='notification is-info'>";
                echo "<td colspan='5'><center>Belum ada yang melakukan presensi untuk acara ini.<center></td>";
                echo "</tr>";
            }else{
                    $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode; "</td>";
                echo "<td>" .$row['nama']. "</td>";
                echo "<td>" .$row['npm']. "</td>";
                echo "<td>JEC</td>";
                echo "<td>" .$row['jam_msk']. "</td>";
                echo "</tr>";

                $kode++;
            }
            }

             echo"</tbody>
                    </table>";
        
        }else{

            $result = $db->query("SELECT vjadwalperson.*, presensi.* FROM presensi
            LEFT JOIN vjadwalperson ON vjadwalperson.npm = presensi.npm and vjadwalperson.id_kelompok = presensi.id_kelompok and vjadwalperson.id_acara = $id_acara
        WHERE presensi.id_acara = $id_acara and id_ruang = $id_ruang ORDER BY presensi.id DESC");
        $a = mysqli_num_rows($result);

        	echo "<h3>Data Mahasiswa <b>" .$acara['nama_acara']." (".$ruang['nama_ruang'].")</h3>";

            echo "<table border='1' width: '100%;'>
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nim</th>
                    <th>Kelompok</th>
                    <th>Ruangan</th>
                    <th>Jam masuk</th>
                </thead>

              <tbody>";

            if ($a < 1) {
                echo "<tr class='notification is-info'>";
                echo "<td colspan='5'><center>Belum ada yang melakukan presensi untuk acara ini.<center></td>";
                echo "</tr>";
            }else{
                    $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode. "</td>";
                echo "<td>" .$row['nama']. "</td>";
                echo "<td>" .$row['npm']. "</td>";
                echo "<td>" .$row['nama_kelompok']. "</td>";
                echo "<td>" .$row['nama_ruang']. "</td>";
                echo "<td>" .$row['jam_msk']. "</td>";
                echo "</tr>";

                $kode++;
            }
            }

            echo"</tbody>
                    </table>";
    }


?>

  </div>
