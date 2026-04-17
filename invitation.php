<?php date_default_timezone_set("Asia/Bangkok"); ?>
<!DOCTYPE html>
<html  moznomarginboxes mozdisallowselectionprint>
<head>
	<title>Kartu Undangan Open House</title>
	<style type="text/css">
		body {
			font-size : 16px !important;
			font-family: "Times New Roman", Times, serif;
			padding:0px;
			margin:0px;
		}
		.container{
			width: 980px;
			margin: 0 auto;
		}
		.header {
			width : 100%;
			margin : 0;
			padding : 0;
			height : 200px;
			/*background : url("resource/assets/images/elemen.png") top center;
			background-size :  100% 100%;
			background-repeat : no-repeat;*/
		}
		.header img {
			width : 250px;
			margin-left: 365px;
			margin-top : 25px;
			z-index: -1000;
		}
		.content{
			width:70%;
			margin-top : 2cm;
			margin-left : auto;
			margin-right : auto;
			font-size:16pt;
			z-index: 100;
		}
		.content p, p b{
			font-size : 16pt;
			line-height : 35px;
			text-align : justify;
		}
		.footer {
			width: 100%;
			margin : 0;
			padding : 0;
			z-index: -100;
			/* -ms-transform: rotate(180deg); /* IE 9 */
    		/* -webkit-transform: rotate(180deg); Chrome, Safari, Opera */
    		/* transform: rotate(180deg); */ 
			background : url("resource/assets/images/elemen2.png") top center no-repeat;
			background-size : 100% 25px;
		}
		.header2 {
			width: 100%;
			margin : 0;
			padding : 0;
		}
		.footer img ,.header2 img{
			width : 100%;
			margin : 0px;
		}
		tr td {
			text- : Bold;
		}
		.center{
			text-align : center !important;
		}
		.capitalize {
    		text-transform: capitalize;
		}
		@media print{
			.container{
				width: 980px;
				margin: none;
			}
			.footer{
				display: block; 
         		position: fixed; 
         		bottom: 0;
				 background : url("resource/assets/images/elemen2.png") top center no-repeat;
				 background-size : 100% 25px;
			}
			.header2{
				display: block; 
				position: fixed; 
				TOP: 0;
			}
		}
		@page{
			size:A4;
			margin: none;
			
		}
	</style>
	<script>
		window.print();
	</script>
</head>
<body>
	<?php 
		define("BASE_PATH", true);
		include "lib/db_lib.php";
		if($_SESSION['login'] == 1){
			exit("Maaf, anda tidak bisa mengakses halaman ini.");
		} 
		$id = isset($_GET['id']) ? cleanchar($_GET['id']) : NULL;
		$npm="";
		$sql = db_read("select nama_kel,mhs as nama,id_kel,npm from vsesi_oh where id_sesi_oh=".$id);
		$npm = (isset($_GET['npm'])) ? $_GET['npm'] : $sql[0]['npm'];
		$id_kel = isset($_GET['id_kel']) ? cleanchar($_GET['id_kel']) : $sql[0]['id_kel'];
		$fullname = (isset($_SESSION['fulname']))? $_SESSION['fulname'] : $sql[0]['nama'] ;
	?>
	<div class="container">
		<?php 
		$sql = db_read("select * from vsesi_oh where npm='".$npm."' limit 1");
		foreach ($sql as $key => $value) {
			if($value['file_kehadiran'] == "hambohh" and (!(in_array($_SESSION['logged_as'],array("super_admin","ddi")) and isset($_GET['undangan'])))){
		
		?>
		<div style="width:80%;margin:30px auto;padding:80px 50px;line-height : 18pt; border-bottom: dashed 1px #000;">
		<table width="100%">
			<tr>
				<td></td>
				<td>
					<center>
					<h3>
					Lembar Pernyataan Kehadiran <br />
					Open House PPM <?php echo get_active_year(); ?><br /> 
						Universitas AMIKOM Yogyakarta
					</h>
					</center>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3"><hr /></td>
			</tr>
			<tr>
				<td colspan="3">
					<p align="justify">
						Saya yang bertanda tangan dibawah ini wali dari mahasiswa yang bernama <?= $fullname ?>, bersedia menghadiri acara Open House di Universitas AMIKOM Yogyakarta sebagai rangkaian acara Penggalian Potensi Mahasiswa <?php echo get_active_year() ?>, pada:
					</p>
				</td>
			</tr>
			<tr>
				<td width="50"></td>
				<td colspan="2">
					<table>
						<tr>
							<td>Hari/Tanggal</td>
							<td>:</td>
							<td>
								<?php
									$jam = db_read("select jam_mulai, jam_akhir, nama_ruang, DATE_FORMAT(tanggal_mulai,'%d %m %Y') as tanggal, DATE_FORMAT(tanggal_mulai,'%w') as hari  from vsesi_oh where id_sesi_oh='".$id."'");
									echo nama_hari_indo($jam[0]['hari']).', '.$jam[0]['tanggal'];
								?>
							</td>
						</tr>
						<tr>
							<td>Jam</td>
							<td>:</td>
							<td>
								<?php
									
									echo substr($jam[0]['jam_mulai'],0,5)."-". substr($jam[0]['jam_akhir'], 0, 5);
								?>
							</td>
						</tr>
						<tr>
							<td>Tempat</td>
							<td>:</td>
							<td>Universitas AMIKOM Yogyakarta</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%">
						<tr>
							<td width="79%" rowspan="4"></td>
							<td>Yogyakarta, <?php echo date("d-m-Y"); ?></td>
						</tr>
						<tr>
							<td>Hormat Saya,</td>
						</tr>
						<tr>
							<td height="80px"></td>
						</tr>
						<tr>
							<td><span class="capitalize"><?php echo $sql[0]['nama_kel'];?></span></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</div>
		
		    
		
		<?php } else {
		
		$_date_open = strtotime('2018-09-03 17:00:00');
		$_now = strtotime(date('Y-m-d H:i:s'));
		//echo $_date_open.'  :  '.$_now;
		if($_date_open > $_now and (!in_array($_SESSION['logged_as'],array("super_admin","ddi")))){
		   die("Maaf belum waktunya mencetak undangan. Undangan dapat dicetak pada tanggal ".date('d-M-Y',$_date_open));
		}
		?>
		<div class="header2">
			<img src="resource/assets/images/ppm_header_2022.png" />
		</div>

		<!-- <div class="header">
			<img src="resource/assets/images/logo.png" />
		</div> -->
		<div class="content">
		<br />
		<br />
		<br />
		<br />
		<p ><b>Yogyakarta, <?= date("d ").nama_bulan_indo((int)date("m")).date(" Y"); ?> </b></p>
		<b>Kepada yth Bapak / Ibu  <span class="capitalize"><?php echo $sql[0]['nama_kel'];?></span><br>
		Wali dari <span class="capitalize">
		<?= ucwords(singkat_nama($fullname))." ( $npm )"; ?></span><br />
		
		</b>
		<p>
		<b>Assalamu'alaikum Wr. Wb.</b>
		</p>
		<p>
		Rektor Universitas AMIKOM Yogyakarta mengundang Bapak/Ibu/Wali mahasiswa baru untuk menghadiri acara Open House Penggalian Potensi Mahasiswa (PPM) <?= get_active_year() ?>, yang akan dilaksanakan pada :
		</p>
		<p ><b>
		<table style="margin-left:50px;">
		<tr>
			<td>Hari/Tanggal</td>
			<td style="width:5px;">:</td>
			<td><?php 
				$jam = db_read("select jam_mulai, jam_akhir, nama_ruang,DATE_FORMAT(tanggal_mulai,'%d %b %Y') as tanggal, DATE_FORMAT(tanggal_mulai,'%w') as hari,DATE_FORMAT(tanggal_mulai,'%d') as tgl,DATE_FORMAT(tanggal_mulai,'%m') as bulan,DATE_FORMAT(tanggal_mulai,'%Y') as tahun,nomor as nomor  from vsesi_oh where id_sesi_oh='".$id."'");
				$tanggal = db_read("select DATE_FORMAT(tanggal_mulai,'%d %b %Y') as tanggal from acara where id_acara='3'");
				echo nama_hari_indo($jam[0]['hari']).', '.$jam[0]['tgl'].' '.nama_bulan_indo((int)$jam[0]['bulan']).' '.$jam[0]['tahun'];
			?></td>
		</tr>
		<tr>
			<td>Pukul</td>
			<td>:</td>
			<td>
			<?php
				echo substr($jam[0]['jam_mulai'],0,5)." - ". substr($jam[0]['jam_akhir'], 0, 5);
			?>
			</td>
		</tr>
		<tr>
			<td>Tempat/Ruang</td>
			<td>:</td>
			<td>[Pertemuan OFFLINE] di Ruang <?= $jam[0]['nama_ruang']; ?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td>Universitas AMIKOM Yogyakarta</td>
		</tr>
		<!--<tr>-->
		<!--	<td>Nomor Undangan</td>-->
		<!--	<td>:</td>-->
		<!--	<td><b><?= $jam[0]['nomor']; ?></b></td>-->
		<!--</tr>-->
		</table>
		</b></p>
		<p>
		Atas perhatian dan kehadiran Bapak/Ibu/Wali mahasiswa, kami ucapkan terima kasih. 
		</p>
		<p></p>
		<p class="left" ><b>Wassalamu'alaikum Wr. Wb.<br /></b></p>
		
		<p class="center" style="margin-bottom: 0px;">Hormat Kami,<br>Rektor <br>Universitas AMIKOM Yogyakarta<br>
		<img src="resource/assets/images/ttdProf.png" alt="ttd" width="150" height="150">
		</p>
				<p class="center"  style="margin-top: 0px;">Prof. Dr. M. Suyanto, MM.</p>
        
        <p>
            <br>
            Catatan :<br>
            1. Undangan berlaku untuk 1 (satu) orang<br>
            <!--2. Pakaian : Bebas, rapi dan sopan.<br />
            2. Diusahakan menggunakan kendaraan umum.<br />
			3. Undangan Harap dibawa saat acara.-->
        </p>
		
        
		</div>
		

		<div class="footer">
			<img src="resource/assets/images/ftr.png" />
		</div>
		    
		<?php }
		}?>
	</div>
</body>
</html>
