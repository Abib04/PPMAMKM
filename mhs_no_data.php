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
    
    
    $nim_arr = array_column($data, 'Nim');
    // print_r($nim_arr);
    // echo "<hr/>";
    
    $sql = "SELECT npm FROM mahasiswa where id_thn = 17 and konfirmasi='Y'";
    $result = $con->query($sql);
    
    $nim_db_arr = [];
    while($row = $result->fetch_assoc()) {
        $nim_db_arr[] = $row["npm"];
    }
    
    // print_r($nim_db_arr);
    // echo "<hr/>";
    
    $baru_datang = array_diff($nim_arr,$nim_db_arr);
    echo "Yang baru datang (belum input di DB), jumlahnya ".count($baru_datang)." : <br/>";
    print_r($baru_datang);
    echo "<hr/>";
    
    $undur_diri = array_diff($nim_db_arr,$nim_arr);
    echo "Yang undurkan diri, jumlahnya ".count($undur_diri)." : <br/>";
    print_r($undur_diri);
    echo "<hr/>";
    
    
    
