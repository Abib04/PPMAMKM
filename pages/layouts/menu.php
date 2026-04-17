<ul class="main-nav">   
    <li>
        <a href="<?php echo base_url(); ?>">Beranda </a>
    </li>
    <li>
        <a href="<?php echo rules('info_ppm'); ?>">Informasi PPM </a>
    </li>
    <li>
    	<a href="<?php echo rules('kritik_saran'); ?>">Kritik dan Saran</a>
    </li>
    <li>
    	<a href="<?php echo rules('faq'); ?>">FAQ</a>
    </li>
    <li>
    	<a href="<?php echo rules('cert'); ?>">Cek Sertifikat</a>
    </li>
    <?php if(empty($_SESSION['login'])): ?>
    <li>
        <a href="<?= base_url('media.php?page=public_sertifikat') ?>">Cetak Sertifikat</a>
    </li>
    <li>
        <a target="_blank" href="https://drive.google.com/file/d/1B6yZD41AbZLpDUKZNICpZz0bL7oLRyFT/view?usp=sharing">Petunjuk Pengisian Data</a>
    </li>
    <?php endif; ?>
</ul>
