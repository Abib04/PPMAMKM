<?php
include "lib/db_lib.php";
sess_start();
init_();

// Proteksi Halaman Admin
if (empty($_SESSION['login']) || $_SESSION['logged_as'] != "super_admin") {
    header("Location: " . base_url());
    exit();
}

$page = (isset($_GET['page'])) ? htmlspecialchars($_GET['page']) : NULL;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Dashboard | PPM AMIKOM</title>
    <link rel="shortcut icon" href="resource/assets/images/fav.png">
    <link rel="stylesheet" href="resource/assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="resource/assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="resource/assets/css/jquery.dataTables.min.css" type="text/css">
    <link rel="stylesheet" href="resource/assets/css/custom.css?v=<?php echo time(); ?>" type="text/css">
    <script src="resource/assets/js/jquery.min.js"></script>
    <script src="resource/assets/js/bootstrap.min.js"></script>
    <script src="resource/assets/js/jquery.dataTables.min.js"></script>
    <script src="resource/assets/js/dataTables.bootstrap.min.js"></script>
    <style>
        body { background: #f4f7f6; }
        .admin-sidebar { background: #fff; min-height: 100vh; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 20px; }
        .admin-main { padding: 30px; }
        .admin-brand { padding-bottom: 30px; border-bottom: 1px solid #eee; margin-bottom: 20px; text-align: center; }
        .admin-brand img { max-height: 50px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 col-sm-4 admin-sidebar">
                <div class="admin-brand">
                    <img src="resource/assets/images/Logo_Amikom_color.png" alt="Logo">
                    <h5 style="color: var(--primary); font-weight: bold; margin-top: 10px;">PPM ADMIN</h5>
                </div>
                <?php include "pages/layouts/left.php"; ?>
            </div>

            <!-- Content -->
            <div class="col-md-10 col-sm-8 admin-main">
                <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: #fff; padding: 15px 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <h4 style="margin: 0; font-weight: bold; color: #333;">
                        <i class="fa fa-dashboard text-muted"></i> 
                        <?= is_null($page) ? 'Main Dashboard' : 'Manajemen Data' ?>
                    </h4>
                    <div>
                        <span class="text-muted mr-3">Welcome, <strong><?= $_SESSION['fullname'] ?></strong></span>
                        <a href="logout.php" class="btn btn-sm btn-danger" style="margin-left: 15px; border-radius: 8px;">Keluar</a>
                    </div>
                </div>
                
                <div class="content-wrapper">
                    <?php include "pages/layouts/right.php"; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
