        <div class="box">

<?php

session_start();

$id_acara = $_SESSION['acara'];

$id_ruang = $_SESSION['ruang'];

include "koneksi.php";

$date = date("Y-m-d");

if ($id_acara == 4) {

        $result = $db->query("SELECT m.npm, m.nama , p.jam_msk FROM presensi p

        LEFT JOIN mahasiswa m ON m.npm = p.npm

        WHERE p.id_acara = 4 and p.id_thn = 12 ORDER BY p.jam_msk DESC");

        $a = mysqli_num_rows($result);



        echo "<table class='table' style='width: 100%;'>

                <thead>

                    <th>Nama</th>

                    <th>NIM</th>

                    <th>Ruangan</th>

                    <th>Jam</th>

                </thead>



              <tbody id='data-tabel'>";



            if ($a < 1) {

                echo "<tr class='notification is-info'>";

                echo "<td colspan='5'><center>Belum ada yang melakukan presensi untuk acara di ruangan ini.<center></td>";

                echo "</tr>";

            }else{

                    $no = 1;

                while($row = $result->fetch_assoc()){

                echo "<tr>";

                // echo "<td>" .$no; "</td>";

                echo "<td>" .$row['nama']. "</td>";

                echo "<td>" .$row['npm']. "</td>";

                echo "<td>JEC</td>";

                echo "<td>" .$row['jam_msk']. "</td>";

                echo "</tr>";

                $no++;

            }

        }



             echo"</tbody>

            </table>"; 

        

        }elseif($id_acara == 3){
            
            $result = $db->query("SELECT vsesi_oh.npm, vsesi_oh.mhs, vsesi_oh.nama_ruang, keluarga.nama_kel, presensi.jam_msk FROM presensi
            LEFT JOIN vsesi_oh ON vsesi_oh.npm = presensi.npm
            LEFT JOIN keluarga ON keluarga.npm = vsesi_oh.npm
            LEFT JOIN sesi_ruang_oh ON sesi_ruang_oh.id_kel = keluarga.id_kel
            WHERE presensi.id_acara = 3 AND presensi.id_thn = 12 AND presensi.jam_msk BETWEEN '01:30:00' AND '10:30:00' ORDER BY presensi.jam_msk DESC");

        $a = mysqli_num_rows($result);



        echo "<table class='table' style='width: 100%;'>

                <thead>

                    <th>NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nama Wali</th>
                    <th>Ruangan</th>
                    <th>Jam</th>

                </thead>



              <tbody id='data-tabel'>";



            if ($a < 1) {

                echo "<tr class='notification is-info'>";

                echo "<td colspan='5'><center>Belum ada yang melakukan presensi untuk acara di ruangan ini.<center></td>";

                echo "</tr>";

            }else{

                    $no = 1;

                while($row = $result->fetch_assoc()){

                echo "<tr>";

                // echo "<td>" .$no; "</td>";

                echo "<td>" .$row['npm']. "</td>";
                echo "<td>" .$row['mhs']. "</td>";
                echo "<td>" .$row['nama_kel']. "</td>";
                echo "<td>" .$row['nama_ruang']. "</td>";
                echo "<td>" .$row['jam_msk']. "</td>";
                echo "</tr>";

                $no++;

            }

        }



             echo"</tbody>

            </table>";
            
        }
        
        else{


            $result = $db->query("SELECT vjadwalperson.*, presensi.* FROM presensi

            LEFT JOIN vjadwalperson ON vjadwalperson.npm = presensi.npm and vjadwalperson.id_kelompok = presensi.id_kelompok and vjadwalperson.id_acara = $id_acara

            WHERE presensi.id_acara = $id_acara and id_ruang = $id_ruang and presensi.id_thn = 12 and presensi.tgl = '2019-09-03' AND jam_msk BETWEEN '12:30:00' AND '15:00:16' ORDER BY presensi.jam_msk DESC");

        $a = mysqli_num_rows($result);





            echo "<table class='table' style='width: 100%;'>

                <thead>

                    <th>No</th>

                    <th>Nama</th>

                    <th>Nim</th>

                    <th>Kelompok</th>

                    <th>Ruangan</th>

                    <th>Jam</th>

                </thead>



              <tbody>";



            if ($a < 1) {

                echo "<tr class='notification is-info'>";

                echo "<td colspan='6'><center>Belum ada yang melakukan presensi untuk acara di ruangan ini.<center></td>";

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

