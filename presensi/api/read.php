<?php
header('Access-Control-Allow-Origin: *');

include "../koneksi.php";

    if(isset($_GET['nim'])) {
        $npm = $_GET['nim'];
        
        $result = $db->query("SELECT * FROM mahasiswa 
            JOIN negara ON negara.id_negara = mahasiswa.id_negara
            JOIN daerah ON daerah.id_daerah = mahasiswa.id_daerah
            JOIN kabupaten ON kabupaten.id_kab = mahasiswa.id_kab
            JOIN kelompok ON kelompok.id = mahasiswa.id_kelompok
            JOIN prodi ON prodi.id = mahasiswa.id_prodi
            JOIN agama ON agama.id_agama = mahasiswa.id_agama
            WHERE mahasiswa.npm = '$npm'");
            
        $data = mysqli_fetch_assoc($result);
        $nim = $data['npm'];
        $nama = $data['nama'];
        $gambar = $data['npm'].".jpg";
        $jurusan = $data['nama_prodi'];
        $negara = $data['nama_negara'];
        $daerah = $data['nama_daerah'];
        $kabupaten = $data['nama_kab'];
        $kelompok = $data['nama_kelompok'];
        $hp = $data['hp'];
        $agama = $data['nama_agama'];
     
            $tampil = array(
                array(
                    'nama' => $nama,
                    'nim' => $nim,
                    'gambar' => $gambar,
                    'jurusan' => $jurusan,
                    'negara' => $negara,
                    'daerah' => $daerah,
                    'kabupaten' => $kabupaten,
                    'kelompok' => $kelompok,
                    'hp' => $hp,
                    'agama' => $agama
                    ));
                    
            echo json_encode($tampil); 
        
}else{

     $result = $db->query("SELECT m.npm, m.nama , p.jam_msk FROM presensi1 p LEFT JOIN mahasiswa m ON m.npm = p.npm WHERE p.id_thn = 12 ORDER BY p.jam_msk DESC");
     
    $arraydata = array();
    
    while($baris = mysqli_fetch_assoc($result))
    {
        $arraydata[] = $baris;
    }
    echo json_encode($arraydata);
}
    
?>
