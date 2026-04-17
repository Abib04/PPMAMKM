<?php
$cek_potensi = ($_SESSION['cek_potensi']>0)? TRUE : cek_potensi();
if($cek_potensi){
?>
<style>
#jadwal_tabel tr td:nth-child(2){
	color:Green;
	font-weight: 600;
	text-align : center;
}
</style>
<?php 
$mhs = db_read("select vkelompok.*, mahasiswa.* from mahasiswa join vkelompok on mahasiswa.id_kelompok = vkelompok.id_kelompok and mahasiswa.npm='".$_SESSION['username']."'");
$tahun = get_session('mhs_thn');
$conf = ($_SESSION['mhs_confirm'])? TRUE : get_confirm();
?>
<?php echo $conf ? '':'<h3 style="color:red;"><b>Akun Anda Belum Aktif, Silahkan Lakukan Konfirmasi Pendaftaran PPM untuk mendapatkan Kelompok</b></h3>';?>
<h3><b>Kelompok : <?php echo $mhs[0]['nama_kelompok'];?></b></h3>

<p><i><span style="color:red;">Pada Hari Ke-1 sampai ke-3 Peserta Hadir <b>sebelum pukul 06.00 pagi</b> untuk registrasi dan body checking</span></i></p>
<p><i><span style="color:red;">Pada Hari Ke-4 Peserta Hadir <b>sebelum pukul 09.00 pagi</b> untuk registrasi dan body checking</span></i></p>

<table class="table table-bordered table-hovered">
<table class="table table-bordered  table-hovered" id="jadwal_tabel">
<thead>
<tr><th>Acara</th><th>Tanggal</th><th>Jam</th><th>Tempat</th><th>Kehadiran</th></tr>
</thead>
<tbody>
<?php
//view vjadwalpersonsesi
$acara_method1 = db_read("SELECT vacara.nama_acara,vacara.id_acara, vacara.id_acara_thn,vjadwalpersonsesi.tanggal,vjadwalpersonsesi.jam_mulai,vjadwalpersonsesi.nama_ruang 
FROM vacara 
LEFT JOIN vjadwalpersonsesi ON vacara.id_acara = vjadwalpersonsesi.id_acara and vjadwalpersonsesi.npm = '".$_SESSION['username']."' 
where (NOT (vacara.id_acara in ('3','4'))) and vacara.id_thn=".$tahun." ORDER BY vacara.`tanggal_mulai`,vjadwalpersonsesi.tanggal");
$dt_acara_method1 = array();
foreach($acara_method1 as $ky_m1 => $val_m1){
    $dt_acara_method1[$val_m1['id_acara']]['tanggal'] = $val_m1['tanggal'];
    $dt_acara_method1[$val_m1['id_acara']]['jam_mulai'] = $val_m1['jam_mulai'];
    $dt_acara_method1[$val_m1['id_acara']]['nama_ruang'] = $val_m1['nama_ruang'];
    $dt_acara_method1[$val_m1['id_acara']]['id_acara_thn'] = $val_m1['id_acara_thn'];
}

//view vjadwalbyfakultas // method 2 dan 4
$acara_method2 = db_read("SELECT vacara.nama_acara,vacara.id_acara, vacara.id_acara_thn,vjadwalbyfakultas.tgl_mulai as tanggal,vjadwalbyfakultas.jam_mulai,vjadwalbyfakultas.nama_ruang 
FROM vacara LEFT JOIN vjadwalbyfakultas ON vacara.id_acara = vjadwalbyfakultas.id_acara and vjadwalbyfakultas.npm = '".$_SESSION['username']."'
where (NOT (vacara.id_acara in ('3','4'))) and vacara.id_thn=".$tahun." ORDER BY vacara.`tanggal_mulai`,vjadwalbyfakultas.tgl_mulai");
$dt_acara_method2 = array();
foreach($acara_method2 as $ky_m2 => $val_m2){
    $dt_acara_method2[$val_m2['id_acara']]['tanggal'] = $val_m2['tanggal'];
    $dt_acara_method2[$val_m2['id_acara']]['jam_mulai'] = $val_m2['jam_mulai'];
    $dt_acara_method2[$val_m2['id_acara']]['nama_ruang'] = $val_m2['nama_ruang'];
    $dt_acara_method2[$val_m2['id_acara']]['id_acara_thn'] = $val_m2['id_acara_thn'];
}


$tbl_acara = array();

$acara = db_read("SELECT vacara.nama_acara,vacara.id_acara, vacara.id_acara_thn,vjadwalperson.tanggal,vjadwalperson.jam_mulai,vjadwalperson.nama_ruang FROM vacara 
LEFT JOIN vjadwalperson ON vacara.id_acara = vjadwalperson.id_acara and vjadwalperson.npm = '".$_SESSION['username']."' where (NOT (vacara.id_acara in ('3','4'))) and vacara.id_thn=".$tahun." 
ORDER BY vacara.`tanggal_mulai`,vjadwalperson.tanggal");
$idx_tbl_acara = 0;
foreach($acara as $ky => $val){
    
    //Tanggal //Jam
    $tbl_acara[$idx_tbl_acara]['tanggal']       = $val['tanggal'];
    $tbl_acara[$idx_tbl_acara]['jam_mulai']     = $val['jam_mulai'];
    $tbl_acara[$idx_tbl_acara]['nama_acara']    = $val['nama_acara'];
    $tbl_acara[$idx_tbl_acara]['nama_ruang']    = $val['nama_ruang'];
    $tbl_acara[$idx_tbl_acara]['st']            = 'fa-times-circle';
    $tbl_acara[$idx_tbl_acara]['cl']           = 'red';

	// var_dump(check_presensi(null));
    
    if($val['tanggal'] == '' or is_null($val['tanggal'])){
        //Cek data method 1 juga
	    if(!empty($dt_acara_method1[$val['id_acara']]['tanggal'])){
	        if($dt_acara_method1[$val['id_acara']]['tanggal'] == '' or is_null($dt_acara_method1[$val['id_acara']]['tanggal'])){
	            //SKIP
	        }else{
	           if(!check_presensi($val['id_acara'])){
	            // if(check_presensi($val['id_acara'])){
				// if(false) {
        			//SKIP
        		} else {
        			$tbl_acara[$idx_tbl_acara]['st']    = 'fa-check-circle';
        			$tbl_acara[$idx_tbl_acara]['cl']   = 'green';
        		}
        		
        		$tbl_acara[$idx_tbl_acara]['tanggal']   = $dt_acara_method1[$val['id_acara']]['tanggal'];
        		$tbl_acara[$idx_tbl_acara]['jam_mulai'] = $dt_acara_method1[$val['id_acara']]['jam_mulai'];
        		$tbl_acara[$idx_tbl_acara]['nama_ruang']= $dt_acara_method1[$val['id_acara']]['nama_ruang'];
	        }
	    //Cek data method 2 juga
	    }else if(!empty($dt_acara_method2[$val['id_acara']]['tanggal'])){
            if($dt_acara_method2[$val['id_acara']]['tanggal'] == '' or is_null($dt_acara_method2[$val['id_acara']]['tanggal'])){
                //SKIP
            }else{
                if(!check_presensi($val['id_acara'])){
                // if(check_presensi($val['id_acara'])){
        			//SKIP
        		} else {
        			$tbl_acara[$idx_tbl_acara]['st']    = 'fa-check-circle';
        			$tbl_acara[$idx_tbl_acara]['cl']   = 'green';
        		}
        		
        		$tbl_acara[$idx_tbl_acara]['tanggal']   = $dt_acara_method2[$val['id_acara']]['tanggal'];
        		$tbl_acara[$idx_tbl_acara]['jam_mulai'] = $dt_acara_method2[$val['id_acara']]['jam_mulai'];
        		$tbl_acara[$idx_tbl_acara]['nama_ruang']= $dt_acara_method2[$val['id_acara']]['nama_ruang'];
            }
	    }else{
	        //SKIP
	    }
        
    }else{
        if(!check_presensi($val['id_acara'])){
        // if(check_presensi($val['id_acara'])){
			//SKIP
		} else {
			$tbl_acara[$idx_tbl_acara]['st']    = 'fa-check-circle';
			$tbl_acara[$idx_tbl_acara]['cl']   = 'green';
		}
    }
    
    $idx_tbl_acara++;
    
}    


///----------------------- URUTKAN dan TAMPILKAN (update 17 september 2022) --------------------------------------
//array_multisort($tbl_acara, SORT_ASC);
array_multisort(array_column($tbl_acara, 'tanggal'), SORT_ASC,
                array_column($tbl_acara, 'jam_mulai'), SORT_ASC,
                $tbl_acara);
                
foreach($tbl_acara as $idx => $val){
    echo "<tr>";
	echo "<td><b>".$val['nama_acara']."</b></td>";
	echo '<td style="width:100px">'.date_format(date_create($val['tanggal']),"d M Y").'</td>';
	echo '<td>'.$val['jam_mulai'].'</td>';
	
	echo '<td>'.$val['nama_ruang'].'</td>';
	
// 	if ($idx == 0 || $idx == 1  || $idx == 2  || $idx == 8) {
// 		echo '<td>'.$val['nama_ruang'].'</td>';
// 	} else {
// 		if ($idx == 6) {
// 			echo '<td>'.$tbl_acara[1]['nama_ruang'].'</td>';
// 		} else {
// 			echo '<td>Mengikuti Sebelumnya</td>';
// 		}
// 	}
	
	echo '<td style="text-align:center;"><i class="fa '.$val['st'].'" style="font-size:18px;color:'.$val['cl'].'"></i></td>';
	echo "</tr>";
}
///----------------------- AKHIR URUTKAN dan TAMPILKAN --------------------------------------

    
/* YANG LAMA ------------
foreach($acara as $ky => $val){
	// $tempat = db_read("");
	//$det_acara = db_read("select * from vjadwalperson where npm = '".$_SESSION['username']."' and id_acara=".$val['id_acara']." LIMIT 1");
	echo "<tr>";
	echo "<td><b>".$val['nama_acara']."</b></td>";
	
	//MAINTENANCE SELESAI SEPTEMBER 2022
	
	
	if($val['tanggal'] == '' or is_null($val['tanggal'])){
	    //Cek data method 1 juga
	    if(!empty($dt_acara_method1[$val['id_acara']]['tanggal'])){
	        if($dt_acara_method1[$val['id_acara']]['tanggal'] == '' or is_null($dt_acara_method1[$val['id_acara']]['tanggal'])){
	            echo '<td></td><td></td><td></td><td style="text-align:center; width:15px;"><i class="fa fa-times-circle" style="font-size:18px;color:red"></i></td>';
	        }else{
    	        if(!check_presensi($val['id_acara'])){
        			$st = 'fa-times-circle';
        			$cl = 'red';
        		} else {
        			$st = 'fa-check-circle';
        			$cl = 'green';
        		}
        		?>
        		<td style="width:100px"><?php echo date_format(date_create($dt_acara_method1[$val['id_acara']]['tanggal']),"d M Y")?></td>
        		<td><?php echo  $dt_acara_method1[$val['id_acara']]['jam_mulai']; ?></td>
        		<td><?php if ($dt_acara_method1[$val['id_acara']]['id_acara_thn']==34) {echo "Bimbingan KRS dari DAAK<br/> info bimbingan KRS : DAAK.AMIKOM.AC.ID"; } else { echo $dt_acara_method1[$val['id_acara']]['nama_ruang'];}?></td>
        		<td style="text-align:center;"><i class="fa <?php echo $st ?>" style="font-size:18px;color:<?php echo $cl ?>"></i></td>
        		<?php
	        }
	    //Cek data method 2 juga
	    }else if(!empty($dt_acara_method2[$val['id_acara']]['tanggal'])){
            if($dt_acara_method2[$val['id_acara']]['tanggal'] == '' or is_null($dt_acara_method2[$val['id_acara']]['tanggal'])){
                echo '<td></td><td></td><td></td><td style="text-align:center; width:15px;"><i class="fa fa-times-circle" style="font-size:18px;color:red"></i></td>';
            }else{
                if(!check_presensi($val['id_acara'])){
        			$st = 'fa-times-circle';
        			$cl = 'red';
        		} else {
        			$st = 'fa-check-circle';
        			$cl = 'green';
        		}
        		?>
        		<td style="width:100px"><?php echo date_format(date_create($dt_acara_method2[$val['id_acara']]['tanggal']),"d M Y")?></td>
        		<td><?php echo  $dt_acara_method2[$val['id_acara']]['jam_mulai']; ?></td>
        		<td><?php if ($dt_acara_method2[$val['id_acara']]['id_acara_thn']==34) {echo "Bimbingan KRS dari DAAK<br/> info bimbingan KRS : DAAK.AMIKOM.AC.ID"; } else { echo $dt_acara_method2[$val['id_acara']]['nama_ruang'];}?></td>
        		<td style="text-align:center;"><i class="fa <?php echo $st ?>" style="font-size:18px;color:<?php echo $cl ?>"></i></td>
        		<?php
            }
	    }else{
		?>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td style="text-align:center; width:15px;"><i class="fa fa-times-circle" style="font-size:18px;color:red"></i></td>
		<?php
	    }
	} else {
		if(!check_presensi($val['id_acara'])){
			$st = 'fa-times-circle';
			$cl = 'red';
		} else {
			$st = 'fa-check-circle';
			$cl = 'green';
		}
		//foreach($det_acara as $key => $value){
		?>
		<td style="width:100px"><?php echo date_format(date_create($val['tanggal']),"d M Y")?></td>
		<td><?php echo  $val['jam_mulai']; ?></td>
		<td><?php if ($val['id_acara_thn']==34) {echo "Bimbingan KRS dari DAAK<br/> info bimbingan KRS : DAAK.AMIKOM.AC.ID"; } else { echo $val['nama_ruang'];}?></td>
		<td style="text-align:center;"><i class="fa <?php echo $st ?>" style="font-size:18px;color:<?php echo $cl ?>"></i></td>
	<?php 
	    
	}
	//echo '<td>-</td><td>-</td><td>-</td><td style="text-align:center; width:15px;"><i class="fa fa-times-circle" style="font-size:18px;color:red"></i></td>';
	echo '</tr>';
	
}
*/


$inagurasi = db_read("SELECT vacara.nama_acara,vacara.id_acara,vacara.tanggal_mulai as tanggal, sesi.jam_mulai, vdivroom.nama_ruang ,sesi.id_acara_thn FROM `vacara` join vdivroom on vacara.id_acara_thn = vdivroom.id_acara_thn left JOIN sesi on vacara.id_acara_thn = sesi.id_acara_thn WHERE vacara.id_acara = 4 and vacara.id_thn = ".$tahun." LIMIT 1");
foreach ($inagurasi as $key => $value) 
{
	if(check_presensi(4))
	{
		$st = 'fa-check-circle';
		$cl = 'green';
	} else {
		$st = 'fa-times-circle';
		$cl = 'red';
	}
	?>
	<tr>
		<td><b><?php echo $value['nama_acara'];?></b></td>
		<td><?php echo date_format(date_create($value['tanggal']),"d M Y"); ?></td>
		<td><?php echo $value['jam_mulai']; ?></td>
		<td><?php echo $value['nama_ruang']; ?></td>
		<td style="text-align:center; width:15px;"><i class="fa <?php echo $st ?>" style="font-size:18px;color:<?php echo $cl ?>"></i></td>;
	</tr>
	<?php 
}
?>
</tbody>
</table>
<?php
	// $pk = db_read("select * from vsesi_pk WHERE npm='".$_SESSION['username']."'");
	// if(count($pk) > 0){
	// 	if($pk[0]['nama_ruang'] == "lainnya"){
	// 		echo "Maaf, anda tidak mendapatkan ruangan, karena kuota sudah penuh.\n 
	// 		Silahkan datang ke ruang citra 1 untuk info selanjutnya.";
	// 	}else{
	// 		echo "<p><b>Jadwal Pembekalan Karir</b></p>
	// 			<table class='table table-bordered table-hovered'>
	// 				<tr>
	// 					<th>Ruang</th>
	// 					<th>Tanggal</th>
	// 					<th>Waktu</th>
	// 					<th>Keterangan</th>
	// 				</tr>";
	// 				foreach ($pk as $key => $value) {
	// 					echo "<tr>
	// 							<td>".$value['nama_ruang']."</td>
	// 							<td>".$value['tanggal']."</td>
	// 							<td>".substr($value['jam_mulai'],0,5)."-". substr($value['jam_akhir'], 0, 5)."</td>
	// 							<td>".$value['nama_sesi']."</td>
	// 						</tr>";
	// 				}
	// 		echo "</table>";
	// 	}
	// }else{
	// 	echo "<p><b>Jadwal Pembekalan Karir</b></p>";
	// 	echo "Untuk saat ini ruangan belum dibagikan untuk pembekalan karir.";
	// }

?>
<p><i><span style="color:red;">Bagi Anda yang mengisi data penyakit dan menggunakan obat-obatan khusus silahkan dibawa secara mandiri dan ikuti instruksi mentor kalian untuk penggunaan atribut tertentu sebagai penanda</span></i></p>

<p><a href="https://ppm.amikom.ac.id/doc_share/BUKU_PANDUAN_PPM_2024.pdf" class="btn btn-info" target="_blank">Download Buku Panduan</a></p>

<!--<?php //if ($tahun=='15'){?>-->
<!--<iframe src="https://drive.google.com/file/d/1QHj0rDOswg_C80ymN5zy0QXhMOpjAkKG/preview" width="640" height="480" allow="autoplay"></iframe>-->
<!--<?php //} ?>-->

<!--<p><b>Jadwal Open House :</b></p>-->
<!--<p><i><span style="color:red;">Harap membawa undangan yang dapat dicetak di pendaftaran openhouse. dan datang pada tanggal dan jam sesuai jadwal.</span></i></p>-->
<!--<table class="table table-bordered table-hovered">-->
<!--	<tr>-->
<!--		<th>Tempat</th>-->
<!--		<th>Ruang</th>-->
<!--		<th>Tanggal</th>-->
<!--		<th>Jam Mulai</th>-->
<!--		<th>Jam Selesai</th>-->
<!--	</tr>-->
	<?php 
// 		$sql = db_read("select * from vsesi_oh  where npm='".$_SESSION['username']."'");
// 		foreach ($sql as $key => $value) {
// 			echo "	<tr>
// 						<td>Universitas AMIKOM Yogyakarta</td>
// 						<td>".$value['nama_ruang']."</td>
// 						<td>".date_format(date_create($value['tanggal_mulai']),"d M Y")."</td>
// 						<td>".$value['jam_mulai']."</td>
// 						<td>".$value['jam_akhir']."</td>
// 					</tr>";
// 		}
	?>
<!--</table>-->

<?php //echo $conf ? '<a href="'.rules('reg_oh').'" class="btn btn-warning" >Pendaftaran OpenHouse</a>':'<h3 style="color:red;"><b>Silahkan Lakukan Konfirmasi Pendaftaran PPM Terlebih dahulu untuk pendaftaran OPEN HOUSE</b></h3>';?>

<br/><br/>
<p><b>Print CO-CARD PPM</b></p>
<?php 
   // $ppm_conf = db_read("SELECT count(npm) as jumlah, (select config.conf_value FROM config WHERE config.conf_name='kuota_ppm' and config.conf_year=mahasiswa.id_thn) as kuota from mahasiswa where id_thn = ".get_id_active_year());
   // if(($_SESSION['login'] == 1) and in_array($_SESSION['logged_as'], array("super_admin","ddi"))):
?>



<form action="<?= base_url('cocard.php')?>" method="GET">
<div class="form-group">
<input type="submit" name="kirim" value="cetak" class="btn btn-success" /> 
</div>
</form>



<?php
  //  else: 
    //  echo '<div class="form-group">
        //        <input type="submit" disabled="on" name="kirim" value="cetak" class="btn btn-success" /> 
   //         </div>
   //     </form>';
   // endif;
?>

<p><b>Cetak Sertifikat PPM</b></p>
<p><i><code>note</code> sertifikat akan otomatis muncul jika anda sesuai ketentuan mendapatkan bisa sertifikat dan sudah tiba waktu sertifikat dibagikan.</i></p>
<?php if(count(db_read("SELECT * FROM `vsertifikat` WHERE `npm` = '".$_SESSION['username']."'"))>0){?>
<a href="<?= base_url('get_cert.php') ?>" class="btn btn-success btn-xs" target="_blank">Download e-Sertifikat</a> 
	<?php } ?>

<?php
    
}else{
    echo '<h4 style="color:red;"><b>Data Potensi</b> Harus diisi terlebih dahulu minimal satu</h4>';
}
?>
