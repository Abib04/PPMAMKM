<?php 
session_start();
include 'presensi/koneksi.php';


if ($_GET['aksi'] == 'kab') {
    
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Kabupaten.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    
        $result = $db->query("SELECT * from kabupaten");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Kabupaten</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>ID kabupaten</th>
                    <th>Nama kabupaten</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";;
                echo "<td>" .$row['id_kab']. "</td>";
                echo "<td>" .$row['nama_kab']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
        
}
if ($_GET['aksi'] == 'mhs') {
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Kabupaten.xls");
    
        $result = $db->query("SELECT mahasiswa.*, daerah.nama_daerah, kabupaten.nama_kab FROM `mahasiswa` JOIN daerah ON daerah.id_daerah = mahasiswa.id_daerah JOIN kabupaten ON kabupaten.id_kab = mahasiswa.id_kab");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Kabupaten</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>Name</th>
                    <th>Nohp</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Tgl Lahir</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Gender</th>
                    <th>Kecamatan</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Kode Pos</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$row['nama']. "</td>";
                echo "<td>" .$row['hp']. "</td>";
                echo "<td>" .$row['email']. "</td>";
                echo "<td>" .$row['password']. "</td>";
                echo "<td>" .$row['tgl_lahir']. "</td>";
                echo "<td>" .$row['nama_daerah']. "</td>";
                echo "<td>" .$row['nama_kab']. "</td>";
                echo "<td>" .$row['jk']. "</td>";
                echo "<td>" .$row['kecamatan']. "</td>";
                echo "<td>" .$row['alamat_asal']. "</td>";
                echo "<td>" .$row['rt']. "/".$row['rw']."</td>";
                echo "<td>" .$row['kode_pos']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
        
}
elseif ($_GET['aksi'] == 'penyakit') {
    
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Mahasiswa Penyakit PPM2019.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
        $result = $db->query("SELECT mahasiswa.nama, penyakit.nama_penyakit, mahasiswa.jk, mahasiswa.hp, keluarga.telepon FROM `penyakit_mahasiswa` LEFT JOIN mahasiswa ON mahasiswa.npm = penyakit_mahasiswa.npm LEFT JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np LEFT JOIN keluarga ON keluarga.npm = mahasiswa.npm WHERE mahasiswa.id_thn = 12 ORDER BY penyakit.nama_penyakit, mahasiswa.nama ASC");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Mahasiswa <b>Penyakit</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nama Penyakit</th>
                    <th>Jenis Kelamin</th>
                    <th>No HP Mahasiswa</th>
                    <th>No HP Ortu</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode. "</td>";
                echo "<td>" .$row['nama']. "</td>";
                echo "<td>" .$row['nama_penyakit']. "</td>";
                echo "<td>" .$row['jk']. "</td>";
                echo "<td>" .$row['hp']. "</td>";
                echo "<td>" .$row['telepon']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
                    
}
elseif ($_GET['aksi'] == 'data_mhs_riau') {
    
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Mahasiswa PPM2019.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
        $result = $db->query("SELECT * FROM `mahasiswa` WHERE id_daerah = 4 ORDER BY nama ASC");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Mahasiswa <b>Riau</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode. "</td>";
                echo "<td>" .$row['nama']. "</td>";
                echo "<td>" .$row['hp']. "</td>";
                echo "<td>" .$row['id_thn']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
                    
}elseif($_GET['aksi'] == 'dataprodi') {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data prodi PPM2019.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
        $result = $db->query("SELECT prodi.nama_prodi as prodi, COUNT(mahasiswa.id_prodi) as jml FROM `mahasiswa` LEFT JOIN prodi ON mahasiswa.id_prodi = prodi.id WHERE mahasiswa.id_thn = 12 AND mahasiswa.konfirmasi = 'Y' GROUP BY prodi.id");
        $a = mysqli_num_rows($result);

        echo "<h3>Data per prodi";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>No</th>
                    <th>prodi</th>
                    <th>Jumlah</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode. "</td>";
                echo "<td>" .$row['prodi']. "</td>";
                echo "<td>" .$row['jml']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
}
elseif($_GET['aksi'] == 'oh') {
    // header("Content-type: application/vnd-ms-excel");
    // header("Content-Disposition: attachment; filename=Data Keluarga OH PPM2019.xls");
    // header("Pragma: no-cache");
    // header("Expires: 0");
    
        $result = $db->query("SELECT npm, mhs, tanggal_mulai, jam_mulai, nama_ruang FROM `vsesi_oh` WHERE id_sesi IN(92,93) AND id_thn = 12");
        $a = mysqli_num_rows($result);

        echo "<h3>Data Keluarga <b>OpenHouse</h3>";

        echo "<table border='1' width:'100%' cellpadding='20'>
                <thead>
                    <th>No</th>
                    <th>Npm</th>
                    <th>Nama Mahasiswa</th>
                    <th>Tanggal Mulai</th>
                    <th>Jam Mulai</th>
                    <th>Nama Ruang</th>
                </thead>

              <tbody>";
                $kode = 1;
                while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$kode. "</td>";
                echo "<td>" .$row['npm']. "</td>";
                echo "<td>" .$row['mhs']. "</td>";
                echo "<td>" .$row['tanggal_mulai']. "</td>";
                echo "<td>" .$row['jam_mulai']. "</td>";
                echo "<td>" .$row['nama_ruang']. "</td>";
                echo "</tr>";

                $kode++;
            }

             echo"</tbody>
                    </table>";
}
elseif($_GET['aksi'] == ''){
    echo "cookkk...";
}else{
    echo "suuuu";
}
        
?>

  </div>
