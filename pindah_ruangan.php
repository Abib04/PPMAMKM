<?php
session_start();

if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){  

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
    
    $sql = "SELECT * FROM acara_ruang_fakultas WHERE (npm like '%.96.%' or npm like '%.67.%') and id_sesi = 150 ORDER BY npm ASC, id_ruang ASC;";
    $result = $con->query($sql);
    
    while($row = $result->fetch_assoc()) {
        
        $sql_cek_ruangan = "SELECT * FROM acara_ruang_fakultas WHERE npm= '".$row['npm']."' and id_sesi = 151 limit 1";
                // echo $sql_cek_ruangan.'<br/>';
                
                $result_cek_ruangan = $con->query($sql_cek_ruangan);
                
                if ($result_cek_ruangan->num_rows > 0) {
                    while($row_cek_ruangan = $result_cek_ruangan->fetch_assoc()) {
                        
                        $sql_update_ruangan = "UPDATE `acara_ruang_fakultas` SET `id_ruang`= ".$row_cek_ruangan['id_ruang']." WHERE npm = '".$row['npm']."' and (id_sesi = 150 or id_sesi = 152)";
                        $con->query($sql_update_ruangan);
                        
                        echo $row['npm']."Berubah Ke Ruangan : ".$row_cek_ruangan['id_ruang']."<br/><br/>";
                    }
                } else {
                    echo "Belum Ada Ruangan<br/><br/>";
                }
    }
    
} else {
  echo "<script>
  alert('Anda tidak diperkenankan melakukan aksi ini.');
  </script>";
}
