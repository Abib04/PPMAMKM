<?php
// Ambil Statistik
$thn_aktif = get_id_active_year();
$stats = db_read("SELECT 
    count(*) as total_mhs, 
    SUM(IF(konfirmasi='Y', 1, 0)) as confirmed, 
    SUM(IF(konfirmasi='N', 1, 0)) as unconfirmed 
    FROM mahasiswa WHERE id_thn = $thn_aktif");

$total_mhs = $stats[0]['total_mhs'];
$confirmed = $stats[0]['confirmed'];
$unconfirmed = $stats[0]['unconfirmed'];

$prodi_count = db_read("SELECT count(*) as total FROM prodi")[0]['total'];
?>

<div class="admin-dashboard">
    <div class="row">
        <!-- Card Total Mahasiswa -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="panel panel-primary" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="panel-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px;">
                    <i class="fa fa-users fa-3x mb-3"></i>
                    <h2 style="margin: 10px 0; font-weight: 800;"><?= number_format($total_mhs) ?></h2>
                    <p style="text-transform: uppercase; font-size: 12px; letter-spacing: 1px; opacity: 0.8;">Total Pendaftar</p>
                </div>
            </div>
        </div>

        <!-- Card Sudah Konfirmasi -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="panel panel-success" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="panel-body text-center" style="background: linear-gradient(135deg, #2af598 0%, #009efd 100%); color: white; padding: 30px 20px;">
                    <i class="fa fa-check-circle fa-3x mb-3"></i>
                    <h2 style="margin: 10px 0; font-weight: 800;"><?= number_format($confirmed) ?></h2>
                    <p style="text-transform: uppercase; font-size: 12px; letter-spacing: 1px; opacity: 0.8;">Sudah Konfirmasi</p>
                </div>
            </div>
        </div>

        <!-- Card Belum Konfirmasi -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="panel panel-warning" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="panel-body text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 30px 20px;">
                    <i class="fa fa-clock-o fa-3x mb-3"></i>
                    <h2 style="margin: 10px 0; font-weight: 800;"><?= number_format($unconfirmed) ?></h2>
                    <p style="text-transform: uppercase; font-size: 12px; letter-spacing: 1px; opacity: 0.8;">Belum Konfirmasi</p>
                </div>
            </div>
        </div>

        <!-- Card Total Prodi -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="panel panel-info" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="panel-body text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 30px 20px;">
                    <i class="fa fa-university fa-3x mb-3"></i>
                    <h2 style="margin: 10px 0; font-weight: 800;"><?= $prodi_count ?></h2>
                    <p style="text-transform: uppercase; font-size: 12px; letter-spacing: 1px; opacity: 0.8;">Program Studi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Quick Actions or Info -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-info" style="border-radius: 12px; background: rgba(52, 152, 219, 0.1); border: 1px solid rgba(52, 152, 219, 0.2); color: #2980b9;">
                <i class="fa fa-info-circle mr-2"></i> 
                Hai <strong><?= $_SESSION['username'] ?></strong>, selamat datang kembali di Panel Admin PPM AMIKOM. Anda memiliki kendali penuh untuk mengelola data pendaftar dan konfigurasi sistem.
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" style="border-radius: 15px; border: 1px solid #eee;">
                <div class="panel-heading" style="background: #f8f9fa; border-bottom: 1px solid #eee; font-weight: bold; border-radius: 15px 15px 0 0;">
                    Akses Cepat
                </div>
                <div class="panel-body">
                    <div class="list-group" style="margin-bottom: 0;">
                        <a href="?page=konfirmasi_npm" class="list-group-item" style="border-radius: 8px; margin-bottom: 5px; border: 1px solid #f0f0f0;">
                            <i class="fa fa-id-card-o text-primary mr-2"></i> Konfirmasi NIM Mahasiswa
                        </a>
                        <a href="?page=data_mhs_prestasi" class="list-group-item" style="border-radius: 8px; margin-bottom: 5px; border: 1px solid #f0f0f0;">
                            <i class="fa fa-trophy text-warning mr-2"></i> Kelola Data Prestasi
                        </a>
                        <a href="?page=data_admin" class="list-group-item" style="border-radius: 8px; border: 1px solid #f0f0f0;">
                            <i class="fa fa-user-plus text-success mr-2"></i> Manajemen Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" style="border-radius: 15px; border: 1px solid #eee;">
                <div class="panel-heading" style="background: #f8f9fa; border-bottom: 1px solid #eee; font-weight: bold; border-radius: 15px 15px 0 0;">
                    Status Sistem
                </div>
                <div class="panel-body text-center" style="padding: 25px;">
                    <div class="c-badge" style="display: inline-block; padding: 10px 20px; background: #e8f5e9; color: #2e7d32; border-radius: 50px; font-weight: bold; margin-bottom: 15px;">
                        <i class="fa fa-circle text-success mr-1"></i> Database Connected
                    </div>
                    <p class="text-muted small">Tahun Aktif: <strong><?= get_active_year() ?></strong></p>
                    <p class="text-muted small">Server Time: <?= date('d M Y, H:i') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard .panel-body i {
    opacity: 0.3;
    position: absolute;
    right: 20px;
    top: 20px;
}
.admin-dashboard .list-group-item:hover {
    background: #fcfcfc;
    transform: translateX(5px);
    transition: all 0.2s;
}
.mr-2 { margin-right: 10px; }
</style>
