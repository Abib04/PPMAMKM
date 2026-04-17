<div class="panel panel-default">
    <?php 
        $page = (isset($_GET['page'])) ? htmlspecialchars($_GET['page']) : NULL; 
    ?>
        
    <?php if($page == "reg_mhs") : ?>
                <?php 

                    if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
                ?>
                        <script type="text/javascript">
                            window.location.href="<?php echo rules("home_mhs"); ?>";
                        </script>
                <?php
                    elseif($_SESSION['login'] == 1 and in_array($_SESSION['logged_as'],array("super_admin","ddi"))):
                        echo "<div class=\"panel-heading\" align=\"center\"><b>Pendaftaran PPM</b></div>
                                <div class=\"panel-body\">";
                ?>
                        <form action="<?php echo rules("act_insert_mhs"); ?>" method="post" id="formMhs" enctype="multipart/form-data">
                            <?php
                                include "pages/mahasiswa/form_mhs_admin_only.php";
                            ?>
                        </form>
                <?php
                        echo "</div>";
                    else:
                        $ppm_conf = db_read("SELECT count(npm) as jumlah, (select config.conf_value FROM config WHERE config.conf_name='kuota_ppm' and config.conf_year=mahasiswa.id_thn) as kuota from mahasiswa where id_thn = ".get_id_active_year());
                        echo "<div class=\"panel-heading\" align=\"center\"><b>Pendaftaran PPM</b></div>
                            <div class=\"panel-body\">";
                        //echo $date = date("Y-m-d");
                        if(($ppm_conf[0]['jumlah'] < $ppm_conf[0]['kuota']) and (($_SESSION['login'] == 1) and in_array($_SESSION['logged_as'], array("super_admin","ddi")))):
                ?>
                                <form action="<?php echo rules("act_insert_mhs"); ?>" method="post" id="formMhs" enctype="multipart/form-data">
                                    <?php
                                        include "pages/mahasiswa/form_mhs.php";
                                    ?>
                                </form>
                <?php
                        else:
                          //  echo "<b>Pendaftaran PPM " . date('Y') . " dialihkan ke website PPM baru di <a href='https://ppm.amikom.id'>ppm.amikom.id</a></b>";
                            ?>
                           
                            <div class=\"panel-heading\" align=\"center\"><b>Pendaftaran PPM <?php echo get_active_year(); ?></b></div>
                                <div class=\"panel-body\">
                                <form action="<?php echo rules("act_insert_mhs"); ?>" method="post" id="formMhs" enctype="multipart/form-data">
                            
                            <?php
                            $stpdt='tutup';
                            if($stpdt=="buka"){
                                //form pendaftaran
                                include "pages/mahasiswa/form_mhs.php";
                            }
                            else{
                            ?>
                        </form>
                        <?php if($stpdt=="soon"){ ?>
                            <img src="pages/layouts/coming_soon.jpg" alt="Coming Soon" width="600" height="400">
                            <p>image source : www.vecteezy.com</p>
                        <?php } else { ?>
                            <img src="pages/layouts/close.jpg" alt="Girl in a jacket" width="600" height="400">
                        <?php } }
                        endif;
                        echo "</div>";
                    endif;

                ?>
    
    <?php 
            elseif($page == "lupa_password") : ?>
                <div class="panel-heading" align="center"><b>Lupa Password</b></div>
                <div class="panel-body">
                    <?php
                        include "pages/others/lupa_password.php";
                    ?>
                </div>
                
    <?php 
            elseif($page == "public_sertifikat") : ?>
                <div class="panel-heading" align="center"><b>Cetak Sertifikat</b></div>
                <div class="panel-body">
                    
                    <?php
                        include "pages/sertiikat/cetak_sertfikat.php";
                    ?>
                </div>
                

    <?php
        
            elseif($page == "d_ruangan"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Daftar Ruangan</b></div>
                    <div class="panel-body">
                        <?php include "pages/ruang/data_ruang.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo base_url(); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs_current"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Biodata Mahasiswa</b></div>
                    <div class="panel-body">
                    <?php 
                    $a = (get_year(get_active_year()) == $_SESSION['mhs_thn']);
                    if($a){ ?>
                        <form action='<?php echo rules("act_update_mhs"); ?>&id=<?php echo $_SESSION['username']; ?>' method="post" id="formMhs" class="form-group-sm" enctype="multipart/form-data">
                    <?php }
                    include "pages/mahasiswa/form_mhs.php"; 
                    if($a){ ?>
                        </form>
                    <?php } ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs_prestasi"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Prestasi Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/prestasi/mhs_prestasi.php"; ?>
                    </div>
    <?php
                elseif($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Prestasi Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/prestasi/prestasi_mhs.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;
    ?>
    <?php
            //UPDATE MEI 2022
            elseif($page == "data_mhs_potensi"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Potensi Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/potensi/mhs_potensi.php"; ?>
                    </div>
    <?php
                elseif($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Potensi Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/potensi/potensi_mhs.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "data_kelompok"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Data Kelompok</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/data_kelompok.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "konfirmasi_npm"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Konfimasi</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/konfirmasi.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "sesi"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Data Sesi</b></div>
                    <div class="panel-body">
                        <?php include "pages/sesi/list_sesi.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo base_url(); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "peserta_oh"):
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin")):
    ?>
                    <div class="panel-heading" align="center"><b>Peserta Open House</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/peserta_oh.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo base_url(); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "peserta_om"):
                if($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin")):
    ?>
                    <div class="panel-heading" align="center"><b>Peserta Orientasi Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/peserta_om.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo base_url(); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "peserta_pk" and ($_SESSION['logged_as'] == "super_admin")):
    ?>
                <div class="panel-heading" align="center"><b>Peserta Pembekalan Karir</b></div>
                <div class="panel-body">
                    <?php include "pages/others/peserta_pk.php"; ?>
                </div>
    <?php
            elseif($page=="peserta_acara"):
                if($_SESSION['login'] == 1 and in_array($_SESSION['logged_as'], array("super_admin","ddi"))):
    ?>
                    <div class="panel-heading" align="center"><b>Peserta Acara PPM</b></div>
                    <div class="panel-body">
                        <?php include "pages/acara/jadwal_acara.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo base_url(); ?>";
                    </script>
    <?php
                endif;
            elseif($page == "data_mhs_penyakit"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Penyakit Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/penyakit/penyakit_mhs.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs_kel"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Keluarga</b></div>
                    <div class="panel-body">
                        <?php include "pages/keluarga/reg_ortu_form.php"; ?>
                    </div>    
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "ganti_passwd"):
                if($_SESSION['login'] == 1):
    ?>
                    <div class="panel-heading" align="center"><b>Ganti Password <?php echo ($_SESSION['logged_as'] === "mahasiswa") ? ucfirst($_SESSION['logged_as']) : strtoupper(($_SESSION['logged_as'] == "super_admin") ? "Administrator" : $_SESSION['logged_as']); ?></b></div>
                    <div class="panel-body">
                        <?php include "pages/others/form_ganti_passwd.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "d_acara"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Acara</b></div>
                    <div class="panel-body">
                        <?php include "pages/acara/list_acara.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs_reg_oh"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Pendaftaran Open House</b></div>
                    <div class="panel-body">
                        <?php include "pages/acara/reg_open_house.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs_acara"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"):
    ?>
                    <div class="panel-heading" align="center"><b>Jadwal Acara</b></div>
                    <div class="panel-body">
                        <?php //include "pages/acara/list_acara_mhs.php"; ?>
                        <?php include "pages/acara/list_acara_mhs_blank.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_mhs"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Data Mahasiswa <?php echo get_active_year(); ?> </b></div>
                    <div class="panel-body">
                        <?php include "pages/mahasiswa/data_mhs_summary.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_panitia"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Data Panitia</b></div>
                    <div class="panel-body">
                        <?php include "pages/panitia/panitia.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_admin"):
                if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin"):
    ?>
                    <div class="panel-heading" align="center"><b>Data Administrator</b></div>
                    <div class="panel-body">
                        <?php include "pages/admin/form_admin.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "data_pendukung"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Data Pendukung</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/data_pendukung.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "detail_mhs"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Detail Mahasiswa</b></div>
                    <div class="panel-body">
                        <?php include "pages/mahasiswa/detail_mhs.php"; ?>
                    </div>
    <?php
                else:
    ?>
                    <script type="text/javascript">
                        window.location.href="<?php echo rules("home_mhs"); ?>";
                    </script>
    <?php
                endif;

            elseif($page == "info_ppm"):
    ?>
                <div class="panel-heading" align="center"><b>Informasi PPM</b></div>
                <div class="panel-body">
                    <?php include "pages/others/info_ppm.php"; ?>
                </div>
    <?php
            elseif($page == "kritik_saran"):
    ?>
                <div class="panel-heading" align="center"><b>Kritik dan Saran</b></div>
                <div class="panel-body">
                    <?php include "pages/others/kritik_saran.php"; ?>
                </div>
    <?php
            elseif($page == "faq"):
    ?>
                <div class="panel-heading" align="center"><b>FAQ</b></div>
                <div class="panel-body">
                    <?php include "pages/others/faq.php"; ?>
                </div>
    <?php
            elseif($page == "pengumuman"):
    ?>
                <div class="panel-heading" align="center"><b>Pengumuman</b></div>
                <div class="panel-body">
                    <?php include "pages/others/pengumuman.php"; ?>
                </div>
    <?php
            elseif($page == "notice"):
    ?>
                <div class="panel-heading" align="center"><b>Pengumuman</b></div>
                <div class="panel-body">
                    <?php include "pages/others/notice.php"; ?>
                </div>
    <?php
            elseif ($page == "survey_build"):
                if($_SESSION['login'] == 1 and (in_array($_SESSION['logged_as'],array("super_admin","ddi")))):
    ?>
                    <div class="panel-heading" align="center"><b>Survey</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/survey_build.php"; ?>
                    </div>
    <?php
                endif;
            elseif ($page == "survey_mhs"):
                if($_SESSION['login'] == 1):
    ?>
                    <div class="panel-heading" align="center"><b>Survey</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/survey_mhs.php"; ?>
                    </div>
    <?php
                endif;
            elseif($page == "result_reg"):
                if(isset($_SESSION['success_npm']) and isset($_SESSION['success_passwd'])):
    ?>
                    <div class="panel-heading" align="center"><b>Pendaftaran Berhasil</b></div>
                    <div class="panel-body">
                        <?php include "pages/others/success_reg.php"; ?>
                    </div>
    <?php
                endif;
            elseif($page == "detail_pesan"):
    ?>
                <div class="panel-heading" align="center"><b>Detail Pesan</b></div>
                <div class="panel-body">
                    <?php include "pages/others/detail_pesan.php"; ?>
                </div>
    <?php
            elseif($page == "list_pesan"):
    ?>
                <div class="panel-heading" align="center"><b>List Kritik dan Saran</b></div>
                <div class="panel-body">
                    <?php include "pages/others/list_pesan.php"; ?>
                </div>       
    <?php
            elseif($page == "cek_cert"): ?>
                <div class="panel-heading" align="center"><b>Verifikasi Sertifikat</b></div>
                <div class="panel-body">
                    <?php include "pages/sertiikat/cek_certifikat.php"; ?>
                </div>
    <?php
            elseif($page == "binvan"): ?>
                <div class="panel-heading" align="center"><b>Temporary Storage</b></div>
                <div class="panel-body">
                    <?php include "pages/others/temporary_storage.php"; ?>
                </div>
    <?php   elseif(is_null($page)):
    ?>
                <div class="panel-heading" align="center"><b>Penggalian Potensi Mahasiswa</b></div>
                <div class="panel-body">
                    <?php if($_SESSION['login'] == 1): ?>
                            <?php
                                if($_SESSION['logged_as'] == "mahasiswa"){
                                    echo "Selamat datang <b>$_SESSION[fullname]</b><br />";
                                    $mhs = db_read("select konfirmasi from mahasiswa where npm='$_SESSION[username]'");
                                    echo "Status : ";
                                    echo ($mhs[0]['konfirmasi'] == "Y") ? "<b>Sudah Konfirmasi</b>" : "<b>Belum Konfirmasi</b>";
                                }else{
                                    echo "<h3>Anda login sebagai <b>$_SESSION[username]</b></h3>";
                                }
                            ?>
                            <br /><br />
                            <?php endif; ?>
                    <?php if(isset($_SESSION['logged_as'])):
                            if(in_array($_SESSION['logged_as'] ,array("super_admin","mahasiswa"))): ?>
                                <p align="left">
                                    <b>PPM itu apa sih?</b><br /><br />
                                    Penggalian potensi mahasiswa atau yang biasa disebut dengan PPM adalah agenda tahunan yang diselenggarakan oleh Universitas Amikom Yogyakarta dan dijalankan bersama dengan mahasiswa. Didalamnya berisikan konten penggalian potensi mahasiswa dan pengenalan kampus, agar mahasiswa baru dapat dengan mudah beradaptasi sebelum memulai perkuliahan.
                                </p>
                                <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Perhatian</h3>
                                </div>
                                <div class="panel-body">
                                    <p align="justify">
                                        Yang harus dilakukan untuk peserta PPM, yaitu:
                                        <ul>
                                            <li>Setelah Login, lakukan <b>konfirmasi akun</b> dengan menghubungi WhatsApp hotline PPM pada nomor <a href="https://wa.me/6285133359681" target="_blank">+62 851-3335-9681</a></li>
                                            <li>Setelah akun aktif, lengkapi data Potensi, Prestasi, dan Keluarga / Wali kalian</li>
                                            <li>Follow IG PPM : <a href="https://www.instagram.com/ppm_amikom/">@ppm_amikom</a> untuk info terbaru tentang PPM 2025</li>
                                            <li>Hubungi kontak kami jika terdapat kendala teknis</li>
                                        </ul>
                                    </p>
                                </div>
                                
                                <?php
                                else:?>
                                    <!-- <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Sortcut Untuk konfirmasi</h3>
                                    </div>
                                    <div class="panel-body">
                                    <?php //include "pages/others/konfirmasi.php";?>
                                    </div>
                                    </div> -->
                                <?php endif;
                            else: ?>
                                <p align="justify">
                                    <b>PPM itu apa sih?</b><br /><br />
                                    Penggalian potensi mahasiswa atau yang biasa disebut dengan PPM adalah agenda tahunan yang diselenggarakan oleh Universitas Amikom Yogyakarta dan dijalankan bersama dengan mahasiswa. Didalamnya berisikan konten Selamat datang ppm galian potensi mahasiswa dan pengenalan kampus, agar mahasiswa baru dapat dengan mudah beradaptasi sebelum memulai perkuliahan.
                                </p>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Perhatian</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p align="justify">
                                            Yang harus dilakukan untuk peserta PPM, yaitu:
                                        <ul>
                                            <li>Siapkan NIM dan Data Dirimu</li>
                                            <li>Registrasi dan Lengkapi data diri pada masing-masing akun.</li>
                                            <li>Setelah Login, lakukan <b>konfirmasi akun</b> dengan menghubungi WhatsApp hotline PPM pada nomor <a href="https://wa.me/6285133359681" target="_blank">+62 851-3335-9681</a></li>
                                            <li>Setelah akun aktif, lengkapi data Potensi, Prestasi, dan Keluarga / Wali kalian</li>
                                            <li>Follow IG PPM : <a href="https://www.instagram.com/ppm_amikom/">@ppm_amikom</a> untuk info terbaru tentang PPM 2025</li>
                                            <li>Hubungi kontak kami jika terdapat kendala teknis</li>
                                        </ul>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                </div>
    <?php          
        endif; 

    ?>

</div>

<script>
    $(document).ready(function(){
        $("input[name=kode_pos]").mask("99999");
        $("input[name=npm]").mask("99.99.9999");
        $("#npm").mask("99.99.9999");
        $("input[name=tgl_lahir]").mask("9999-99-99");
        
        $("#tabel_ruang").DataTable({
            "ordering": false,
            "info":     false
        });

        //Ruang
        $("#formruang").submit(function(){
            if($("input[name=nama_ruang]").val() == "" || $("input[name=max_kuota]").val() == ""){
                alert("Lengkapi form terlebih dahulu!");
            }else{

                <?php if(isset($_GET['id'])) : ?>
                        $("#formruang").attr("action","<?php echo rules("act_update_ruang"); ?>");  
                <?php else: ?>
                        $("#formruang").attr("action","<?php echo rules("act_insert_ruang"); ?>");  
                <?php endif; ?>

                var method = $("#formruang").attr("method");
                var data = $("#formruang").serialize();
                var target = $("#formruang").attr("action");

                $.ajax({
                    type: method,
                    url: target,
                    data: data,
                    beforeSend: function(){
                        $("#simpan_ruangan").attr("disabled","disabled");
                    }
                }).done(function(response){
                    if(response == "true"){
                        alert("Berhasil disimpan");
                    }else{
                        alert(response);
                    }
                });
            }

            return false;
        });
    });
</script>
