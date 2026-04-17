<form id="cert" method="get" action="<?= base_url('media.php?page=lupa_password'); ?>">
    <div class="form-group">
        <h4>Silahkan masukkan alamat email akun PPM Anda:</h4>
        <br>
        <lable for="email">

            <input type="hidden" name="page" value="lupa_password" />
            <div class="row">
                <div class="col-xs-8">
                    <input type="email" id="email" name="email" placeholder="Email anda" class="form-control" />
                </div>
                <div class="col-xs-2">
                    <button type="submit" class="btn btn-success">Reset Password</button>
                </div>
            </div>
        </lable>
    </div>
</form>



<div class="row">
    <div class="col-xs-12">

        <?php
        $def_table = "mahasiswa";

        if (isset($_GET['email'])) {
            $email = cleanchar($_GET['email']);
            $data = db_read("SELECT * from mahasiswa where email = '" . $email . "'");
            if (count($data) < 1) { ?>

                <div class="alert alert-danger" role="alert">Email <?= $email ?> tidak valid! Silahkan hubungi admin untuk informasi lebih lanjut.</div>
            <?php } else { ?>

        <?php

                $data = array(
                    "remember_token" => uniqid()
                );
                $token = $data['remember_token'];

                db_update($def_table, $data, array("email" => $email));

                $email = new \SendGrid\Mail\Mail();
                $email->setFrom("ppm@amikom.ac.id", "PPM UNIVERSITAS AMIKOM");
                $email->setSubject("Atur Ulang Kata Sandi Akun PPM");
                $email->addTo($_GET['email'], $data[0]['nama']);
                $email->addContent(
                    "text/html",
                    "
        <br/>
        <center><img src='http://ppm.amikom.ac.id/resource/assets/images/LogoPPMUmum.png' height='50'/></center>
        
        <br/><br/>
        Hallo,<br/>
        Baru-baru ini kami menerima permintaan untuk mereset sandi akun PPM Anda. Jika Anda tidak melakukannya, silahkan abaikan email ini.
        <br/><br/>
        Untuk mereset sandi Anda, silahkan klik link berikut:<br/>
        <a href='http://ppm.amikom.ac.id/media.php?page=lupa_password&action=reset&token=" . $token . "'>http://ppm.amikom.ac.id/media.php?page=lupa_password&action=reset&token=" . $token . "</a><br/>
        Setelah Anda mengklik link tersebut, sandi Anda akan direset dan sandi baru akan dikirim ke email Anda.<br/>
        link tersebut hanya berlaku 1 kali pakai.

        <br/>
        <br/>
        
        Kunjungi <a href='http://ppm.amikom.ac.id'>PPM AMIKOM</a> untuk melakukan login.<br/><br/>
        
        Terima kasih :)<br/>
        Salam, Panitia PPM.

        <div style='background-color:#f5f5f5; font-size: 15px; padding: 15px; margin-top: 15px;'>
        <b>Info lebih lanjut:</b> <br/>
        <table style='margin-top: 18px;'>
            <tr>
                <td style='padding-right: 50px;'>WhatsApp</td>
                <td style='padding-right: 50px;'>+62 813-6300-6005</td>
            </tr>
            <tr>
                <td style='padding-right: 50px;'>Twitter</td>
                <td style='padding-right: 50px;'><a href='https://twitter.com/ppmamikom'>@ppmamikom</a></td>
            </tr>
            <tr>
                <td style='padding-right: 50px;'>Instagram</td>
                <td style='padding-right: 50px;'><a href='https://www.instagram.com/ppm_amikom/'>@ppm_amikom</a></td>
            </tr>
        </table>
        </div>

        <div style='background-color:#FFFFFF; color: #C581FF; font-size: 10px; padding: 15px;
        text-align: center; height: 76px;'>
        Jl. Ring Road Utara, Condong Catur, Sleman, Yogyakarta - Indonesia<br/>
        Telp: (0274) 884201 - 207<br/>
        Fax: (0274) 884208<br/>
        E-Mail: ppm@amikom.ac.id<br/>
        </div>
        "
                );

                $sendgrid = new \SendGrid('YOUR_SENDGRID_API_KEY');
                $response = $sendgrid->send($email);

                if ($response->statusCode() == 202) {
                    echo "<div class='alert alert-success' role='alert'>Pesan telah terikirm, silahkan cek email anda.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Pesan gagal terikirm</div>";
                }
            }
        } elseif ($_GET['action'] == 'reset') {
            $token = $_GET['token'];

            $data = db_read("SELECT * from mahasiswa where remember_token = '" . $token . "'");
            if (count($data) < 1) {

                echo '<div class="alert alert-danger" role="alert">Token <?= $token ?> tidak valid! Silahkan hubungi admin untuk informasi lebih lanjut.</div>';
            } else {
                $pass = generatePassword();
                $var = array(
                    "password" => md5($pass)
                );

                db_update($def_table, $var, array("remember_token" => $token));

                $email = new \SendGrid\Mail\Mail();
                $email->setFrom("ppm@amikom.ac.id", "PPM UNIVERSITAS AMIKOM");
                $email->setSubject("Password Telah Direset");
                $email->addTo($data['0']['email'], $data[0]['nama']);
                $email->addContent(
                    "text/html",
                    "
        <br/>
        <center><img src='http://ppm.amikom.ac.id/resource/assets/images/LogoPPMUmum.png' height='50'/></center>
        
        <br/><br/>
        Hallo,<b>" . $nama . "</b><br/>
        Kami telah mereset password member area Anda. Berikut adalah detail login Anda:<br/>
        <b>NPM</b>      : " . $data[0]['npm'] . "<br/>
        <b>Password</b> : " . $pass . "<br/>
        <font color='red'><i><small>silahkan copy, pastikan tidak ada spasi yang ikut ke copy</small></i></font><br/>
        Untuk mengubah password Anda agar mudah diingat, silahkan Login \"Menu Pengguna => Ganti Password\".

        <br/>
        <br/>
        
        Kunjungi <a href='http://ppm.amikom.ac.id'>PPM AMIKOM</a> untuk melakukan login.<br/><br/>
        
        Terima kasih :)<br/>
        Salam, Panitia PPM.

        <div style='background-color:#f5f5f5; font-size: 15px; padding: 15px; margin-top: 15px;'>
        <b>Info lebih lanjut:</b> <br/>
        <table style='margin-top: 18px;'>
            <tr>
                <td style='padding-right: 50px;'>WA</td>
                <td style='padding-right: 50px;'>+62 813-6300-6005</td>
            </tr>
            <tr>
                <td style='padding-right: 50px;'>Twitter</td>
                <td style='padding-right: 50px;'><a href='http://twitter.com/ppmamikom'>@ppmamikom</a></td>
            </tr>
            <tr>
                <td style='padding-right: 50px;'>Instagram</td>
                <td style='padding-right: 50px;'><a href='https://www.instagram.com/ppm_amikom/'>@ppm_amikom</a></td>
            </tr>
        </table>
        </div>

        <div style='background-color:#FFFFFF; color: #C581FF; font-size: 10px; padding: 15px;
        text-align: center; height: 76px;'>
        Jl. Ring Road Utara, Condong Catur, Sleman, Yogyakarta - Indonesia<br/>
        Telp: (0274) 884201 - 207<br/>
        Fax: (0274) 884208<br/>
        E-Mail: ppm@amikom.ac.id<br/>
        </div>
        "
                );

                $sendgrid = new \SendGrid('YOUR_SENDGRID_API_KEY');
                $response = $sendgrid->send($email);

                if ($response->statusCode() == 202) {
                    echo "<div class='alert alert-success' role='alert'>Informasi akun login sudah kami kirim ke email, silahkan cek email anda!</div>";
                    $arr = array(
                        "remember_token" => null
                    );
                    db_update($def_table, $arr, array("remember_token" => $token));
                } else {
                    echo "<div class='alert alert-danger' role='alert'>gagal kirim email!</div>";
                }
            }
        }


        ?>

    </div>
</div>
