<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("potensi", "bidang", "potensi_bidang", "jenis_potensi");

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

$match = false;
if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    require( 'config/ssp.class.php' );
    include_once( 'config/config_dt.php' );

    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    $table = cleanchar($_GET['t']);
    
	if(!is_null($id)){
	    if($table == $def_table[0]){
		$q = db_read("SELECT * FROM ".$table." WHERE id_potensi = ".$id." and npm = '".$_SESSION['username']."'");
		if(count($q) > 0) {
		    $match = true;
		}
	    } 
	}


    $data = array();
    
    if($op == "create" or $op == "update"){
        
        if($table == $def_table[0]){ //POTENSI
         
            $data = array(
                    "npm" => $_SESSION['username'],
                    "id_pb" => cleanchar($_POST['id_pb']),
                    "potensi" => cleanchar($_POST['potensi'])
            );
            
        }else if($table == $def_table[1]){ // BIDANG
            
            $data = array(
                    "nama_bidang" => cleanchar($_POST['nama_bidang'])
            );
            
        }else if($table == $def_table[2]){ // POTENSI BIDANG
            
            $data = array(
                    "id_jenis" => cleanchar($_POST['id_jenis']),
                    "id_bidang" => cleanchar($_POST['id_bidang'])
            );
            
        }else if($table == $def_table[3]){ // JENIS POTENSI
            
            $data = array(
                    "jenis_potensi" => cleanchar($_POST['jenis_potensi'])
            );
            
        }
        
    }
    
    if($op == "create"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $potensi = db_read("select potensi from potensi where npm='".$_SESSION['username']."' AND potensi='".cleanchar($_POST['potensi'])."' AND id_pb='".cleanchar($_POST['id_pb'])."'");
                if(count($potensi) > 0){
                    echo "Maaf, potensi mahasiswa tersebut sudah ada.";
                }else{
                    $data['id_thn_potensi'] = get_year(get_active_year());
                    if(db_insert($def_table[0], $data)){
                        echo "true";
                    }else{
                        if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                            echo "Maaf, potensi mahasiswa sudah terdaftar";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                    }
                }
                
            }else if($table == $def_table[1]){
                $bidang = db_read("select nama_bidang from bidang where nama_bidang='".cleanchar($_POST['nama_bidang'])."'");
                if(count($bidang) > 0){
                    echo "Maaf, bidang potensi tersebut sudah ada.";
                }else{
                    if(db_insert($def_table[1], $data)){
                        echo "true";
                    }else{
                        if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                            echo "Maaf, Bidang Potensi sudah ada.";
                        }else{
                            echo "Maaf, Bidang gagal disimpan.";
                        }
                    }
                }
                
            }else if($table == $def_table[2]){
                $potensi_bidang = db_read("select id_pb from potensi_bidang where id_jenis='".cleanchar($_POST['id_jenis'])."' AND id_bidang='".cleanchar($_POST['id_bidang'])."'");
                if(count($potensi_bidang) > 0){
                    echo "Maaf, detail potensi tersebut sudah ada.";
                }else{
                
                    if(db_insert($def_table[2], $data)){
                        echo "true";
                    }else{
                        if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                            echo "Maaf, Potensi Bidang sudah ada.";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                    }
                }
                
            }else if($table == $def_table[3]){
                
                $jenis_potensi = db_read("select jenis_potensi from jenis_potensi where jenis_potensi='".cleanchar($_POST['jenis_potensi'])."'");
                if(count($jenis_potensi) > 0){
                    echo "Maaf, jenis potensi tersebut sudah ada.";
                }else{
                    if(db_insert($def_table[3], $data)){
                        echo "true";
                    }else{
                        if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                            echo "Maaf, Jenis Potensi sudah ada.";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                    }
                }
                
            }
            
        }
        
    }elseif($op == "read"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $filter = "";
            
                if(isset($_GET['jenis']) and $_GET['jenis'] != ""){
                    $filter .= " and `id_jenis` = ".cleanchar($_GET['jenis']);
                }
                if(isset($_GET['bidang']) and $_GET['bidang'] != "" ){
                    $filter .= " and id_bidang = ".cleanchar($_GET['bidang']);
                }
            
                if(!is_null($id)){
                    echo json_encode(db_read("select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vpotensi.npm) as nama from vpotensi where id_potensi='$id' ".$filter));
                }else{
                   echo json_encode(db_read("select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vpotensi.npm) as nama from vpotensi where 1 ".$filter));
                }
                
            }else if($table == $def_table[1]){
                $filter = "";
            
            
                if(!is_null($id)){
                    echo json_encode(db_read("select * from bidang where id_bidang='$id' ".$filter));
                }else{
                   echo json_encode(db_read("select * from bidang where 1 ".$filter));
                }
                
            }else if($table == $def_table[2]){
                $filter = "";
            
            
                if(!is_null($id)){
                    echo json_encode(db_read("SELECT * FROM potensi_bidang pb JOIN bidang b ON pb.id_bidang=b.id_bidang JOIN jenis_potensi jp ON pb.id_jenis=jp.id_jenis WHERE id_pb='$id' ".$filter));
                }else{
                   echo json_encode(db_read("SELECT * FROM potensi_bidang pb JOIN bidang b ON pb.id_bidang=b.id_bidang JOIN jenis_potensi jp ON pb.id_jenis=jp.id_jenis WHERE 1 ".$filter));
                }
                
            }else if($table == $def_table[3]){
                $filter = "";
            
            
                if(!is_null($id)){
                    echo json_encode(db_read("SELECT * FROM jenis_potensi WHERE id_jenis='$id' ".$filter));
                }else{
                   echo json_encode(db_read("SELECT * FROM jenis_potensi WHERE 1 ".$filter));
                }
                
            }
            
        }
        
    }elseif($op == "update"){
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){
                    $potensi = db_read("select potensi from potensi where npm='".$_SESSION['username']."' AND potensi='".cleanchar($_POST['potensi'])."' AND id_pb='".cleanchar($_POST['id_pb'])."'");
                    if(count($potensi) > 0){
                        echo "Maaf, potensi tersebut sudah ada.";
                    }else {
                        if (db_update($def_table[0], $data, array("id_potensi" => $id))) {
                            echo "true";
                        } else {
                            echo "Maaf, gagal ubah potensi.";
                        }
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){
                    
                    $bidang = db_read("select nama_bidang from bidang where nama_bidang='".cleanchar($_POST['nama_bidang'])."'");
                    if(count($bidang) > 0){
                        echo "Maaf, bidang potensi tersebut sudah ada.";
                    }else{

                        if(db_update($def_table[1], $data, array("id_bidang" => $id))){
                            echo "true";
                        }else{
                            echo "Maaf, Bidang gagal disimpan.";
                        }
                    }
                }
                
            }else if($table == $def_table[2]){
                
                if(is_null($id) == FALSE){
                    $potensi_bidang = db_read("select id_pb from potensi_bidang where id_jenis='".cleanchar($_POST['id_jenis'])."' AND id_bidang='".cleanchar($_POST['id_bidang'])."'");
                    if(count($potensi_bidang) > 0){
                        echo "Maaf, detail potensi tersebut sudah ada.";
                    }else{
                        if(db_update($def_table[2], $data, array("id_pb" => $id))){
                            echo "true";
                        }else{
                            echo "Maaf, Potensi Bidang gagal disimpan.";
                        }
                    }
                }
                
            }else if($table == $def_table[3]){
                
                if(is_null($id) == FALSE){

                    $jenis_potensi = db_read("select jenis_potensi from jenis_potensi where jenis_potensi='".cleanchar($_POST['jenis_potensi'])."'");
                    if(count($jenis_potensi) > 0){
                        echo "Maaf, jenis potensi tersebut sudah ada.";
                    }else{
                    
                        if(db_update($def_table[3], $data, array("id_jenis" => $id))){
                            echo "true";
                        }else{
                            echo "Maaf, Jenis Potensi gagal disimpan.";
                        }
                    }
                }
                
            }
            
        } 
    }elseif($op == "read_spesial"){
        if(in_array($table, $def_table)){
            
            if($table == $def_table[0]){
                
                $filter = "";
            
                if(isset($_GET['jenis']) and $_GET['jenis'] != ""){
                    $filter .= " and `id_jenis` = ".cleanchar($_GET['jenis']);
                }
                if(isset($_GET['bidang']) and $_GET['bidang'] != "" ){
                    $filter .= " and id_bidang = ".cleanchar($_GET['bidang']);
                }
                
                if(isset($_GET['id_thn']) and $_GET['id_thn'] != "" ){
                    $filter .= " and id_thn = ".cleanchar($_GET['id_thn']);
                }
            
                if(!is_null($id)){
$table = <<<EOT
 (
    select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vpotensi.npm) as nama from vpotensi where id_potensi='$id' $filter
 ) temp
EOT;
                }else{
$table = <<<EOT
 (
    select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vpotensi.npm) as nama, (SELECT mahasiswa.hp from mahasiswa where mahasiswa.npm = vpotensi.npm) as kontak_mhs, (SELECT keluarga.telepon from keluarga where keluarga.npm = vpotensi.npm limit 1) as kontak_wali from vpotensi where 1 $filter
 ) temp
EOT;
                }

                // Table's primary key
                $primaryKey = 'id_potensi';
                // indexes
                $columns = array(
                    array( 'db' => 'npm', 'dt' => 'npm' ),
                    array( 'db' => 'nama',  'dt' => 'nama' ),
                    array( 'db' => 'jenis_potensi',  'dt' => 'jenis_potensi' ),
                    array( 'db' => 'nama_bidang',  'dt' => 'nama_bidang' ),
                    array( 'db' => 'potensi',  'dt' => 'potensi' ),
                    array( 'db' => 'id_potensi', 'dt' => 'id_potensi' ),
                    array( 'db' => 'kontak_mhs', 'dt' => 'kontak_mhs' ),
                    array( 'db' => 'kontak_wali', 'dt' => 'kontak_wali' )
                );
                echo json_encode(
                    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            }
        }
        
    }elseif($op == "select_jenis"){
        echo '<option value="">-- Pilih --</option>';
        if(isset($_GET['id_jenis'])){
            
            if(isset($_GET['id_pb'])){
                $id_pb = $_GET['id_pb'];
            }else{
                $id_pb = "";
            }
            
            $id = $_GET['id_jenis'];
            $sql_bidang = db_read("select id_pb, nama_bidang from potensi_bidang pb JOIN bidang b ON pb.id_bidang=b.id_bidang where id_jenis='$id'");
            foreach ($sql_bidang as $key => $value):
    ?>
            <option value="<?php echo $value['id_pb']; ?>" <?php echo ($value['id_pb']==$id_pb)?"selected":"";?>><?php echo $value['nama_bidang']; ?></option>
    <?php
            endforeach;
        }
       
    }elseif($op == "delete"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi" or $match)){
                    if(is_null($id) == FALSE){
                        //Cek Minimal Ada 1 Data
                        $thn_aktif = get_year(get_active_year());
                        $sql_cek = db_read("SELECT COUNT(*) as jml FROM potensi WHERE npm=(select npm from potensi WHERE id_potensi='$id' AND `id_thn_potensi`='$thn_aktif') AND `id_thn_potensi`='$thn_aktif'");
                        if($sql_cek[0]['jml']==1){
                            echo "Minimal ada satu potensi yang terisi";
                        }else{
                            if(db_delete($def_table[0], array("id_potensi" => $id))){
                                echo "true";
                            }else{
                                echo $_SESSION['err_message'];
                            }
                        }
                        
                    }
		        } else {
		            echo 'Anda tidak diperbolehkan melakukan aksi ini.';
		        }
                
            }else if($table == $def_table[1]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
                    if(is_null($id) == FALSE){
                        
                        if(db_delete($def_table[1], array("id_bidang" => $id))){
                            echo "true";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                        
                    }
    		    } else {
    		        echo 'Tidak diperbolehkan melakukan aksi ini.';
    		    }
                
            }else if($table == $def_table[2]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
                    if(is_null($id) == FALSE){
                        
                        if(db_delete($def_table[2], array("id_pb" => $id))){
                            echo "true";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                        
                    }
    		    } else {
    		        echo 'Tidak diperbolehkan melakukan aksi ini.';
    		    }
                
            }else if($table == $def_table[3]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
                    if(is_null($id) == FALSE){
                        
                        if(db_delete($def_table[3], array("id_jenis" => $id))){
                            echo "true";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                        
                    }
    		    } else {
    		        echo 'Tidak diperbolehkan melakukan aksi ini.';
    		    }
                
            }
            
        }
        
        
    }else{
        
        include "error/page_404.php";
        
    }
    
}
