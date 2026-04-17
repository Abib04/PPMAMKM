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
    
    $sukses = 0;
    $gagal = 0;
    
    for($i=0; $i < $jml_data; $i++) {
        if(reg_mhs($arr_data['data'][$i])) {
            $sukses++;
        } else {
            $gagal++;
        }
    }
    
    
    echo 'Sukses : '.$sukses.'<br/>';
    echo 'Gagal : '.$gagal.'<br/>';
    
    function reg_mhs($data_mhs) {
        $def_table = 'mahasiswa';
        
        $data["npm"] = $data_mhs->Nim;
        $data["id_prodi"] = get_prodi($data_mhs->Nim);
        $data["nama"] = $data_mhs->Nama;
        $data["email"] = $data_mhs->Email;
        $data["hp"] = $data_mhs->NoWa;
        $data["no_tes"] = $data_mhs->NoTes;
        $data["id_thn"] = get_year(get_active_year());
        $passwd = $data_mhs->NoTes;
        $data['password'] = md5($passwd);
        $data['konfirmasi'] = 'Y';
        
        $data["jk"] = $data_mhs->Gender=='L'?'laki-laki':'perempuan';
        
        // return db_insert($def_table, $data);
        
    }
    
    function db_insert($table, $data = array()){
        
        global $con;
    
        $q = "insert into " . $table . " set ";
    
                        foreach($data as $column => $value){
    
                            $q .= "`" . $column . "` = '" . $value . "', ";
    
                        }
                        
    
                        //echo rtrim($q, ", ");
    
                         $sql = mysqli_query($con, rtrim($q, ", "));
    
    
    
                        if(mysqli_affected_rows($con) > 0){
    
                            return TRUE;
    
                        }else{
    
                            $_SESSION['err_message'] = mysqli_error($con);
                            
                            //echo $q;
    
                            return FALSE;
    
                        }
    
    }


    function db_select($query){
        return db_read($query);
    }
    
    function db_read($query){
    
        global $con;
    
        if(!is_null($query)){
    
            mysqli_set_charset($con, "utf8");
    
            $sql = mysqli_query($con, $query);
    
            $buffer = array();
    
            while($row = mysqli_fetch_assoc($sql)){
    
                $buffer[] = $row;
    
            }
    
            
    
            return $buffer;
    
        }
    
    }
    
    function get_active_year(){
        $year = db_read("select thn from tahun where status='Y'");
        if(count($year) > 0){
            return $year[0]['thn'];
        }
    }
    
    function get_year($thn){
        $year = db_read("select id_thn from tahun where thn='".$thn."'");
        if(count($year) > 0){
            return $year[0]['id_thn'];
        }else{
            return FALSE;
        }
    }
    
    function get_prodi($npm){
    
        $_prodi = db_read("select id from prodi where kode='".substr($npm,3,2)."'");
        return $_prodi[0]['id'];
    }
