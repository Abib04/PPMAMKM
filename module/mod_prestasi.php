<?php
if(!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = array("prestasi","bid_prestasi");

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token']))? cleanchar($_GET['token']):null;

$match = false;
if(is_null($op)){
    
    include "error/page_404.php";
    
}else{
    
    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;
    $table = cleanchar($_GET['t']);
    
	if(!is_null($id)){
	    if($table == $def_table[0]){
		$q = db_read("SELECT * FROM ".$table." WHERE id_prestasi = ".$id." and npm = '".$_SESSION['username']."'");
		if(count($q) > 0) {
		    $match = true;
		}
	    } 
	}


    $data = array();
    
    if($op == "create" or $op == "update"){
        
        if($table == $def_table[0]){
         
            $data = array(
                    "npm" => $_SESSION['username'],
                    "id_bid_prestasi" => cleanchar($_POST['bid_prestasi']),
                    "cak_prestasi" => cleanchar($_POST['cak_prestasi']),
                    "nama_prestasi" => cleanchar($_POST['nama_prestasi'])
            );
            
        }else if($table == $def_table[1]){
            
            $data = array(
                    "nama_bid" => cleanchar($_POST['nama_bid']),
                    "status" => cleanchar($_POST['status_bid'])
            );
            
        }
        
    }
    
    if($op == "create"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $prestasi = db_read("select nama_prestasi from prestasi where npm='".$_SESSION['username']."' AND nama_prestasi='".cleanchar($_POST['nama_prestasi'])."' AND cak_prestasi='".cleanchar($_POST['cak_prestasi'])."' AND id_bid_prestasi='".cleanchar($_POST['bid_prestasi'])."'");
                if(count($prestasi) > 0){
                    echo "Maaf, prestasi tersebut sudah ada.";
                }else{
                    $data['id_thn'] = get_year(get_active_year());
                    if(db_insert($def_table[0], $data)){
                        echo "true";
                    }else{
                        if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                            echo "Maaf, Admin anda sudah terdaftar";
                        }else{
                            echo $_SESSION['err_message'];
                        }
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(db_insert($def_table[1], $data)){
                    echo "true";
                }else{
                    if(strpos($_SESSION['err_message'], "Duplicate") > -1){
                        echo "Maaf, Bidang Prestasi anda sudah ada.";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }
            
        }
        
    }elseif($op == "read"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                $filter = "";
            
                if(isset($_GET['tingkat']) and $_GET['tingkat'] != ""){
                    $filter .= " and `cak_prestasi` like '%".cleanchar($_GET['tingkat']."%'");
                }
                if(isset($_GET['bidang']) and $_GET['bidang'] != "" ){
                    $filter .= " and id_bid_prestasi = ".cleanchar($_GET['bidang']);
                }
            
                if(!is_null($id)){
                    echo json_encode(db_read("select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vprestasi.npm) as nama from vprestasi where id_prestasi='$id' ".$filter." and id_thn=".get_year(get_active_year())));
                }else{
                    echo json_encode(db_read("select * , (SELECT mahasiswa.nama from mahasiswa where mahasiswa.npm = vprestasi.npm) as nama from vprestasi where id_thn=".get_year(get_active_year())." ".$filter));
                }
                
            }else if($table == $def_table[1]){
                
                if(!is_null($id)){
                    echo json_encode(db_read("select * from $def_table[1] where id_bid_prestasi='$id'"));
                }else{
                    echo json_encode(db_read("select * from $def_table[1]"));
                }
                
            }
            
        }
        
    }elseif($op == "update"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                
                if(is_null($id) == FALSE){
                    $prestasi = db_read("select nama_prestasi from prestasi where npm='".$_SESSION['username']."' AND nama_prestasi='".cleanchar($_POST['nama_prestasi'])."' AND cak_prestasi='".cleanchar($_POST['cak_prestasi'])."' AND id_bid_prestasi='".cleanchar($_POST['bid_prestasi'])."'");
                    if(count($prestasi) > 0){
                        echo "Maaf, prestasi tersebut sudah ada.";
                    }else {
                        if (db_update($def_table[0], $data, array("id_prestasi" => $id))) {
                            echo "true";
                        } else {
                            echo $_SESSION['err_message'];
                        }
                    }
                }
                
            }else if($table == $def_table[1]){
                
                if(is_null($id) == FALSE){

                    if(db_update($def_table[1], $data, array("id_bid_prestasi" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                }
                
            }
            
        }    
    }elseif($op == "read_spesial"){
        $data = db_read("SELECT prestasi.npm,(select nama from mahasiswa where mahasiswa.npm=prestasi.npm) as nama,
        (SELECT nama_bid from bid_prestasi where bid_prestasi.id_bid_prestasi=prestasi.id_bid_prestasi) as bidang,
        cak_prestasi, nama_prestasi, a.jumlah ,id_thn
        FROM ppm_2016.prestasi join (select b.npm,count(b.npm) as jumlah from prestasi b group by b.npm) a on prestasi.npm=a.npm where id_thn=".get_year(get_active_year())." order by jumlah desc,npm asc,cak_prestasi");
        echo json_encode($data);
    }elseif($op == "delete"){
        
        if(in_array($table, $def_table)){
            if($table == $def_table[0]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi" or $match)){
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[0], array("id_prestasi" => $id))){
                        echo "true";
                    }else{
                        echo $_SESSION['err_message'];
                    }
                    
                }
		} else {echo 'Anda tidak diperbolehkan melakukan aksi ini.';}
                
            }else if($table == $def_table[1]){
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")){
                if(is_null($id) == FALSE){
                    
                    if(db_delete($def_table[1], array("id_bid_prestasi" => $id))){
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
