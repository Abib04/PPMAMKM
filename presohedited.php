<?php
/**
 * Created by PhpStorm.
 * User: bvrhan
 * Date: 11/05/16
 * Time: 8:50
 */
	define("BASE_PATH", true);
	include "lib/db_lib.php";
    $op = cleanchar($_GET['op']);
	session_start();
	if(($_SESSION['login'] != 1 and ($_SESSION['logged_as'] != "super_admin" or $_SESSION['logged_as'] != "ddi")) or ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa")){
        exit("Maaf, anda tidak bisa mengakses halaman ini.");
    }
?>

<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Cetak Presensi PPM</title>
    <style type="text/css" media="all">

        table tr:nth-child(even) td:last-child{
            text-align: left;
        }

        table tr:nth-child(odd) td:last-child{
            text-align: center;
        }

        .container{
            width: 980px;
            margin: 0 auto;
        }

        table tr td, table tr th{
            padding: 10px;
        }

        table tr td:first-child{
            text-align: center;
        }

        table tr td:nth-child(3){
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .printbreak {
            page-break-after: always;
        }

        @page{size:auto; margin-bottom:5mm;}

    </style>
    <script>
        window.print();
    </script>
</head>
<body>
    <div class="container">
        <?php if($op == "panitia") : ?>
            <?php
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=presensi_panitia.doc");
            ?>
            <center><b>Presensi Panitia Penggalian Potensi Mahasiswa (PPM)</b></center>
            <br />
            <table width="100%">
                <tr style="padding: 20px;">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Tanda Tangan</th>
                </tr>
                <?php
                $no = 1;
                $sql = db_read("select nama,nama_pp from vPanitia order by nama asc");
                foreach ($sql as $key => $value) {
                    echo "<tr>
							<td>".$no."</td>
							<td>".strtoupper($value['nama'])."</td>
							<td>".strtoupper($value['nama_pp'])."</td>
							<td>".$no."</td>
						 </tr>";
                    $no++;
                }
                ?>
            </table>
        <?php elseif ($op == "om") : ?>
            <?php
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename=presensi_om.doc");
            $ruang = db_read("select id_ruang, nama_ruang, max_kuota from vDivRoom where id_acara='2'");
            if(count($ruang) > 0){
                foreach ($ruang as $k_ruang => $v_ruang) {
                    $sql = db_read("select * from vSesi_OM where id_ruang='".$v_ruang['id_ruang']."' AND konfirmasi='Y' order by nama asc");
                    if(count($sql) > 0){
                        $no=1;
                        echo '<div class="printbreak">';
                        echo "<center><b>Presensi PPM Orientasi Mahasiswa</b></center>
                               <br />
                               <br />";
                        echo "<b>Ruang : " . $v_ruang['nama_ruang']."</b><br /><br />";
                        echo "<table width='100%'>
	    						<tr>
	    							<th>No</th>
	    							<th>Nama</th>
	    							<th>NPM</th>
	    							<th>Tanda Tangan</th>
	    						</tr>";

                        foreach ($sql as $key => $value) {
                            echo "<tr>
            							<td>".$no."</td>
            							<td>".strtoupper($value['nama'])."</td>
            							<td>".$value['npm']."</td>
            							<td>".$no."</td>
            						</tr>";

                            $no++;
                        }
                        echo "</table></div>";
                    }
                }
            }
            ?>
        <?php elseif ($op == "pk") : ?>
            <?php
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename=presensi_pk.doc");
            $ruang = db_read("select id_ruang, nama_ruang, max_kuota from vDivRoom where id_acara='1'");
            if(count($ruang) > 0){
                $tanggal = db_read("select DISTINCT(tanggal) from vSesi_PK");

                if(count($tanggal) > 0){
                    foreach($tanggal as $k_date=>$v_date){
                        foreach ($ruang as $k_ruang => $v_ruang) {
                            $sql = db_read("select DISTINCT(nama), npm from vSesi_PK where id_ruang='" . $v_ruang['id_ruang'] . "' AND konfirmasi='Y' AND tanggal='".$v_date['tanggal']."' order by nama asc");
                            if(count($sql) > 0){
                                $no = 1;
                                echo "<div class='printbreak'>";
                                echo "<center><b>Presensi PPM Pembekalan Karir</b></center>
                            <br /><br />";
                                echo "<p>
                                   <b>Tanggal : ".$v_date['tanggal']."</b><br />
                                   <b>Ruang : ".$v_ruang['nama_ruang']."</b>
                              </p>
                        <table width='100%'>
                            <tr style='padding: 20px'>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NPM</th>
                                <th>Tanda Tangan</th>
                            </tr>";

                                foreach ($sql as $key => $value) {
                                    echo "<tr>
            							<td>".$no."</td>
            							<td>".strtoupper($value['nama'])."</td>
            							<td>".$value['npm']."</td>
            							<td>".$no."</td>
            						</tr>";

                                    $no++;
                                }

                                echo "</table></div>";
                            }
                        }
                    }
                }
            }
            ?>
            <div class="printbreak">

            </div>

        <?php elseif ($op == "oh") : ?>
            <?php
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=presensi_oh.doc");
                $ruang = db_read("select id_ruang, nama_ruang from vDivRoom where id_acara='3'");
                $sesi = db_read("select jam_mulai,jam_akhir from vSesi where id_acara='3'");
                if(count($ruang) > 0){
                    if(count($sesi) > 0){
                        foreach ($ruang as $k_ruang=>$v_ruang){
                            foreach ($sesi as $k_sesi=>$v_sesi){
                                echo "<div class='printbreak'>";
                                echo "<center><b>Presensi Open House</b></center><br />";
                                echo "<p><b>$v_ruang[nama_ruang]</b><br /><b>Jam : $v_sesi[jam_mulai] - $v_sesi[jam_akhir]</b></p>";
                                echo "<table width='100%'>";
                                echo "<tr style='padding: 20px'>
                                            <td>No</td>
                                            <td>Nama</td>
                                            <td>Telepon</td>
                                            <td>Tanda Tangan</td>
                                      </tr>";
                                $sql = db_read("select nama_kel, telepon from vSesi_OH where jam_mulai='".$v_sesi['jam_mulai']."' AND jam_akhir='".$v_sesi['jam_akhir']."' AND nama_ruang='".$v_ruang['nama_ruang']."' order by nama_kel asc");
                                $no = 1;
                                foreach ($sql as $key => $value) {
                                    echo "<tr>
                                            <td>".$no."</td>
                                            <td>".strtoupper($value['nama_kel'])."</td>
                                            <td>".$value['telepon']."</td>
                                            <td>".$no."</td>
                                         </tr>";
                                    $no++;
                                }
                                echo "</table></div>";
                            }
                        }
                    }else{
                        echo "Sesi untuk open house belum ditentukan.";
                    }
                }else{
                    echo "Ruang untuk open house belum ditentukan";
                }
            ?>
        <?php else: ?>
            <b>Maaf, halaman tidak ditemukan.</b>
        <?php endif; ?>
    </div>
</body>
</html>
