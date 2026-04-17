<?php
if (!defined('BASE_PATH'))
    exit("Maaf, anda tidak bisa mengakses halaman.");

$def_table = "mahasiswa";

$op = cleanchar($_GET['op']);

$token = (isset($_GET['token'])) ? cleanchar($_GET['token']) : null;

if ($op == "create" or $op == "update" or $op == "delete") {
    if (!check_token($token)) {
        echo "<script>
                        alert('Maaf, token kosong atau tidak cocok. Silahkan refresh halaman ini terlebih dahulu.');
                        wiundow.location.href = '" . base_url() . "';
                    </script>";
        exit;
    }
}
global $cache;
$match = false;
if (is_null($op)) {

    include "error/page_404.php";
} else {

    //DataTables Server Side
    require('config/ssp.class.php');
    include_once('config/config_dt.php');

    $id = (isset($_GET['id'])) ? cleanchar($_GET['id']) : NULL;

    if ($id != null) {
        if ($_SESSION['username'] == $id) {
            $match = true;
        }
    }
    $data = array();

    if ($op == "create" or $op == "update") {
        $data = array(
            "id_negara" => cleanchar($_POST['negara']),
            "id_daerah" => cleanchar($_POST['daerah']),
            "id_kab" => cleanchar($_POST['kabupaten']),

            "nama" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['nama'])),
            "alamat_asal" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['alamat_asal'])),
            "rw" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['rw'])),
            "rt" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['rt'])),
            "kecamatan" => cleanchar($_POST['kecamatan']),
            "alamat_yk" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['alamat_yk'])),
            "email" => cleanchar($_POST['email']),
            "hp" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['hp'])),
            "jk" => cleanchar($_POST['jk_mhs']),
            "id_agama" => cleanchar($_POST['agama']),
            "kode_pos" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['kode_pos'])),
            "tempat_lahir" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['tempat_lahir'])),
            "tgl_lahir" => cleanchar($_POST['tgl_lahir']),
            "slta_asal" => preg_replace("/[^a-zA-Z0-9![:space:]]/", "", cleanchar($_POST['slta_asal']))
        );
    }

    if ($op == "create") {
        //print_r($data);
        $jmlMhs = db_read("select count(npm) as jumlah, (select config.conf_value FROM config WHERE config.conf_name='kuota_ppm' and config.conf_year='" . get_year(get_active_year()) . "') as kuota  from mahasiswa where id_thn='" . get_year(get_active_year()) . "'");
        if ($jmlMhs[0]['jumlah'] < $jmlMhs[0]['kuota']) {
            $data["npm"] = cleanchar($_POST['npm']);
            // $data["id_thn"] = get_year("20".substr(cleanchar($_POST['npm']), 0, 2));
            $data["id_thn"] = get_year(get_active_year());
            $data["id_prodi"] = get_prodi($_POST['npm']);

            // $passwd = generatePassword();
            $passwd = $_POST['password'];
            $data['password'] = md5($passwd);
            $data['konfirmasi'] = "N";

            if ($data["id_thn"] == FALSE) {
                echo "<script>
                        alert('Maaf, tahun NIM anda tidak tersedia. Silahkan menghubungi panitia.');
                        window.history.go(-1);
                    </script>";
            } else {
                if (upload_photo('img_mhs', getcwd() . '/resource/mahasiswa/foto_mhs/', $data['npm'])) {
                    //echo "<br/>oke".BASE_URL;
                    if (db_insert($def_table, $data)) {
                        //echo "<br/>oke".BASE_URL;
                        $_SESSION['success_npm'] = $data['npm'];
                        $_SESSION['success_passwd'] = $passwd;
                        $cache->clear_cached();
                        //alert('SUKSES');
                        sendEmail($data['npm'], $data['email'], $data['nama'], $passwd);
                        //header("location:".base_url('media.php?page=result_reg'));
                        echo "<script>location.href='" . BASE_URL . "media.php?page=result_reg';</script>";
                    } else {
                        if (strpos($_SESSION['err_message'], "Duplicate") > -1) {
                            echo "<script>
                        alert('Maaf, NIM anda sudah terdaftar');
                        window.history.go(-1);
                    </script>";
                        } else {
                            echo "<script>
                        alert('Maaf, Ada yang salah dengan data ANDA! cek kembali');
                        window.history.go(-1);
                    </script>";
                            //echo "<script>
                            //alert('Maaf,  ".$_SESSION['err_message']."');
                            //window.history.go(-1); </script>";
                        }
                    }
                } else {
                    echo "<script>
                        alert('Maaf, " . $_SESSION['err_message'] . "');
                        window.history.go(-1);
                    </script>";
                }
            }
        } else {
            echo "<script>
                        //alert('Maaf sedang perbaikan');
                        alert('Maaf, Pendaftaran PPM tahun " . get_active_year() . " sudah ditutup.');
                        window.location.href = '" . base_url() . "';
                    </script>";
        }
    } elseif ($op == "read") {
        $thn = (isset($_GET['th'])) ? cleanchar($_GET['th']) : null;
        if (!is_null($thn)) {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi")) {
                $cache->clear_cached();
                $data = get_data_cache($def_table . '_' . $op . '_' . $thn, "select npm,nama,hp,konfirmasi from $def_table where id_thn='" . $thn . "'");
                //$data = clearstatcache($def_table.'_'.$op.'_'.$thn,"select npm,nama,hp,konfirmasi from $def_table where id_thn='".$thn."'");
                echo $data;
            } else {
                echo 'dilarang mengakses halaman ini.';
            }
        } else if (!is_null($id)) {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi" or $match)) {
                echo json_encode(db_read("select * from $def_table where npm='$id' and id_thn='" . get_id_active_year() . "'"));
            } else {
                echo 'Tidak diperkenankan mengakses halaman ini.';
            }
        } else {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi")) {
                $cache->clear_cached();
                $data = get_data_cache($def_table . '_' . $op . '_' . get_year(get_active_year()), "select * from $def_table where id_thn='" . get_year(get_active_year()) . "'");
                echo $data;
                echo json_encode(db_read("select * from $def_table where id_thn='" . get_year(get_active_year()) . "'"));
            } else {
                echo 'anda tidak diperkenankan mengakses halaman ini.';
            }
        }
    } elseif ($op == "read_spesial") {

        $thn = (isset($_GET['th'])) ? cleanchar($_GET['th']) : null;
        $sekarang = get_id_active_year();

        if (!is_null($thn)) {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi")) {
                $table = <<<EOT
 (
    select * from $def_table where id_thn='$thn'
 ) temp
EOT;
            }
        } else if (!is_null($id)) {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi" or $match)) {
                $table = <<<EOT
 (
    select * from $def_table where npm='$id' and id_thn='$sekarang'
 ) temp
EOT;
            }
        } else {
            if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or  $_SESSION['logged_as'] == "ddi")) {
                $table = <<<EOT
 (
    select * from $def_table where id_thn='$sekarang'
 ) temp
EOT;
            }
        }



        // Table's primary key
        $primaryKey = 'npm';
        // indexes `npm`, `id_negara`, `id_daerah`, `id_kab`, `id_thn`, `id_prodi`, `id_kelompok`, `nama`, `password`, `api_token`, `remember_token`, `alamat_asal`, `rw`, `rt`, `kecamatan`, `alamat_yk`, 
        // `email`, `hp`, `jk`, `id_agama`, `kode_pos`, `tempat_lahir`, `tgl_lahir`, `slta_asal`, `konfirmasi`, `survey`, `role`, `create_at`, `update_at`
        $columns = array(
            array('db' => 'npm', 'dt' => 'npm'),
            array('db' => 'id_negara',  'dt' => 'id_negara'),
            array('db' => 'id_daerah',  'dt' => 'id_daerah'),
            array('db' => 'id_kab',  'dt' => 'id_kab'),
            array('db' => 'id_thn',  'dt' => 'id_thn'),
            array('db' => 'id_prodi', 'dt' => 'id_prodi'),
            array('db' => 'id_kelompok', 'dt' => 'id_kelompok'),
            array('db' => 'nama', 'dt' => 'nama'),
            array('db' => 'api_token', 'dt' => 'api_token'),
            array('db' => 'remember_token', 'dt' => 'remember_token'),
            array('db' => 'alamat_asal', 'dt' => 'alamat_asal'),
            array('db' => 'rw', 'dt' => 'rw'),
            array('db' => 'rt', 'dt' => 'rt'),
            array('db' => 'kecamatan', 'dt' => 'kecamatan'),
            array('db' => 'alamat_yk', 'dt' => 'alamat_yk'),
            array('db' => 'email', 'dt' => 'email'),
            array('db' => 'hp', 'dt' => 'hp'),
            array('db' => 'jk', 'dt' => 'jk'),
            array('db' => 'id_agama', 'dt' => 'id_agama'),
            array('db' => 'kode_pos', 'dt' => 'kode_pos'),
            array('db' => 'tempat_lahir', 'dt' => 'tempat_lahir'),
            array('db' => 'tgl_lahir', 'dt' => 'tgl_lahir'),
            array('db' => 'slta_asal', 'dt' => 'slta_asal'),
            array('db' => 'konfirmasi', 'dt' => 'konfirmasi'),
            array('db' => 'survey', 'dt' => 'survey'),
            array('db' => 'role', 'dt' => 'role'),
            array('db' => 'create_at', 'dt' => 'create_at'),
            array('db' => 'update_at', 'dt' => 'update_at'),
        );
        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    } elseif ($op == "read_sumaries") {
        $thn = (isset($_GET['th'])) ? cleanchar($_GET['th']) : get_year(get_active_year());
        echo json_encode(db_read("select (select count(npm) from mahasiswa where id_thn=" . $thn . ") as total, (select count(npm) from mahasiswa where konfirmasi='Y' and id_thn=" . $thn . ") as konfirmasi, (select count(npm) from mahasiswa where konfirmasi='N' and id_thn=" . $thn . ") as belum"));
    } elseif ($op == "update") {
        echo "ok";
        if (!is_null($id)) {
            echo "ok1";
            if (db_update($def_table, $data, array("npm" => $_SESSION['username']))) {
                //echo $_SESSION['username'];
                if ($_FILES['img_mhs']['name'] != "") {
                    if (upload_photo('img_mhs', getcwd() . '/resource/mahasiswa/foto_mhs/', $id)) {
                        if ($_SESSION['logged_as'] == "mahasiswa") {
                            echo "<script>
                            alert('Berhasil Disimpan.');
                            location.href='" . BASE_URL . rules('data_mhs_current') . "';
                              </script>";
                            //echo "<script>
                            //  alert('Berhasil Disimpan.');
                            //location.href='".BASE_URL."media.php?page=data_mhs_current';
                            //</script>";
                        } else {
                            echo "<script>
                                alert('Berhasil Disimpan.');
                                location.href='" . BASE_URL . "media.php?page=data_mhs';
                              </script>";
                        }
                    } else {
                        echo "<script>
                        alert('" . $_SESSION['err_message'] . "');
                        window.history.go(-1);
                    </script>";
                    }
                } else {
                    if ($_SESSION['logged_as'] == "mahasiswa") {
                        echo "<script>
                                alert('Berhasil Disimpan.');
                                location.href='" . rules('data_mhs_current') . "';
                              </script>";
                    } else {
                        echo "<script>
                                alert('Berhasil Disimpan.');
                                location.href='" . BASE_URL . "media.php?page=data_mhs';
                              </script>";
                    }
                }
            } else {
                if ($_SESSION['err_message'] == "") {
                    if (upload_photo('img_mhs', getcwd() . '/resource/mahasiswa/foto_mhs/', $id)) {
                        if ($_SESSION['logged_as'] == "mahasiswa") {
                            echo "<script>
                                alert('Berhasil Disimpan.');
                                location.href='" . rules('data_mhs_current') . "';
                              </script>";
                        } else {
                            echo "<script>
                                alert('Berhasil Disimpan.');
                                location.href='" . BASE_URL . "media.php?page=data_mhs';
                              </script>";
                        }
                    } else {
                        echo "<script>
                            alert('" . $_SESSION['err_message'] . "');
                            window.history.go(-1);
                        </script>";
                    }
                } else {
                    echo "<script>
                        alert('" . $_SESSION['err_message'] . "');
                        window.history.go(-1);
                    </script>";
                }
            }
        }
    } elseif ($op == "delete") {
        if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) {
            if (!is_null($id)) {
                if (db_delete($def_table, array("npm" => $id))) {
                    unlink(getcwd() . '/resource/mahasiswa/foto_mhs/' . $id . '.jpg');
                    $cache->clear_cached();
                    echo "true";
                } else {
                    echo $_SESSION['err_message'];
                }
            }
        } else {
            echo 'anda tidak diperkenankan mengakses halaman ini.';
        }
    } elseif ($op == "conf") {
        if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) {
            if (!is_null($id)) {
                if (!isset($_GET['xhr'])) {
                    if (db_update($def_table, array("konfirmasi" => "Y"), array("npm" => $id))) {
                        $cache->clear_cached();

                        echo "<script>
                        onClick=\"alert('Jalan!')\"
                        window.location.href = '" . BASE_URL . "media.php?page=data_mhs';
                        </script>";
                    }
                } else {

                    $d_t = "";
                    if (db_update($def_table, array("konfirmasi" => "Y"), array("npm" => $id, "konfirmasi" => "N"))) {
                        $d_t = array(
                            'npm' => $id,
                            'message' => "Berhasil melakukan konfirmasi",
                            'class' => "alert alert-success"
                        );
                        /*echo "<script>
                        onClick=\"alert('Jalan!')\"
                        </script>";*/
                        $cache->clear_cached();
                    } else {
                        $d_t = array(
                            'npm' => $id,
                            'message' => " Gagal melakukan konfirmasi atau sudah dikonfirmasi",
                            'class' => "alert alert-danger"
                        );
                    }
                    echo json_encode($d_t);
                }
            }
        } else {
            echo "<script>
                        alert('Anda tidak diperkenankan melakukan aksi ini.');
                </script>";
        }
    } elseif ($op == "reset_passwd") {
        // $npm = isset($_POST['npm']) ? cleanchar($_POST['npm']) : isset($_GET['id']) ? cleanchar($_GET['id']) : null;
        $npm = isset($_POST['npm']) ? cleanchar($_POST['npm']) : $_GET['id'];
        if (!is_null($npm)) {
            $query = "select npm from $def_table where npm='" . $npm . "'";
            // echo $npm;

            if (count(db_read("select npm from $def_table where npm='" . $npm . "'")) > 0) {
                $new_passwd = "ppmamikom";
                if (db_update($def_table, array("password" => md5($new_passwd)), array("npm" => $npm))) {
                    if (!isset($_GET['xhr'])) {
                        echo "true";
                    } else {
                        echo json_encode(array(
                            'npm' => $npm,
                            'message' => "Berhasil melakukan reset Password pada user dengan npm " . $npm . " password baru : <b>" . $new_passwd . "</b>",
                            'class' => "alert alert-success"
                        ));
                    }
                } else {
                    if (!isset($_GET['xhr'])) {
                        if ($_SESSION['err_message'] == "") {
                            echo "Password sudah di-reset menjadi <b>$new_passwd</b>";
                        } else {
                            echo $_SESSION['err_message'];
                        }
                    } else {
                        echo json_encode(array(
                            'npm' => $id,
                            'message' => " Gagal Reset Password karena sudah disereset menjadi <b>" . $new_passwd . "</b>",
                            'class' => "alert alert-danger",
                            'detail' => $_SESSION['err_message']
                        ));
                    }
                }
            } else {
                if (!isset($_GET['xhr'])) {
                    echo "Maaf, NPM $npm tidak ditemukan.";
                } else {
                    echo json_encode(array(
                        'npm' => $id,
                        'message' => "Maaf, NPM $id tidak ditemukan.",
                        'class' => "alert alert-danger",
                        'detail' => $_SESSION['err_message']
                    ));
                }
            }
        } else {
            if (!isset($_GET['xhr'])) {
                echo "Tuliskan NPM terlebih dahulu!";
            } else {
                echo json_encode(array(
                    'message' => "Tuliskan NPM terlebih dahulu!",
                    'class' => "alert alert-danger"
                ));
            }
        }
    } elseif ($op == "reset_mhs") {
        $npm = cleanchar($_POST['npm']);
        if (!is_null($npm)) {
            if (count(db_read("select npm from $def_table where npm='" . $npm . "' and id_thn != '" . get_year(get_active_year()) . "'")) > 0) {
                $new_passwd = "ppmamikom";
                if (db_update($def_table, array("password" => md5($new_passwd), "id_thn" => get_year(get_active_year())), array("npm" => $npm))) {
                    echo "true";
                } else {
                    if ($_SESSION['err_message'] == "") {
                        echo "Mahasiswa sudah di daftarkan kembali dengan Password baru : <b>$new_passwd</b>";
                    } else {
                        echo $_SESSION['err_message'];
                    }
                }
            } else {
                echo "Maaf, NPM $npm tidak ditemukan ppm tahun sebelumnya.";
            }
        } else {
            echo "Tuliskan NPM terlebih dahulu!";
        }
    } elseif ($op == "aktifkan_tahun_ini") {
        $npm = isset($_POST['npm']) ? cleanchar($_POST['npm']) : $_GET['id'];
        if (!is_null($npm)) {
            if (count(db_read("select npm from $def_table where npm='" . $npm . "'")) > 0) {
                if (db_update($def_table, array("id_thn" => get_year(get_active_year())), array("npm" => $npm))) {
                    if (!isset($_GET['xhr'])) {
                        echo "true";
                    } else {
                        echo json_encode(array(
                            'npm' => $npm,
                            'message' => "Mahasiswa berhasi diaktifkan kembali pada tahun ini",
                            'class' => "alert alert-success"
                        ));
                    }
                } else {
                    if (!isset($_GET['xhr'])) {
                        if ($_SESSION['err_message'] == "") {
                            echo "Mahasiswa berhasi diaktifkan kembali pada tahun ini";
                        } else {
                            echo $_SESSION['err_message'];
                        }
                    } else {
                        echo json_encode(array(
                            'npm' => $id,
                            'message' => "Mahasiswa berhasi diaktifkan kembali pada tahun ini",
                            'class' => "alert alert-danger",
                            'detail' => $_SESSION['err_message']
                        ));
                    }
                }
            } else {
                echo "Maaf, NPM $npm tidak ditemukan ppm tahun sebelumnya.";
            }
        } else {
            echo "Tuliskan NPM terlebih dahulu!";
        }
    } elseif ($op = "cert") {

        if ($_SESSION['login'] == 1 and ($_SESSION['logged_as'] == "super_admin" or $_SESSION['logged_as'] == "ddi")) {
            $today = strtotime(date('Y-m-d'));
            $jadwal = db_read("SELECT max(tgl_selesai) as akhir FROM acara_tahun WHERE id_thn = " . get_id_active_year());
            $akhir = strtotime($jadwal[0]['akhir']);
            if ($today > $akhir) {
                if (db_free_query("CALL `div_cert`(" . get_id_active_year() . ")")) {
                    echo "TRUE";
                } else {
                    echo $_SESSION['err_message'];
                }
            } else {
                echo "Belum Waktunya untuk membagikan sertifikat.";
            }
        } else {
            echo "Anda tidak diperkenankan melakukan aksi ini.";
        }
    } else {

        include "error/page_404.php";
    }
}
