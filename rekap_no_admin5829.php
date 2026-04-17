<?php
ini_set('display_errors', 1);
@session_start();
?>
<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Rekap</title>
	<style type="text/css">
		.container{
			width: 980px;
			margin: 0 auto;
		}

		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}

		table tr td, table tr th{
			padding: 0 10px 0 10px;
			vertical-align: text-top;
		}

		table tr td:nth-child(2){
			text-align: center;
			
		}

		.left{
			text-align: left !important;
		}

		.printbreak {
			page-break-after: always;
		}

		@page{size:auto; margin-bottom:5mm;}
	</style>
	<script>
// 		window.print();
	</script>
</head>
<body>
	<?php
		define("BASE_PATH", true);
		include "lib/db_lib.php";
		
// 		session_start();
		
// 		var_dump($_SESSION);

// 		if($_SESSION['login'] != 1 or !in_array($_SESSION['logged_as'], array("super_admin","ddi"))){
//         if(!in_array($_SESSION['logged_as'], array("super_admin","ddi"))){
// 			exit("Maaf, anda tidak bisa mengakses halaman ini.");
// 			die();
// 		}

		if($_GET['op'] == "penyakit_mhs"):
	?>
			
			<div class="container">
			<?php
                header("Content-type: application/vnd-ms-excel");
				 header("Content-Disposition: attachment; filename=PPM2018-Kelompok-Mahasiswa.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
            ?>
				<p align="center"><b>REKAP PENYAKIT MAHASISWA</b></p><br />
				<?php
					$ruang = db_read("select id_ruang, max_kuota,nama_ruang from vdivroom where id_acara='".cleanchar($_GET['acara'])."' and id_thn='".get_id_active_year()."'");
					$msg = NULL;
					foreach ($ruang as $k_ruang => $v_ruang) {
						$id = cleanchar($_GET['acara']);
						$npm = db_read("SELECT npm FROM vjadwalperson WHERE id_acara = ".$id." AND id_ruang = ".$v_ruang['id_ruang']);
						if(count($npm) > 0){
							echo "<div class='printbreak'>";
							echo "<b>Ruang : ".$v_ruang['nama_ruang']."</b><br /><br />";
							echo "<table width='100%'>";
							echo "<thead><tr>
									<th>Nama</th>
									<th>NPM</th>
									<th>Penyakit</th>
								 </tr></thead><tbody>";
							for($i = 0; $i < count($npm); $i++){
								$sql = db_read("SELECT * FROM vpenyakit WHERE npm = '".$npm[$i]['npm']."' AND id_thn = ".get_id_active_year()." order by kelompok asc");
								if(count($sql) > 1){
									$v = null;
									foreach ($sql as $item) {
										if($v == $item['npm']){
											echo "<tr>
												<td>$item[nama_penyakit]</td>
											  </tr>";
										}else{
											$v = $item['npm'];
											echo "<tr>
													<td rowspan='".count($sql)."'>$item[nama]</td>
													<td rowspan='".count($sql)."'>$item[npm]</td>
													<td>$item[nama_penyakit]</td>
												</tr>";
										}
									}
								}elseif(count($sql) == 1){
									
									foreach ($sql as $item){
										echo "<tr>
												<td>$item[nama]</td>
												<td>$item[npm]</td>
												<td>$item[nama_penyakit]</td>
											  </tr>";
									}
								}
							}

							echo "</tbody></table></div>";
						}
					}
				?>
			</div>

        	<?php
        		elseif($_GET['op'] == "rekap_pendaftar"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
                                    // $query = "select upper(mahasiswa.nama) as nama, mahasiswa.npm, upper(mahasiswa.slta_asal) as slta_asal, mahasiswa.hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok, vsesi_oh.file_kehadiran as oh from mahasiswa LEFT JOIN vsesi_oh ON vsesi_oh.npm = mahasiswa.npm where mahasiswa.konfirmasi='Y' and mahasiswa.id_thn=".$thn." and mahasiswa.id_kelompok =".$kel." order by id_kelompok asc";
                                    $query = "SELECT mahasiswa.email, UPPER(mahasiswa.nama) AS nama, mahasiswa.npm, UPPER(mahasiswa.slta_asal) AS slta_asal, mahasiswa.hp, kelompok.nama_kelompok, agama.nama_agama, prodi.nama_prodi, GROUP_CONCAT(penyakit.nama_penyakit) AS penyakit, keluarga.telepon as kontak_wali FROM mahasiswa LEFT JOIN kelompok ON kelompok.id = mahasiswa.id_kelompok LEFT JOIN keluarga ON keluarga.npm = mahasiswa.npm LEFT JOIN agama ON agama.id_agama = mahasiswa.id_agama LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi LEFT JOIN penyakit_mahasiswa ON penyakit_mahasiswa.npm = mahasiswa.npm LEFT JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np WHERE mahasiswa.konfirmasi = 'Y' AND mahasiswa.id_thn = $thn AND mahasiswa.id_kelompok = $kel GROUP BY mahasiswa.npm ORDER BY id_kelompok ASC";
        						}else{
        				// 			$query = "select upper(mahasiswa.nama) as nama, mahasiswa.npm, upper(mahasiswa.slta_asal) as slta_asal, mahasiswa.hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok, vsesi_oh.file_kehadiran as oh from mahasiswa LEFT JOIN vsesi_oh ON vsesi_oh.npm = mahasiswa.npm where mahasiswa.konfirmasi='Y' and mahasiswa.id_thn=".$thn." and mahasiswa.id_kelompok is not null  order by id_kelompok asc";
        				        // $query = "SELECT mahasiswa.email, UPPER(mahasiswa.nama) AS nama, mahasiswa.npm, UPPER(mahasiswa.slta_asal) AS slta_asal, mahasiswa.hp, kelompok.nama_kelompok, agama.nama_agama, prodi.nama_prodi, GROUP_CONCAT(penyakit.nama_penyakit) AS penyakit, keluarga.telepon as kontak_wali FROM mahasiswa LEFT JOIN kelompok ON kelompok.id = mahasiswa.id_kelompok LEFT JOIN keluarga ON keluarga.npm = mahasiswa.npm LEFT JOIN agama ON agama.id_agama = mahasiswa.id_agama LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi LEFT JOIN penyakit_mahasiswa ON penyakit_mahasiswa.npm = mahasiswa.npm LEFT JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np WHERE mahasiswa.konfirmasi = 'Y' AND mahasiswa.id_thn = $thn AND mahasiswa.id_kelompok IS NOT NULL GROUP BY mahasiswa.npm ORDER BY id_kelompok ASC";
        				        
        				        // kelompok mentor yang bagi sendiri, manual
        				        
        				        $query = "SELECT mahasiswa.email, UPPER(mahasiswa.nama) AS nama, mahasiswa.npm, UPPER(mahasiswa.slta_asal) AS slta_asal, mahasiswa.hp, kelompok.nama_kelompok, agama.nama_agama, prodi.nama_prodi, GROUP_CONCAT(penyakit.nama_penyakit) AS penyakit, keluarga.telepon as kontak_wali FROM mahasiswa LEFT JOIN kelompok ON kelompok.id = mahasiswa.id_kelompok LEFT JOIN keluarga ON keluarga.npm = mahasiswa.npm LEFT JOIN agama ON agama.id_agama = mahasiswa.id_agama LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi LEFT JOIN penyakit_mahasiswa ON penyakit_mahasiswa.npm = mahasiswa.npm LEFT JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np WHERE mahasiswa.konfirmasi = 'Y' AND mahasiswa.id_thn = $thn GROUP BY mahasiswa.npm ORDER BY id_prodi ASC";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        									    <th>No</th>
        										<th>Kelompok</th>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Prodi</th>
        										<th>Asal<br/>Sekolah</th>
        										<th>Kontak</th>
        										<th>Riwayat<br/>Penyakit</th>
        										<th>Agama</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							$no_urut_di_kel = 1;
        							foreach ($sql as $item=>$value){
        								// if($value['kelompok']!=$nm_kel){
        								// 	$kel = $value['kelompok'];
        								// 	$nm_kel = $value['kelompok'];
        								// } else {
        								// 	$kel = "";
        								// }
        								// if($value['oh']==null){
        								// 	$oh = 'belum';
        								// } else {
        								// 	$oh = "Sudah konfirmasi";
        								// }
        								
        								// asumsi per kelompok 40 
        								// if ($no_urut_di_kel > 40) {
        								//     $no_urut_di_kel = 1;
        								// }
        								
        								
        								echo "
        								    <tr>
        								        <td>".$no_urut_di_kel."</td>
        										<td>".$value['nama_kelompok']."</td>
        										<td class=\"left\">".$value['nama']."</td>
        										<td>".$value['npm']."</td>
        										<td>".$value['nama_prodi']."</td>
        										<td>".$value['slta_asal']."</td>
        										<td>".$value['hp']." / <br/>".$value['email']." / Wali : <br/>".$value['kontak_wali']."</td>
        										<td>".$value['penyakit']."</td>
        										<td>".$value['nama_agama']."</td>";
        									echo "</tr>";
        									
        								$no_urut_di_kel++;
        						}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			
        			<?php
        		elseif($_GET['op'] == "rekap_pendaftar_all"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						
        						$query = "SELECT mahasiswa.email, UPPER(mahasiswa.nama) AS nama, mahasiswa.npm, UPPER(mahasiswa.slta_asal) AS slta_asal, mahasiswa.hp, kelompok.nama_kelompok, agama.nama_agama, prodi.nama_prodi, GROUP_CONCAT(penyakit.nama_penyakit) AS penyakit, keluarga.telepon as kontak_wali FROM mahasiswa LEFT JOIN kelompok ON kelompok.id = mahasiswa.id_kelompok LEFT JOIN keluarga ON keluarga.npm = mahasiswa.npm LEFT JOIN agama ON agama.id_agama = mahasiswa.id_agama LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi LEFT JOIN penyakit_mahasiswa ON penyakit_mahasiswa.npm = mahasiswa.npm LEFT JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np WHERE mahasiswa.id_thn = $thn GROUP BY mahasiswa.npm ORDER BY id_prodi ASC";
        						
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        									    <th>No</th>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Prodi</th>
        										<th>Asal<br/>Sekolah</th>
        										<th>Kontak</th>
        										<th>Riwayat<br/>Penyakit</th>
        										<th>Agama</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							$no_urut_di_kel = 1;
        							foreach ($sql as $item=>$value){
        								// if($value['kelompok']!=$nm_kel){
        								// 	$kel = $value['kelompok'];
        								// 	$nm_kel = $value['kelompok'];
        								// } else {
        								// 	$kel = "";
        								// }
        								// if($value['oh']==null){
        								// 	$oh = 'belum';
        								// } else {
        								// 	$oh = "Sudah konfirmasi";
        								// }
        								
        								// asumsi per kelompok 40 
        								// if ($no_urut_di_kel > 40) {
        								//     $no_urut_di_kel = 1;
        								// }
        								
        								
        								echo "
        								    <tr>
        								        <td>".$no_urut_di_kel."</td>
        										<td class=\"left\">".$value['nama']."</td>
        										<td>".$value['npm']."</td>
        										<td>".$value['nama_prodi']."</td>
        										<td>".$value['slta_asal']."</td>
        										<td>".$value['hp']." / <br/>".$value['email']." / Wali : <br/>".$value['kontak_wali']."</td>
        										<td>".$value['penyakit']."</td>
        										<td>".$value['nama_agama']."</td>";
        									echo "</tr>";
        									
        								$no_urut_di_kel++;
        						}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			
        			<?php
        		        elseif($_GET['op'] == "rekap_prodi"):
        	        ?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA<br />(PER PRODI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$prodi = (isset($_GET['prodi']))? cleanchar($_GET['kel']):null;
        						if(!is_null($prodi)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select prodi.nama_prodi from prodi prodi where prodi.id = mahasiswa.id_prodi) as prodi from mahasiswa where konfirmasi='Y' and id_thn=".$thn." and id_prodi =".$prodi." order by id_prodi asc";
        						}else{
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select prodi.nama_prodi from prodi prodi where prodi.id = mahasiswa.id_prodi) as prodi from mahasiswa where konfirmasi='Y' and id_thn=".$thn." order by id_prodi asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Prodi</th>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_prodi = "";
        							$prodi = "";
        							foreach ($sql as $item=>$value){
        								if($value['prodi']!=$nm_prodi){
        									$prodi = $value['prodi'];
        									$nm_prodi = $value['prodi'];
        								} else {
        									$prodi = "";
        								}
        								echo "
        								    <tr>
        										<td>".$prodi."</td>
        										<td class=\"left\">".$value['nama']."</td>
        										<td>".$value['npm']."</td>
        										<td>".$value['slta_asal']."</td>
        										<td>(".$value['hp'].")</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			
        			<?php
        		        elseif($_GET['op'] == "rekap_jumlah_prodi_fakultas"):
        	        ?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP JUMLAH MAHASISWA<br />(PER PRODI DAN FAKULTAS)</b></p>
        					<?php
        					
        					
        					
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					
        					$query_fakultas = "
        					SELECT
                                COUNT(DISTINCT(potensi.npm)) AS jumlah_mhs,
                                fakultas.nama_fakultas
                            FROM
                                `mahasiswa`
                            LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi
                            LEFT JOIN fakultas ON fakultas.id = prodi.id_fakultas
                            JOIN potensi ON potensi.npm = mahasiswa.npm
                            WHERE
                                mahasiswa.id_thn = $thn AND mahasiswa.konfirmasi = 'Y'
                            GROUP BY
                                fakultas.id
                            ORDER BY
                                `fakultas`.`nama_fakultas`,
                                prodi.nama_prodi ASC;
        					";
        					
        					$query = "
        					SELECT
                                COUNT(distinct(potensi.npm)) AS jumlah_mhs,
                                mahasiswa.id_prodi,
                                prodi.nama_prodi,
                                fakultas.nama_fakultas
                            FROM
                                `mahasiswa` 
                            LEFT JOIN prodi ON prodi.id = mahasiswa.id_prodi
                            LEFT JOIN fakultas ON fakultas.id = prodi.id_fakultas
                            JOIN potensi ON potensi.npm = mahasiswa.npm
                            
                            WHERE
                                mahasiswa.id_thn = $thn AND mahasiswa.konfirmasi = 'Y'
                            GROUP BY
                                mahasiswa.id_prodi  
                            ORDER BY `fakultas`.`nama_fakultas`, prodi.nama_prodi ASC;
        					";
        					
        					    $sql_fak = db_read($query_fakultas);
        					    $jml_all = 0;
        						if(count($sql_fak) > 0){
        						    echo "<h2>Per Fakultas</h2>";
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        									    <th>Fakultas</th>
        										<th>Jumlah Mahasiswa</th>
        									</tr>
        									</thead>
        									<tbody>";
        							foreach ($sql_fak as $item=>$value){
        							    $jml_all+= $value['jumlah_mhs'];
        							    
        								echo "
        								    <tr>
        										<td>".$value['nama_fakultas']."</td>
        										<td style='text-align:center'>".$value['jumlah_mhs']."</td>
        										
        									</tr>";
        							}
        							
        							echo "
        								    <tr style='font-weight:bolder'>
        										<td>Total Semua</td>
        										<td style='text-align:center'>".$jml_all."</td>
        										
        									</tr>";
        									
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        						
        						echo '<hr/>';
        					
        						$sql = db_read($query);
        						if(count($sql) > 0){
        						    echo "<h2>Per Prodi</h2>";
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        									    <th>Fakultas</th>
        										<th>Prodi</th>
        										<th>Jumlah Mahasiswa</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_prodi = "";
        							$prodi = "";
        							foreach ($sql as $item=>$value){
        								echo "
        								    <tr>
        										<td>".$value['nama_fakultas']."</td>
        										<td  style='text-align:left'>".$value['nama_prodi']."</td>
        										<td style='text-align:center'>".$value['jumlah_mhs']."</td>
        										
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			
        			<?php
        		        elseif($_GET['op'] == "rekap_jumlah_penyakit"):
        	        ?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP RIWAYAT PENYAKIT MAHASISWA</b></p>
        					<?php
        					
        					
        					
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					
        					$query = "
        					SELECT
                                COUNT(
                                    DISTINCT(penyakit_mahasiswa.id_penyakit)
                                ) AS jumlah,
                                penyakit.nama_penyakit
                            FROM
                                mahasiswa
                            JOIN penyakit_mahasiswa ON penyakit_mahasiswa.npm = mahasiswa.npm
                            JOIN penyakit ON penyakit.id_np = penyakit_mahasiswa.id_np
                            WHERE
                                mahasiswa.id_thn = $thn  AND mahasiswa.konfirmasi = 'Y'
                            GROUP BY 
                                penyakit.id_np
                            ORDER BY
                                jumlah DESC;

        					";
        					
        						$sql = db_read($query);
        						$no = 0;
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        									    <th>No.</th>
        										<th>Penyakit</th>
        										<th>Jumlah Mahasiswa</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_prodi = "";
        							$prodi = "";
        							foreach ($sql as $item=>$value){
        							    $no++;
        								echo "
        								    <tr>
        								        <td style='text-align:center'>".$no."</td>
        										<td style='text-align:left'>".$value['nama_penyakit']."</td>
        										<td style='text-align:center'>".$value['jumlah']."</td>
        										
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			
        	<?php
        		elseif($_GET['op'] == "rekap_kalsel"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA HULU SUNGAI UTARA<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='22' and id_kab='199' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
        						}else{
        							
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='22' and id_kab='199' and id_thn=".$thn." order by id_kelompok asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							foreach ($sql as $item=>$value){
        								if($value['kelompok']!=$nm_kel){
        									$kel = $value['kelompok'];
        									$nm_kel = $value['kelompok'];
        								} else {
        									$kel = "";
        								}
        								echo "
        								    <tr>
        										<td class=\"left\">$value[nama]</td>
        										<td>$value[npm]</td>
        										<td>$value[slta_asal]</td>
        										<td>$value[hp]</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA KALIMANTAN SELATAN<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='22' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
        						}else{
        							
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='22' and id_thn=".$thn." order by id_kelompok asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							foreach ($sql as $item=>$value){
        								if($value['kelompok']!=$nm_kel){
        									$kel = $value['kelompok'];
        									$nm_kel = $value['kelompok'];
        								} else {
        									$kel = "";
        								}
        								echo "
        								    <tr>
        										<td class=\"left\">$value[nama]</td>
        										<td>$value[npm]</td>
        										<td>$value[slta_asal]</td>
        										<td>$value[hp]</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
            <?php
        		elseif($_GET['op'] == "rekap_kebumen"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA KEBUMEN<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='13' and id_kab='150' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
        						}else{
        							
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='13' and id_kab='150' and id_thn=".$thn." order by id_kelompok asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							foreach ($sql as $item=>$value){
        								if($value['kelompok']!=$nm_kel){
        									$kel = $value['kelompok'];
        									$nm_kel = $value['kelompok'];
        								} else {
        									$kel = "";
        								}
        								echo "
        								    <tr>
        										<td class=\"left\">$value[nama]</td>
        										<td>$value[npm]</td>
        										<td>$value[slta_asal]</td>
        										<td>$value[hp]</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        <?php
        elseif($_GET['op'] == "rekap_rejang"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        					<p align="center"><b>REKAP DATA MAHASISWA REJANG LEBONG<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='7' and id_kab='41' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
        						}else{
        							
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where id_daerah='7' and id_kab='41' and id_thn=".$thn." order by id_kelompok asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							foreach ($sql as $item=>$value){
        								if($value['kelompok']!=$nm_kel){
        									$kel = $value['kelompok'];
        									$nm_kel = $value['kelompok'];
        								} else {
        									$kel = "";
        								}
        								echo "
        								    <tr>
        										<td class=\"left\">$value[nama]</td>
        										<td>$value[npm]</td>
        										<td>$value[slta_asal]</td>
        										<td>$value[hp]</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
        <?php
        		elseif($_GET['op'] == "rekap_daerah"):
        	?>
        			<div class="printbreak">
        				<div class="container">
        				    <p><b>TAMPILKAN DATA MAHASISWA BERDASARKAN DAERAH</b></p>
                            <div class="form-group">
                                <label for="daerah">Asal Daerah</label><br>
                                <select name="daerah" class="form-control" data-toggle="tooltip" data-placement="bottom">
                                <option value="">-- Pilih --</option>
                                        <?php
                                            $daerah = db_read("select * from daerah where status='Y' order by nama_daerah asc");
                                            foreach($daerah as $val){
                                                echo "<option value='".$val['id_daerah']."'>".$val['nama_daerah']."</option>";
                                            }
                                        ?>
                                </select>
                            </div>
        					<p align="center"><b>REKAP DATA MAHASISWA PER-DAERAH<br />(SUDAH KONFIRMASI)</b></p>
        					<?php
        					$option = $_POST['daerah'];
        					$val['id_daerah'];
        					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
        					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
        						if(!is_null($kel)){
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_daerah='1' and id_negara='101' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
        						}else{
        							
        							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_daerah='1' and id_negara='101' and id_thn=".$thn." order by id_kelompok asc";
        						}
        						$sql = db_read($query);
        						if(count($sql) > 0){
        							echo "<table width='100%'>
        									<thead>
        									<tr align='center'>
        										<th>Kelompok</th>
        										<th>Nama</th>
        										<th>NPM</th>
        										<th>Asal Sekolah</th>
        										<th>No. Telepon</th>
        									</tr>
        									</thead>
        									<tbody>";
        						    $nm_kel = "";
        							$kel = "";
        							foreach ($sql as $item=>$value){
        								if($value['kelompok']!=$nm_kel){
        									$kel = $value['kelompok'];
        									$nm_kel = $value['kelompok'];
        								} else {
        									$kel = "";
        								}
        								echo "
        								    <tr>
        										<td>$kel</td>
        										<td class=\"left\">$value[nama]</td>
        										<td>$value[npm]</td>
        										<td>$value[slta_asal]</td>
        										<td>$value[hp]</td>
        									</tr>";
        							}
        							echo "</tbody></table>";
        						}else{
        							echo "<b>Belum ada data.</b>";
        						}
        					?>
        				</div>
        			</div>
		
		<?php
		elseif($_GET['op'] == "belum_konfirmasi"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA MAHASISWA<br />(BELUM KONFIRMASI)</b></p>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='N' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='N' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>Asal Sekolah</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								echo "<tr>
										<td>$kel</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[slta_asal]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
    	<?php
		elseif($_GET['op'] == "rekap_prestasi"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA PRESTASI MAHASISWA<br />(SUDAH KONFIRMASI)</b></p>
					 <?php
                        $sql = db_read("select * from vprestasi where id_thn='".get_year(get_active_year())."' order by nama_bid asc");
                        echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Bidang Prestasi</th>
										<th>NPM</th>
										<th>Nama Prestasi</th>
										<th>Cakupan Prestasi</th>
									</tr>
									</thead>
									<tbody>";
						$nm_kel = "";
						$kel = "";
									
                        foreach ($sql as $key => $value) {
                            if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
                            echo "<tr align='left'>
                                    <td>".$value['nama_bid']."</td>
                                    <td>".$value['npm']."</td>
                                    <td>".$value['nama_prestasi']."</td>
                                    <td>".$value['cak_prestasi']."</td>
                                  </tr>";
                        }
                        echo "</tbody></table>";
                    ?>
				</div>
			</div>
	<?php
		elseif($_GET['op'] == "rekap_penyakit"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>DATA RIWAYAT PENYAKIT MAHASISWA<br /></b></p>
					 <?php
                        $sql = db_read("select * from vpenyakit where id_thn='".get_year(get_active_year())."' order by nama_penyakit asc");
                        echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>Nomor Mahasiswa</th>
										<th>Nama Peserta</th>
										<th>Riwayat Penyakit</th>
									</tr>
									</thead>
									<tbody>";
						$nm_kel = "";
						$kel = "";
									
                        foreach ($sql as $key => $value) {
                            if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
                            echo "<tr align='left'>
									<td>$kel</td>
                                    <td>".$value['npm']."</td>
                                    <td>".$value['nama']."</td>
                                    <td>".$value['nama_penyakit']."</td>
                                  </tr>";
                        }
                        echo "</tbody></table>";
                    ?>
				</div>
			</div>
	<?php
		elseif($_GET['op'] == "pesenan_ikhsan"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA WANITA MAHASISWA<br />(SUDAH KONFIRMASI)</b></p>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and jk='perempuan' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>Asal Sekolah</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								echo "<tr>
										<td>$kel</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[slta_asal]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
    <?php
		elseif($_GET['op'] == "rekap_agama"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(SUDAH KONFIRMASI)</b></p>
					    <div class="row">
					       <table width='100%'>
									<thead>
									<tr align='left'>
										<th>AGAMA</th>
										<th>Islam</th>
										<th>Hindu</th>
										<th>Kristen</th>
										<th>Katholik</th>
										<th>Budha</th>
										<th>Lainnya</th>
										<th>Belum Isi Data Agama</th>
									</tr>
									</thead>
									<tbody>
									    <tr>
									        <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        <td>            					
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and id_thn='".get_year(get_active_year())."'"));?></b><br>
            					            - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
            					            - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
            					            - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
            					            </td>
									        <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        <td>
									       	Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        
									        <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									        
									         <td>
									        Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama is null and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama is null and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Wanita = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama is null and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					                        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and and id_agama is null and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br>
									        </td>
									    </tr>
						            </tbody>
						        </table><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>Nomor Mahasiswa</th>
										<th>Agama</th>
										<th>Nama</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
								echo "<tr>
										<td>$kel</td>
										<td>$value[npm]</td>
										<td>$agama</td>
										<td class=\"left\">$value[nama]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
				    <?php
		elseif($_GET['op'] == "rekap_agama_kepercayaan"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(KEPERCAYAAN)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='6' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='6' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='6' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
			<?php
		elseif($_GET['op'] == "rekap_agama_islam"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(ISLAM)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='1' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='1' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='1' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
				    <?php
		elseif($_GET['op'] == "rekap_agama_budha"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(BUDHA)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='5' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='5' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='5' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
				    <?php
		elseif($_GET['op'] == "rekap_agama_katholik"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(KATHOLIK)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='4' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='4' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='4' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
			    <?php
		elseif($_GET['op'] == "rekap_agama_kristen"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(KRISTEN)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='3' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='3' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='3' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
	    <?php
		elseif($_GET['op'] == "rekap_agama_hindu"):
	?>
			<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA AGAMA<br />(HINDU)</b></p>
					    <div class="row">
							Total = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Laki-laki = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='laki-laki' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Perempuan = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='perempuan' and id_thn='".get_year(get_active_year())."'"));?></b><br>
					        - Lainnya = <b><?php echo count(db_read("select npm from mahasiswa where konfirmasi='Y' and id_agama='2' and jk='' and id_thn='".get_year(get_active_year())."'"));?></b><br><br>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
					$no = 0;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='2' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, id_agama, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_agama='2' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>No.</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								switch ($value['id_agama']) {
                                    case "1":
                                        $agama = "Islam";
                                        break;
                                    case "2":
                                        $agama = "Hindu";
                                        break;
                                    case "3":
                                        $agama = "Kristen";
                                        break;
                                    case "4":
                                        $agama = "Katholik";
                                        break;
                                    case "5":
                                        $agama = "Budha";
                                        break;
                                    default:
                                        $agama = "Lainnya";
                                }
                                $no++;
								echo "<tr>
										<td>$kel</td>
										<td>$no</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
	<?php
	elseif($_GET['op'] == "rekap_pendaftar_perruangan"):
	?>
		<div class="printbreak">
				<div class="container">
					<p align="center"><b>REKAP DATA MAHASISWA<br />(SUDAH KONFIRMASI)</b></p>
					<?php
					$thn = (isset($_GET['thn']))? cleanchar($_GET['thn']):get_year(get_active_year());
					$kel = (isset($_GET['kel']))? cleanchar($_GET['kel']):null;
						if(!is_null($kel)){
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_thn=".$thn." and id_kelompok =".$kel." order by id_kelompok asc";
						}else{
							
							$query = "select upper(nama) as nama, npm, upper(slta_asal) as slta_asal, hp,(select kel.nama_kelompok from kelompok kel where kel.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where konfirmasi='Y' and id_thn=".$thn." order by id_kelompok asc";
						}
						$sql = db_read($query);
						if(count($sql) > 0){
							echo "<table width='100%'>
									<thead>
									<tr align='center'>
										<th>Kelompok</th>
										<th>Nama</th>
										<th>NPM</th>
										<th>Asal Sekolah</th>
										<th>No. Telepon</th>
									</tr>
									</thead>
									<tbody>";
						    $nm_kel = "";
							$kel = "";
							foreach ($sql as $item=>$value){
								if($value['kelompok']!=$nm_kel){
									$kel = $value['kelompok'];
									$nm_kel = $value['kelompok'];
								} else {
									$kel = "";
								}
								echo "<tr>
										<td>$kel</td>
										<td class=\"left\">$value[nama]</td>
										<td>$value[npm]</td>
										<td>$value[slta_asal]</td>
										<td>$value[hp]</td>
									</tr>";
							}
							echo "</tbody></table>";
						}else{
							echo "<b>Belum ada data.</b>";
						}
					?>
				</div>
			</div>
	
	<?php
	endif;
	?>
</body>
</html>
