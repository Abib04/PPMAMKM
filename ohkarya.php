<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Cetak Presensi PPM</title>
    <style type="text/css" media="all">

        table tr:nth-child(even) td:last-child{
            text-align: left;
        }

        table tr:nth-child(odd) td:last-child{
            text-align: center;
        }

        .container{
            width: 980px;
            margin: 0 auto;
        }

        table tr td, table tr th{
            padding: 10px;
        }

        table tr td:first-child{
            text-align: center;
        }

        table tr td:nth-child(3){
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .printbreak {
            page-break-after: always;
        }

        @page{size:auto; margin-bottom:5mm;}

    </style>
    <script>
        window.print();
    </script>
</head>
<body>
    <div class="container">
        <center><b>Presensi Pengumpulan Karya PPM 2019</b></center>
            <br />
            <table width="100%">
                <tr style="padding: 20px;">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanda Tangan</th>
                </tr>
                <?php
                include "lib/db_lib.php";
                $no = 1;
                $sql = db_read("SELECT * FROM kelompok WHERE id BETWEEN 251 AND 387 ORDER BY nama_kelompok ASC");
                foreach ($sql as $key => $value) {
                    echo "<tr>
							<td>".$no."</td>
							<td>".strtoupper($value['nama_kelompok'])."</td>
							<td>".$no."</td>
						 </tr>";
                    $no++;
                }
                ?>
            </table>
                </div>
</body>
</html>
