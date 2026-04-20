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
        
        /* Modern Sidebar Menu */
        .navi .nav-pills > li > a {
            color: #475569;
            font-weight: 500;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            border: none !important;
        }
        .navi .nav-pills > li.active > a,
        .navi .nav-pills > li.active > a:hover,
        .navi .nav-pills > li.active > a:focus {
            background-color: var(--primary) !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(57, 10, 97, 0.2);
        }
        .navi .nav-pills > li > a:hover {
            background-color: #f1f5f9;
            color: var(--primary);
            transform: translateX(5px);
        }
        .navi .nav-pills i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        /* Responsive Admin Layout */
        .mobile-header {
            display: none;
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 768px) {
            .mobile-header { display: flex; }
            .admin-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                width: 280px;
                height: 100vh;
                z-index: 1001;
                transition: all 0.3s ease;
                overflow-y: auto;
            }
            body.sidebar-open .admin-sidebar {
                left: 0;
            }
            .admin-sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 1000;
            }
            body.sidebar-open .admin-sidebar-overlay {
                display: block;
            }
            .admin-main {
                padding: 15px;
                width: 100%;
            }
            .admin-dashboard-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="d-flex align-items-center">
            <img src="resource/assets/images/Logo_Amikom_color.png" alt="Logo" style="height: 30px; margin-right: 10px;">
            <h6 style="margin: 0; font-weight: bold; color: var(--primary);">PPM ADMIN</h6>
        </div>
        <button id="sidebarToggle" class="btn btn-link" style="color: var(--primary); font-size: 20px; padding: 0;">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 col-sm-4 admin-sidebar">
                <div class="admin-brand hidden-xs">
                    <img src="resource/assets/images/Logo_Amikom_color.png" alt="Logo">
                    <h5 style="color: var(--primary); font-weight: bold; margin-top: 10px;">PPM ADMIN</h5>
                </div>
                <?php include "pages/layouts/left.php"; ?>
            </div>

            <!-- Content -->
            <div class="col-md-10 col-sm-8 admin-main">
                <div class="admin-dashboard-header d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: #fff; padding: 15px 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <h4 style="margin: 0; font-weight: bold; color: #333;">
                        <i class="fa fa-dashboard text-muted"></i> 
                        <?= is_null($page) ? 'Main Dashboard' : 'Manajemen Data' ?>
                    </h4>
                    <div>
                        <span class="text-muted mr-3">Welcome, <strong><?= $_SESSION['fullname'] ?? $_SESSION['username'] ?? 'Admin' ?></strong></span>
                        <a href="logout.php" class="btn btn-sm btn-danger" style="margin-left: 15px; border-radius: 8px;">Keluar</a>
                    </div>
                </div>
                
                <div class="content-wrapper">
                    <?php include "pages/layouts/right.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebarToggle, #sidebarOverlay').on('click', function() {
                $('body').toggleClass('sidebar-open');
            });
        });
    </script>
</body>
</html>
