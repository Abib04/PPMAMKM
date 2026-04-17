<?php

    $config = array(
				'db_hostname' => 'localhost',
				'db_uname' => 'ppm_2020',
				'db_passwd' => '',
				'dbname' => 'ppm_2020'
		  );
		 
    global $con;
    
    $con = mysqli_connect($config['db_hostname'], $config['db_uname'], $config['db_passwd']);
    
    if(!$con){
        die(trigger_error("Connection failed : ".mysqli_connect_error()));
    }else{
        mysqli_select_db($con, $config['dbname']);
    }
    
    $url="http://ppmapi.amikom.ac.id/api/list_cmhs";
    // $param=array('IsMhs' => 'Y', 'NoTes' => '24000004', 'Nama' => 'Ola');
    $param=array('IsMhs' => 'Y');
     
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    
    $data = json_decode($response);
    $jml_data = count($data);
    
    $arr_data = [
        'jml_data' => $jml_data,
        'data' => $data,
    ];
    
    // print_r($arr_data);
    // echo $response;
    
    
    $notes_arr = array_column($data, 'NoTes');
    $nim_arr = array_column($data, 'Nim');
    $email_arr = array_column($data, 'Email');
    $nama_arr = array_column($data, 'Nama');
    // print_r($nim_arr);
    // echo "<hr/>";
    
    $sql = "SELECT npm,no_tes,email,nama, konfirmasi FROM mahasiswa where id_thn = 17 and (mahasiswa.create_at < '2024-09-04 05:16:21' or mahasiswa.create_at > '2024-09-04 07:16:21')";
    $result = $con->query($sql);
    
    $nim_db_arr = [];
    $notes_db_arr = [];
    $email_db_arr = [];
    $nama_db_arr = [];
    $konfirm_db_arr = [];
    while($row = $result->fetch_assoc()) {
        $nim_db_arr[] = $row["npm"];
        $notes_db_arr[] = $row["no_tes"];
        $email_db_arr[] = $row["email"];
        $nama_db_arr[] = $row["nama"];
        $konfirm_db_arr[] = $row["konfirmasi"];
    }
    
    // print_r($nim_db_arr);
    // echo "<hr/>";
    
    $baru_datang = array_diff($nim_arr,$nim_db_arr);
    // $baru_datang = array_diff($nama_arr,$nama_db_arr);
    // $baru_datang = array_diff($email_arr,$email_db_arr);
    // $baru_datang = array_diff($notes_arr,$notes_db_arr);
    echo "Yang baru datang (belum input di DB), jumlahnya ".count($baru_datang)." : <br/>";
    // print_r($baru_datang);
    $no = 0;
    foreach($baru_datang as $key => $value) {
        $no++;
        echo $no.'. ['.$key.'] Nama : '.$nama_arr[$key].', Email : '.$email_arr[$key].', NPM : '.$nim_arr[$key].', No.tes : '.$notes_arr[$key].'<br/>';
    }
    echo "<hr/>";
    
    $undur_diri = array_diff($nim_db_arr,$nim_arr);
    // $undur_diri = array_diff($nama_db_arr,$nama_arr);
    // $undur_diri = array_diff($email_db_arr,$email_arr);
    // $undur_diri = array_diff($notes_db_arr,$notes_arr);
    echo "Yang undurkan diri/pindah prodi, jumlahnya ".count($undur_diri)." : <br/>";
    // print_r($undur_diri);
    $no = 0;
    foreach($undur_diri as $key => $value) {
        $no++;
        echo $no.'. ['.$key.'] Nama : '.$nama_db_arr[$key].', Email : '.$email_db_arr[$key].', NPM : '.$nim_db_arr[$key].', No.tes : '.$notes_db_arr[$key].', Konfirm : '.$konfirm_db_arr[$key].'<br/>';
        
        $sql_cek_potensi = "SELECT id_potensi from potensi where npm= '".$nim_db_arr[$key]."' limit 1";
        // echo $sql_cek_potensi.'<br/>';
        
        $result_potensi = $con->query($sql_cek_potensi);
        
        if ($result_potensi->num_rows > 0) {
            while($row_potensi = $result_potensi->fetch_assoc()) {
                echo "---------------------------ID Potensi : ".$row_potensi['id_potensi'].'<br/>';
            }
        } else {
            echo "No Potensi<br/>";
        }
        
        $sql_cek_double = "SELECT id_potensi,mahasiswa.npm,`nama`,`hp`,`alamat_asal`,`email`,`konfirmasi` FROM mahasiswa LEFT JOIN potensi ON potensi.npm = mahasiswa.npm WHERE nama IN (SELECT nama FROM mahasiswa WHERE mahasiswa.id_thn = '17' AND mahasiswa.email not in('-','',' ') GROUP BY mahasiswa.nama HAVING COUNT(mahasiswa.nama) > 1 OR COUNT(mahasiswa.hp) > 1 OR COUNT(mahasiswa.email) > 1) and mahasiswa.nama= '".$nama_db_arr[$key]."' and mahasiswa.npm != '".$nim_db_arr[$key]."'  ORDER BY mahasiswa.nama limit 1";
        // echo $sql_cek_double.'<br/>';
        
        $result_double = $con->query($sql_cek_double);
        
        if ($result_double->num_rows > 0) {
            while($row_double = $result_double->fetch_assoc()) {
                echo "--------------------------------NPM Double : ".$row_double['npm'].'<br/>';
                
                $sql_cek_potensi_double = "SELECT id_potensi from potensi where npm= '".$row_double['npm']."' limit 1";
                // echo $sql_cek_potensi_double.'<br/>';
                
                $result_potensi_double = $con->query($sql_cek_potensi_double);
                
                if ($result_potensi_double->num_rows > 0) {
                    while($row_potensi_double = $result_potensi_double->fetch_assoc()) {
                        echo "-------------------------------------ID Potensi Baru : ".$row_potensi_double['id_potensi'].'<br/><br/>';
                    }
                } else {
                    echo "Belum Isi Potensi Lagi<br/><br/>";
                }
            }
        } else {
            echo "No Double<br/><br/>";
        }
        
        
        $sql_update_nonaktif = "UPDATE `mahasiswa` SET `konfirmasi` = 'N' WHERE `mahasiswa`.`npm` = '".$nim_db_arr[$key]."'";
        $con->query($sql_update_nonaktif);
        
        
    }
    echo "<hr/>";
    
    
    
