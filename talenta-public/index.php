<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$user = 'ppm_2020';
$pass = '';
$db   = 'ppm_2020'; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil filter dari GET
$prodi_filter = $_GET['prodi'] ?? '';
$lv_prestasi = $_GET['level_prestasi'] ?? '';
$angkatan_min = $_GET['angkatan_min'] ?? date("Y");
$angkatan_max = $_GET['angkatan_max'] ?? date("Y");

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Optional: tingkatkan batas GROUP_CONCAT jika data banyak
$conn->query("SET SESSION group_concat_max_len = 10000");

// Query gabungan
$sql = "
    SELECT 
        m.npm,
        m.nama,
        GROUP_CONCAT(DISTINCT p.potensi SEPARATOR ', ') AS potensi,
        GROUP_CONCAT(DISTINCT CONCAT(pr.nama_prestasi, ' (<b>', pr.cak_prestasi, '</b>)') SEPARATOR ', ') AS prestasi
    FROM 
        mahasiswa m
    LEFT JOIN 
        potensi p ON m.npm = p.npm
    LEFT JOIN 
        prestasi pr ON m.npm = pr.npm
    WHERE (p.potensi IS NOT NULL OR pr.nama_prestasi IS NOT NULL)  
";



// Tambahkan filter jika ada input
if ($prodi_filter !== '') {
    $sql .= " AND SUBSTRING(m.npm, 4, 2) = '$prodi_filter' ";
}
if ($angkatan_min !== '') {
    $sql .= " AND LEFT(m.npm,2) >= ".substr($angkatan_min, -2);
}
if ($angkatan_max !== '') {
    $sql .= " AND LEFT(m.npm,2) <= ".substr($angkatan_max, -2);
}
if ($lv_prestasi !== '') {
    $sql .= " AND pr.cak_prestasi = '$lv_prestasi'";
}

$sql .= " GROUP BY m.npm";

// echo "<pre>$sql</pre>";

$result = $conn->query($sql);



$sql_prodi = "SELECT * FROM `prodi` ORDER BY `prodi`.`nama_prodi` ASC";
$result_prodi = $conn->query($sql_prodi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencarian Talenta dan Prestasi Mahasiswa PPM</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Pencarian Talenta dan Prestasi Mahasiswa PPM</h2>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="prodi" class="form-label">Program Studi</label>
            <select class="form-select" name="prodi" id="prodi">
                
                <option value="" <?= $prodi_filter == '' ? 'selected' : '' ?>>--Semua--</option>
                
            <?php 
            while ($row = $result_prodi->fetch_assoc()): ?>
            
                <option value="<?= $row['kode'] ?>" <?= $prodi_filter == $row['kode'] ? 'selected' : '' ?>><?= $row['nama_prodi'] ?></option>
                
            <?php 
            endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="angkatan_min" class="form-label">Tahun Angkatan Minimal</label>
            <input type="number" class="form-control" name="angkatan_min" id="angkatan_min" min="2020" 
                   value="<?= htmlspecialchars($angkatan_min) ?>">
        </div>
        <div class="col-md-2">
            <label for="angkatan_max" class="form-label">Tahun Angkatan Maksimal</label>
            <input type="number" class="form-control" name="angkatan_max" id="angkatan_max"  min="2020" 
                   value="<?= htmlspecialchars($angkatan_max) ?>">
        </div>
        <div class="col-md-2">
            <label for="level" class="form-label">Level Prestasi</label>
            <select class="form-select" name="level_prestasi" id="level_prestasi">
            
                <option value="" <?= $lv_prestasi == '' ? 'selected' : '' ?>>--Semua--</option>
                <option value="Internasional" <?= $lv_prestasi == 'Internasional' ? 'selected' : '' ?>>Internasional</option>
                <option value="Nasional" <?= $lv_prestasi == 'Nasional' ? 'selected' : '' ?>>Nasional</option>
                <option value="Region" <?= $lv_prestasi == 'Region' ? 'selected' : '' ?>>Region</option>
                <option value="Lokal" <?= $lv_prestasi == 'Lokal' ? 'selected' : '' ?>>Lokal</option>
                
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <?php if ($_GET): ?>
        <table id="tabel_mahasiswa" class="display table table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Potensi</th>
                <th>Prestasi</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= htmlspecialchars($row['npm']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['potensi'] ?? '-') ?></td>
                    <td><?= $row['prestasi'] ?? '-' ?></td>
                </tr>
            <?php 
            $no++;
            endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tabel_mahasiswa').DataTable();
    });
</script>
</body>
</html>
