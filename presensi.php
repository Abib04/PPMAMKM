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
	if(($_SESSION['login'] != 1 and ($_SESSION['logged_as'] != "super_admin" or $_SESSION['logged_as'] != "ddi")) or ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa")){
        exit("Maaf, anda tidak bisa mengakses halaman ini.");
    }
?>

<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Cetak Presensi PPM</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
    <style type="text/css" media="all">
        <?php if($_GET['id'] != 12): ?>
        .table tr:nth-child(even) td:last-child{
            text-align: center;
        }
        <?php endif; ?>

        .table tr:nth-child(odd) td:last-child{
            text-align: left;
        }
	.table tr td:last-child{
            width: 180px;
        }

        .container{
            width: 980px;
            margin: 0 auto;
        }

        .table tr td, .table tr th{
            padding-left: 10px;
            padding-right: 10px;
        }
        .table tr td{
            padding-top: 5px;
            padding-bottom : 5px;
        }

	.no-border, .no-border th, .no-border td {
	    border: none !important;
	}

        
	.center {
	    text-align: center !important;
	}

    .left{
        text-align: left !important;
    }

        .table, th, td {
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
            if(isset($_GET['dl'])){
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=presensi_panitia.doc");
            }
            ?>
            <center><b>Presensi Panitia Penggalian Potensi Mahasiswa (PPM)</b></center>
            <br />
            <table width="100%" class="table">
            <thead>
                <tr style="padding: 20px;">
                    <th class="center">No</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Tanda Tangan</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $sql = db_read("select nama,nama_pp from vpanitia where id_thn='".get_year(get_active_year())."' order by nama asc");
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
                </tbody>
            </table>
        
        <?php elseif ($op == "oh") : ?>
            <?php
//                header("Content-type: application/vnd.ms-word");
//                header("Content-Disposition: attachment;Filename=presensi_oh.doc");
                $ruang = db_read("select id_ruang, nama_ruang from vdivroom where id_acara=3 and id_thn=".get_year(get_active_year()));
                $sesi = db_read("select id_sesi, jam_mulai,jam_akhir, tanggal as tgl from vsesi where id_acara=3 and id_thn=".get_year(get_active_year()));
                if(count($sesi) > 0){
                    if(count($ruang) > 0){
                    foreach ($sesi as $k_sesi=>$v_sesi){
                        foreach ($ruang as $k_ruang=>$v_ruang){
                                echo "<div class='printbreak'>";
                                //echo "<br/>";
                                echo "<center><b>Presensi Open House</b></center><br />";
                                echo "<table class=\"no-border\"><tr><td>Ruang</td><td> : $v_ruang[nama_ruang]</td></tr><tr><td>Tanggal</td><td> : $v_sesi[tgl] </td></tr><tr><td>Jam</td><td> : $v_sesi[jam_mulai] - $v_sesi[jam_akhir]</td></tr></table><br />";
                                echo "<table width='100%' class=\"table\">";
                                echo "<thead>
                                <tr><td colspan=\"5\">Ruang : $v_ruang[nama_ruang] | Tanggal : $v_sesi[tgl] | Jam : $v_sesi[jam_mulai] - $v_sesi[jam_akhir] </td></tr>
                                <tr style='padding: 20px'>
					                <td  class=\"center\" >Nomor</td>
					                <td  class=\"center\" >NPM</td>
                                    <td>Nama Wali</td>
                                    <td>Nama Mahasiswa</td>
                                    <td class=\"center\" >Tanda Tangan</td>
                                </tr></thead><tbody>";
                                $sql = db_read("select npm, mhs, nama_kel, nomor, telepon from vsesi_oh where id_thn='".get_year(get_active_year())."' and id_sesi='".$v_sesi['id_sesi']."' AND id_ruang='".$v_ruang['id_ruang']."'  order by npm asc");
                                $no = 1;
                                foreach ($sql as $key => $value) {?>
                                    <tr>
                                            <td class="center" ><?php echo $no; //$value['nomor']; ?></td>
                                            <td class="center" ><?php echo $value['npm']?></td>
                                            <td><?php echo ucwords(strtolower(singkat_nama($value['nama_kel']))); ?></td>
                                            <td><?php echo ucwords(strtolower(singkat_nama($value['mhs']))); ?></td>
                                            <td><?php echo $no ?></td>
                                         </tr>
                                    <?php 
                                    $no++;
                                }
                                echo "</tbody></table></div>";
                            }
                        }
                    }else{
                        echo "Ruang untuk open house belum ditentukan";
                    }
                }else{
                    echo "Sesi untuk open house belum ditentukan.";
                }
            ?>
            <?php elseif ($op == "om") : ?>
            <?php
            if(isset($_GET['dl'])){
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=presensi_om.doc");
            }
            $ruang = db_read("select id_ruang, nama_ruang, max_kuota from vdivroom where id_acara='2' and id_thn='".get_year(get_active_year())."'");
            if(count($ruang) > 0){
                foreach ($ruang as $k_ruang => $v_ruang) {
                    $sql = db_read("select * from vsesi_om where id_thn='".get_year(get_active_year())."' and id_ruang='".$v_ruang['id_ruang']."' AND konfirmasi='Y' order by nama asc");
                    if(count($sql) > 0){
                        $no=1;
                        echo '<div class="printbreak">';
                        echo "<center><b>Presensi PPM Orientasi Mahasiswa</b></center>
                               <br />
                               <br />";
                        echo "<b>Ruang : " . $v_ruang['nama_ruang']."</b><br /><br />";
                        echo "<table width='100%' class=\"table\">
                                <thead>
	    						<tr>
	    							<th>No</th>
	    							<th>Nama</th>
	    							<th>NPM</th>
	    							<th>Tanda Tangan</th>
	    						</tr>
                                </thead>
                                <tbody>";

                        foreach ($sql as $key => $value) {
                            echo "<tr>
            							<td>".$no."</td>
            							<td>".strtoupper($value['nama'])."</td>
            							<td>".$value['npm']."</td>
            							<td>".$no."</td>
            						</tr>";

                            $no++;
                        }
                        echo "</tbody></table></div>";
                    }
                }
            }
            ?>
        <?php elseif ($op == "acara") : 
            if(isset($_GET['dl'])){
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=presensi_panitia.doc");
            }
            $id = (isset($_GET['id']))? cleanchar($_GET['id']) : null ;
            $type = (isset($_GET['typ']))? cleanchar($_GET['typ']) : '1';
            if(!is_null($id)){
                // $sesi = db_read("SELECT * FROM vsesi WHERE id_acara = ".$id." AND id_thn = ".get_year(get_active_year()));
                // foreach ($sesi as $k_sesi => $v_sesi) {
                    
                //     $ruang = db_read("SELECT * FROM vdivroom WHERE id_acara = ".$id." AND id_thn = ".get_year(get_active_year()));
                //     foreach ($ruang as $k_ruang => $v_ruang) {
                //         echo"<div class=\"printbreak\" ><center><h3>Presensi Acara ".$v_sesi['nama_acara']."</h3></center>";
                //         if($type=='1'){
                //         echo "<table width='100%' class=\"table\"><thead>
                //                     <tr>
                //                         <th colspan=\"5\" class=\"left\">Sesi ".$v_sesi['nama_sesi']." ".$v_sesi['nama_acara']."  |  Tanggal : ".date_format(date_create($v_sesi['tanggal']),'d M Y')."  |  Ruang : ".$v_ruang['nama_ruang']."  |</th>
                //                     </tr>
                //                     <tr>
                //                         <th>No</th>
                //                         <th>Kelompok</th>
                //                         <th>Nama</th>
                //                         <th>NPM</th>
                //                         <th>TTD</th>
                //                         </tr>
                //                 </thead>
                //                 <tbody>";
                //         }
                //         $no = 1;
                //         $q = "SELECT *,(SELECT nama_kelompok FROM kelompok WHERE id = vjadwalbykelompok.id_kelompok) as nama_kelompok FROM vjadwalbykelompok WHERE id_sesi = ".$v_sesi['id_sesi']." AND id_ruang = ".$v_ruang['id_ruang'];
                //         $kelompok = db_read($q);
                //         //echo $q;
                //         //print_r($kelompok);
                //         foreach ($kelompok as $k_kel => $v_kel) {
                //             if($type == '1'){
                //                 $peserta = db_read("SELECT * FROM mahasiswa WHERE id_kelompok = ".$v_kel['id_kelompok']." ORDER BY nama");
                //                 foreach ($peserta as $k_mhs => $v_mhs) {
                //                     # code...
                //                     echo "<tr>
                //                         <td class=\"center\">".$no."</td>
                //                         <td class=\"center\">".$v_kel['nama_kelompok']."</td>
                //                         <td>".$v_mhs['nama']."</td>
                //                         <td class=\"center\">".$v_mhs['npm']."</td>
                //                         <td class\"ttd\">".$no."</td>
                //                     </tr>";
                //                     $no++;
                //                 }
        
                               
                //             } elseif($type == '2') {
                                
                //                     echo "<h3>Sesi ".$v_sesi['nama_sesi']."<br />
                //                     Tanggal : ".date_format(date_create($v_sesi['tanggal']),'d M Y')."<br />Ruang : ".$v_ruang['nama_ruang']."</h3>";
                //                 echo "<h4>Kelompok : ".$v_kel['nama_kelompok']."</h4><table width='100%' class=\"table\">
                //                 <thead>
                //                     <tr>
                //                         <th>No</th>
                //                         <th>Nama</th>
                //                         <th>NPM</th>
                //                         <th>TTD</th>
                //                         </tr>
                //                 </thead>
                //                 <tbody>";
                //                 # code...
                //                 $peserta = db_read("SELECT * FROM mahasiswa WHERE id_kelompok = ".$v_kel['id_kelompok']." ORDER BY npm ");
                //                 foreach ($peserta as $k_mhs => $v_mhs) {
                //                     # code...
                //                     echo "<tr>
                //                         <td class=\"center\">".($k_mhs + 1)."</td>
                //                         <td>".$v_mhs['nama']."</td>
                //                         <td class=\"center\">".$v_mhs['npm']."</td>
                //                         <td></td>
                //                     </tr>";
                //                 }
        
                //                 echo "</tbody>
                //                 </table>";
                //                 echo "</div><div class=\"printbreak\">";
                //             }

                //         }
                //         if($type == '1'){
                //             echo "</tbody>
                //            </table>";
                //        }
                //         echo '</div >';
                //     }
                // }
                //$data_presensi = db_read("SELECT `nama_acara`,`nama_sesi`,`tanggal`,`nama_sesi`,`jam_mulai`,`nama_ruang`,`nama_kelompok`,`npm`,`nama` FROM `vjadwalperson` WHERE id_thn=".get_id_active_year()." AND id_acara= ".$id." GROUP BY `id_acara`, `id_sesi`, `id_ruang`,`id_kelompok`,`npm`");
                
                $data_presensi = db_read("SELECT v.`nama_acara`,v.`nama_sesi`,v.`tanggal`,v.`nama_sesi`,v.`jam_mulai`,v.`nama_ruang`,v.`nama_kelompok`,v.`npm`,v.`nama`,mhs.hp FROM `vjadwalperson` v INNER join mahasiswa mhs on mhs.npm=v.npm WHERE v.id_thn=".get_id_active_year()." AND v.id_acara= ".$id." GROUP BY v.`id_acara`, v.`id_sesi`, v.`id_ruang`,v.`id_kelompok`,mhs.`npm`");
                
                //Cek Method Acara
                $sql_acara = db_read("SELECT * FROM `vacara` WHERE `id_acara` = ".$id. " AND `id_thn` = ".get_id_active_year());
                
                $method = "";
                
                if(count($sql_acara) > 0){
                    $method = $sql_acara[0]['method_th'];
                    
                    //Jika Method == 1 dari view vjadwalpersonsesi
                    if($method==1){
                        $data_presensi = db_read("SELECT v.`nama_acara`,v.`nama_sesi`,v.`tanggal`,v.`nama_sesi`,v.`jam_mulai`,v.`nama_ruang`,k.`nama_kelompok`,v.`npm`,v.`nama`,mhs.hp 
                        FROM `vjadwalpersonsesi` v 
                        INNER join mahasiswa mhs on mhs.npm=v.npm 
                        JOIN kelompok k ON mhs.id_kelompok=k.id
                        WHERE v.id_thn=".get_id_active_year()." AND v.id_acara= ".$id." 
                        GROUP BY v.`id_acara`, v.`id_sesi`, v.`id_ruang`,mhs.`id_kelompok`,mhs.`npm`");
                    //Jika Method == 2 dari view vjadwalbyfakultas
                    }else if($method==2 || $method==4){
                        $data_presensi = db_read("SELECT v.`nama_acara`,v.`nama_sesi`,v.`tgl_mulai` as `tanggal`,v.`nama_sesi`,v.`jam_mulai`,v.`nama_ruang`,k.`nama_kelompok`,v.`npm`,v.`nama`,mhs.hp 
                            FROM `vjadwalbyfakultas` v 
                            INNER join mahasiswa mhs on mhs.npm=v.npm 
                            JOIN kelompok k ON mhs.id_kelompok=k.id
                            WHERE v.id_thn=".get_id_active_year()." AND v.id_acara= ".$id." 
                            GROUP BY v.`id_acara`, v.`id_sesi`, v.`id_ruang`,mhs.`id_kelompok`,mhs.`npm`");
                    //Jika Method == 3 dari view vjadwalperson
                    }else if($method==3){
                        
                    }
                }
                $nomor = 1;
                $cur_sesi = $data_presensi[0]['nama_sesi'];
                $cur_ruang = $data_presensi[0]['nama_ruang'];
                echo"<div class=\"printbreak\" ><center><h3>Presensi Acara ".$data_presensi[0]['nama_acara']."</h3></center>";
                ?>
                <script type="text/javascript">
                    document.title ="Presensi Acara <?php echo $data_presensi[0]['nama_acara'];?>";
                </script>
                <?php
                echo "<table width='100%' class=\"table\"><thead>
                            <tr>
                                <th colspan=\"6\" class=\"left\">Sesi ".$data_presensi[0]['nama_sesi']." ".$data_presensi[0]['nama_acara']."  |  Tanggal : ".date_format(date_create($data_presensi[0]['tanggal']),'d M Y')."  |  Ruang : ".$data_presensi[0]['nama_ruang']."  |</th>
                            </tr>
                            <tr>";
                            if($id != 12):
                                if($method==2):
                                    echo "<th>No</th>
                                    <th>Fakultas</th>
                                    <th>Nama</th>
                                    <th>NPM</th>
                                    <th>NO HP</th>
                                    <th>TTD</th>";
                                else:
                                    echo "<th>No</th>
                                    <th>Kelompok</th>
                                    <th>Nama</th>
                                    <th>NPM</th>
                                    <th>NO HP</th>
                                    <th>TTD</th>";
                                endif;
                            
                            else:
                                echo "<th>No</th>
                                <th>Nama</th>
                                <th>NPM</th>
                                <th>NO HP</th>
                                <th>Fakultas</th>
                                <th>Prodi</th>";
                            endif;
                            echo "</tr>
                        </thead>
                        <tbody>";
                foreach ($data_presensi as $key => $value) {
                    $cur_sesi = $value['nama_sesi'];
                    $cur_ruang = $value['nama_ruang'];
                    if($id != 12):
                        if($method==2):
                            echo "<tr>
                            <td class=\"center\">".$nomor."</td>
                            <td width=140px>".get_fakultas_prodi($value['npm'],"f")."</td>
                            <td>".$value['nama']."</td>
                            <td class=\"center\">".$value['npm']."</td>
                            <td class=\"center\">".$value['hp']."</td>
                            <td class\"ttd\">".$nomor."</td>
                            </tr>";
                        else:
                        echo "<tr>
                            <td class=\"center\">".$nomor."</td>
                            <td class=\"center\" style=\"width=200px \">".$value['nama_kelompok']."</td>
                            <td>".$value['nama']."</td>
                            <td class=\"center\">".$value['npm']."</td>
                            <td class=\"center\">".$value['hp']."</td>
                            <td class\"ttd\">".$nomor."</td>
                        </tr>";
                        endif;
                    else:
                    echo "<tr>
                        <td class=\"center\">".$nomor."</td>
                        <td>".$value['nama']."</td>
                        <td class=\"center\">".$value['npm']."</td>
                        <td class=\"center\">".$value['hp']."</td>
                        <td class=\"center\">".get_fakultas_prodi($value['npm'],"f")."</td>
                        <td class\"ttd\">".get_fakultas_prodi($value['npm'],"p")."</td>
                    </tr>";


                    endif;
                    $nomor++;
                    if($cur_ruang != $data_presensi[$key+1]['nama_ruang'] and $key != (count($data_presensi)-1)){
                        echo "</tbody></table></div>";
                        echo"<div class=\"printbreak\" ><center><h3>Presensi Acara ".$value['nama_acara']."</h3></center>";
                        if($method==2):
                        echo "<table width='100%' class=\"table\"><thead>
                                    <tr>
                                        <th colspan=\"6\" class=\"left\">Sesi ".$value['nama_sesi']." ".$value['nama_acara']."  |  Tanggal : ".date_format(date_create($value['tanggal']),'d M Y')."  |  Ruang : ".$data_presensi[$key+1]['nama_ruang']."  |</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Fakultas</th>
                                        <th>Nama</th>
                                        <th>NPM</th>
                                        <th>No HP</th>
                                        <th>TTD</th>
                                        </tr>
                                </thead>
                                <tbody>";
                        else:
                            echo "<table width='100%' class=\"table\"><thead>
                                    <tr>
                                        <th colspan=\"6\" class=\"left\">Sesi ".$value['nama_sesi']." ".$value['nama_acara']."  |  Tanggal : ".date_format(date_create($value['tanggal']),'d M Y')."  |  Ruang : ".$data_presensi[$key+1]['nama_ruang']."  |</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelompok</th>
                                        <th>Nama</th>
                                        <th>NPM</th>
                                        <th>No HP</th>
                                        <th>TTD</th>
                                        </tr>
                                </thead>
                                <tbody>";
                        endif;

                        $nomor = 1;
                    }
                    

                }
                echo "</tbody></table></div>";
            }
            ?>



        <?php elseif ($op == "pk") : ?>
            <?php
            // header("Content-type: application/vnd.ms-word");
            // header("Content-Disposition: attachment;Filename=presensi_pk.doc");
            $ruang = db_read("select id_ruang, nama_ruang, max_kuota from vdivroom where id_acara='1'");
            if(count($ruang) > 0){
                $tanggal = db_read("select DISTINCT(tanggal), jam_mulai, jam_akhir from vsesi_pk");

                if(count($tanggal) > 0){
                    foreach($tanggal as $k_date=>$v_date){
                        foreach ($ruang as $k_ruang => $v_ruang) {
                            $sql = db_read("select DISTINCT(nama), npm from vsesi_pk where id_thn='".get_year(get_active_year())."' and jam_mulai='".$v_date['jam_mulai']."' and jam_akhir='".$v_date['jam_akhir']."' and id_ruang='" . $v_ruang['id_ruang'] . "' AND konfirmasi='Y' AND tanggal='".$v_date['tanggal']."' order by nama asc");
                            if(count($sql) > 0){
                                $no = 1;
                                echo "<div class='printbreak'>";
                                echo "<center><b>Presensi PPM Pembekalan Karir</b></center>
                            <br /><br />";
                                echo "<p>
                                   <b>Tanggal : ".$v_date['tanggal']."</b><br />
                                   <b>Ruang : ".$v_ruang['nama_ruang']."</b><br />
                                   <b>Jam : ".$v_date['jam_mulai']." - ".$v_date['jam_akhir']."</b><br />
                              </p>
                        <table width='100%' class=\"table\">
                        <thead>
                            <tr style='padding: 20px'>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NPM</th>
                                <th>No HP</th>
                                <th>Tanda Tangan</th>
                            </tr></thead><tbody>";

                                foreach ($sql as $key => $value) {
                                    echo "<tr>
            							<td>".$no."</td>
            							<td>".strtoupper($value['nama'])."</td>
            							<td>".$value['npm']."</td>
            							<td>".$value['npm']."no hp"."</td>
            							<td>".$no."</td>
            						</tr>";

                                    $no++;
                                }

                                echo "</tbody></table></div>";
                            }
                        }
                    }
                }
            }
            ?>
            <div class="printbreak">

            </div>

        <?php else: ?>
            <b>Maaf, halaman tidak ditemukan.</b>
        <?php endif; ?>
    </div>
</body>
</html>
