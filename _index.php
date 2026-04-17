<div style="width: 100%; padding: 24px; background: #e74c3c; text-align: center">
    Kamu berada di website lama PPM. Pendaftaran PPM <?= date('Y') ?> dialihkan ke website
    <strong><a href="https://ppm.amikom.id" style="color: #f39c12">ppm.amikom.id</a></strong>
</div>
<?php
ob_start();
header("location:media.php");
?>
