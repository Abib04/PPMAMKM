<?php if ($_SESSION['login'] == 1) {
    $page = @$_GET['page']; ?>
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><b>Menu Pengguna</b></div>
        <div class="panel-body navi">
            <?php
            if (array_key_exists("username", $_SESSION)) {
                if ($_SESSION['logged_as'] == "mahasiswa") {
                    //Cek Potensi
                    cek_potensi();
                    $conf = ($_SESSION['mhs_confirm']) ? TRUE : get_confirm();
            ?>

                    <ul class="nav nav-pills nav-stacked">
                        <li <?php echo ($page == "data_mhs_current") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_mhs_current'); ?>">Biodata Mahasiswa</a></li>
                        <li <?php echo ($page == "data_mhs_potensi") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_potensi'); ?>">Data Potensi</a></li>
                        <li <?php echo ($page == "data_mhs_prestasi") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_prestasi'); ?>">Data Prestasi</a></li>
                        <li <?php echo ($page == "data_mhs_penyakit") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_penyakit'); ?>">Data Penyakit</a></li>
                        <li <?php echo ($page == "data_mhs_kel") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_kel'); ?>">Data Keluarga</a></li>
                        
                        <li><a href="<?= base_url('cocard.php?kirim=cetak') ?>" target="_blank">Cetak Cocard</a></li>
                        
                        <?php
                        if ($conf) {
                        ?>
                            <!--<li <?php //echo ($page == "data_mhs_reg_oh") ? "class='active'" : ""; ?>><a href="<?php //echo rules('reg_oh'); ?>">Pendaftaran OpenHouse</a></li>-->
                        <?php
                        }
                        ?>
                        <!--<li><a href="javascript:void(0);" onclick="chrome.windows.create({'url': '<?php echo base_url(); ?>', 'incognito': true});">Survey</a></li>-->
                        <!-- <li><a href="<?php echo rules('survey_mhs'); ?>">Survey</a></li> -->
                        <li <?php echo ($page == "data_mhs_acara") ? "class='active'" : ""; ?>><a href="<?php echo rules('jadwal_acara'); ?>">Jadwal Acara</a></li>

                        <?php if (count(db_read("SELECT * FROM `vsertifikat` WHERE `npm` = '" . $_SESSION['username'] . "'")) > 0) { ?>
                            <li><a href="<?= base_url('get_cert.php') ?>" target="_blank">Cetak e-Sertifikat</a></li>
                        <?php } ?>
                        <li <?php echo ($page == "ganti_passwd") ? "class='active'" : ""; ?>><a href="<?php echo rules('ganti_passwd'); ?>">Ganti Password</a></li>
                    </ul>
                <?php

                } else if ($_SESSION['logged_as'] == "mentor") {

                ?>
                    <ul class="nav nav-pills nav-stacked">

                        <li <?php echo ($page == "konfirmasi_npm") ? "class='active'" : ""; ?>><a href="<?php echo rules('konfirmasi_aja'); ?>">Konfirmasi Mahasiswa</a></li>
                    <?php
                } else if ($_SESSION['logged_as'] == "ddi") {
                    ?>
                        <ul class="nav nav-pills nav-stacked">

                            <li <?php echo ($page == "konfirmasi_npm") ? "class='active'" : ""; ?>><a href="<?php echo rules('konfirmasi_aja'); ?>">Konfirmasi Mahasiswa</a></li>

                            <li <?php echo ($page == "data_mhs" || $page == "detail_mhs") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_mhs'); ?>">Data Mahasiswa</a></li>

                            <li <?php echo ($page == "data_panitia") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_panitia'); ?>">Data Panitia</a></li>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "data_admin") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_admin'); ?>">Data Administrator</a></li>
                            <?php endif; ?>

                            <li <?php echo ($page == "d_acara") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_acara'); ?>">Acara</a></li>


                            <li <?php echo ($page == "peserta_acara") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_peserta_acara'); ?>">Peserta Acara</a></li>


                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "d_ruangan") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_ruangan'); ?>">Daftar Ruangan</a></li>
                            <?php endif; ?>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "data_kelompok") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_kelompok'); ?>">Kloter dan Kelompok</a></li>
                            <?php endif; ?>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "sesi") ? "class='active'" : ""; ?>><a href="<?php echo rules('sesi'); ?>">Sesi</a></li>
                            <?php endif; ?>

                            <li <?php echo ($page == "data_pendukung") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_pendukung'); ?>">Data Pendukung</a></li>
                            <li <?php echo ($page == "list_pesan") ? "class='active'" : ""; ?>><a href="<?php echo rules('list_pesan'); ?>">Kritik dan Saran</a></li>
                            <li <?php echo ($page == "survey_build") ? "class='active'" : ""; ?>><a href="<?php echo rules('survey_build'); ?>">Survey</a></li>
                            <li <?php echo ($page == "faq") ? "class='active'" : ""; ?>><a href="<?php echo rules('faq'); ?>">FAQ</a></li>
                            <li <?php echo ($page == "ganti_passwd") ? "class='active'" : ""; ?>><a href="<?php echo rules('ganti_passwd'); ?>">Ganti Password</a></li>
                            <li <?php echo ($page == "pengumuman") ? "class='active'" : ""; ?>><a href="<?php echo rules('pengumuman'); ?>">Pengumuman</a></li>
                        </ul>
                    <?php
                } else {
                    ?>
                        <ul class="nav nav-pills nav-stacked">

                            <li <?php echo ($page == "konfirmasi_npm") ? "class='active'" : ""; ?>><a href="<?php echo rules('konfirmasi_aja'); ?>">Konfirmasi Mahasiswa</a></li>

                            <li <?php echo ($page == "data_mhs" || $page == "detail_mhs") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_mhs'); ?>">Data Mahasiswa</a></li>

                            <li <?php echo ($page == "data_mhs_prestasi") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_prestasi'); ?>">Prestasi Mahasiswa</a></li>

                            <li <?php echo ($page == "data_mhs_potensi") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_potensi'); ?>">Potensi Mahasiswa</a></li>

                            <li <?php echo ($page == "data_panitia") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_panitia'); ?>">Data Panitia</a></li>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "data_admin") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_admin'); ?>">Data Administrator</a></li>
                            <?php endif; ?>

                            <li <?php echo ($page == "d_acara") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_acara'); ?>">Acara</a></li>


                            <li <?php echo ($page == "peserta_acara") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_peserta_acara'); ?>">Peserta Acara</a></li>


                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "d_ruangan") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_ruangan'); ?>">Daftar Ruangan</a></li>
                            <?php endif; ?>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "data_kelompok") ? "class='active'" : ""; ?>><a href="<?php echo rules('daftar_kelompok'); ?>">Kloter dan Kelompok</a></li>
                            <?php endif; ?>

                            <?php if ($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li <?php echo ($page == "sesi") ? "class='active'" : ""; ?>><a href="<?php echo rules('sesi'); ?>">Sesi</a></li>
                            <?php endif; ?>

                            <?php /*if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li><a href="<?php echo rules('peserta_oh'); ?>">Peserta Open House</a></li>
                            <?php endif; ?>

                            <?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li><a href="<?php echo rules('peserta_pk'); ?>">Peserta Pembekalan Karir</a></li>
                            <?php endif; ?>

                            <?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                                <li><a href="<?php echo rules('peserta_om'); ?>">Peserta Orientasi Mahasiswa</a></li>
                            <?php endif; */ ?>

                            <li <?php echo ($page == "data_pendukung") ? "class='active'" : ""; ?>><a href="<?php echo rules('data_pendukung'); ?>">Data Pendukung</a></li>
                            <li <?php echo ($page == "list_pesan") ? "class='active'" : ""; ?>><a href="<?php echo rules('list_pesan'); ?>">Kritik dan Saran</a></li>
                            <li <?php echo ($page == "survey_build") ? "class='active'" : ""; ?>><a href="<?php echo rules('survey_build'); ?>">Survey</a></li>
                            <li <?php echo ($page == "faq") ? "class='active'" : ""; ?>><a href="<?php echo rules('faq'); ?>">FAQ</a></li>
                            <li <?php echo ($page == "ganti_passwd") ? "class='active'" : ""; ?>><a href="<?php echo rules('ganti_passwd'); ?>">Ganti Password</a></li>
                            <li <?php echo ($page == "pengumuman") ? "class='active'" : ""; ?>><a href="<?php echo rules('pengumuman'); ?>">Pengumuman</a></li>
                        </ul>

                <?php

                }
            }
                ?>
        </div>
    </div>
<?php } ?>
<?php if (basename($_SERVER['PHP_SELF']) != 'admin.php') : ?>
<div class="panel panel-default">
    <div class="panel-heading" align="center"><b>Info</b></div>
    <div class="panel-body">
        <?php
        $query = "SELECT * FROM pengumuman order by id desc limit 0,8";
        $faqs = db_read($query);
        foreach ($faqs as $key => $value) { ?>

            <p style="margin-bottom: 8px;"><b style="font-size: 18px;"><?= $value['judul'] ?></b></p>

            <p align="justify" style="font-size: 14px; line-height: 1.6; letter-spacing: -0.2px; white-space: pre-wrap; margin-bottom: 10px;"><?= str_replace('+62 851-3335-9681', '<span style="white-space: nowrap;">+62 851-3335-9681</span>', $value['isi']) ?></p>
            <hr>
        <?php } ?>
        <!--<a href='<?php echo rules("notice"); ?>&id=<?= $value['id'] ?>'></a>-->
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading" align="center"><b>Sosial Media</b></div>
    <div class="panel-body">
        <div class="row" align="center">
            <div class="col-xs-4">
                <a href="https://api.whatsapp.com/send?phone=6281363006005&text=Selamat%20pagi%20KAK,%20mau%20menanyakan%20informasi%20PPM" target="_blank">
                    <i class="fa fa-whatsapp fa-3x"></i>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="https://twitter.com/ppmamikom" target="_blank">
                    <i class="fa fa-twitter-square fa-3x" style="color: #1DA1F2 !important"></i>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="https://www.instagram.com/ppm_amikom/" target="_blank">
                    <i class="fa fa-instagram fa-3x" style="color: #5C3428 !important"></i>
                </a>
            </div>
            <!--<div class="col-xs-3">-->
            <!--    <a href="https://www.youtube.com/channel/UCNMwEZ8Y3JIod-d22o8yxZQ" target="_blank">-->
            <!--        <i class="fa fa-youtube-play fa-3x" style="color: #CC181E !important"></i>-->
            <!--    </a>-->
            <!--</div>-->
        </div>
    </div>
</div>
<?php endif; ?>
