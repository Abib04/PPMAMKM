<?php
    if ($_SESSION['pesan_error'] != null && $_SESSION['pesan_error'] != "") {
        echo ';
        <div class="alert alert-danger" role="alert">
        '.$_SESSION['pesan_error'].'
        </div>';
    }
?>


<div class="row">
    <div class="col-xs-12">
        <form id="cert" method="post" action="<?= base_url('cetak_sertifikat_public.php'); ?>">
            <div class="form-group">
                <h4>Silahkan lengkapi data-data berikut untuk penyetakan sertifikat PPM</h4>
                <br>
                <lable for="email">

                    <input type="hidden" name="page" value="cetak_sertifikat" />
                    <div class="row">
                        <div class="col-xs-8">
                            NPM / NIM saat PPM
                            <input type="text" id="nim_ppm" name="nim_ppm" placeholder="NIM PPM" class="form-control" required="" />
                        </div>
                        <div class="col-xs-8">
                            NPM / NIM saat ini (kosongkan jika tidak berubah)
                            <input type="text" id="nim_skrng" name="nim_skrng" placeholder="NIM Sekarang" class="form-control" />
                        </div>
                        <div class="col-xs-8">
                            Tanggal Lahir
                            <input type="date" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control"  required="" />
                        </div>
                        <div class="col-xs-8">
                            <hr/>
                        </div>
                        <div class="col-xs-8">
                            *note : jika belum mengupload foto profil untuk akun PPM, maka cetak sertifikat <b>akan gagal</b>.
                        </div>
                        <div class="col-xs-8">
                            <hr/>
                        </div>
                        <div class="col-xs-8">
                            <button type="submit" class="btn btn-success">Cetak Sertifikat</button>
                        </div>
                    </div>
                </lable>
            </div>
        </form>

    </div>
</div>
