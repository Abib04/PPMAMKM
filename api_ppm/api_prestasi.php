<?php
    include "koneksi.php";
    error_reporting(0);
    
    $tahun = $_GET['tahun'];
    $kode_prodi = $_GET['prodi'];

    $sql = "SELECT vprestasi.*, mahasiswa.nama, prodi.nama_prodi, tahun.thn as tahun_ppm FROM vprestasi LEFT JOIN mahasiswa ON mahasiswa.npm = vprestasi.npm LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi LEFT JOIN tahun ON tahun.id_thn = vprestasi.id_thn ";
    

    if($tahun!= null && $tahun != "") {
        $sql .= "WHERE tahun.thn = '$tahun' ";
    }

    if($tahun!= null && $tahun != "" && $kode_prodi!= null && $kode_prodi != "") {
        $sql .= " AND prodi.kode = '$kode_prodi' ";
    }

    if(($kode_prodi!= null && $kode_prodi != "") && ($tahun == null || $tahun == "")) {
        $sql .= " WHERE prodi.kode = '$kode_prodi' ";
    }

    if (($tahun == null || $tahun == "") && ($kode_prodi!= null && $kode_prodi == "")) {
        $sql .= " LIMIT 0,1000 ";
    }

    $sql .= " ORDER BY vprestasi.npm DESC";
    
    $result = $conn->query($sql);

    $arr_result = [
        "jumlah_data" => $result->num_rows,
        "data" => []
    ];

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $arr_result['data'][] = $row;
        }
    }

    echo json_encode($arr_result, JSON_PRETTY_PRINT);
    
    $conn->close();
