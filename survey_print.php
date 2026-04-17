<?php include "lib/db_lib.php"; ?>
<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Hasil Survey</title>
    <style type="text/css" media="all">
        .container{
            width: 980px;
            margin: 0 auto;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table tr td, table tr th{
            padding: 10px;
        }

        table tr td:nth-child(2){
            text-align: center;
        }

        .printbreak {
            page-break-after: always;
        }

        h1{
            text-align: justify;
        }

        @page{size:auto; margin-bottom:5mm;}
    </style>
    <script src="resource/assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            window.print();

        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Hasil Survey PPM 2017</h1>
        <table id="answer" width="100%">
            <tr>
                <th>Nama</th>
                <th>NPM</th>
                <th>Jawaban</th>
            </tr>
            <?php
                $sql = db_read("select * from vkuisioneranswer where id_thn='".get_year(get_active_year())."'");
                foreach ($sql as $k => $v){
                    echo "<tr>".
                            "<td>$v[nama]</td>".
                            "<td>$v[npm]</td>".
                            "<td>".
                                "<b>1) Apakah kegiatan PPM 2017 ini berjalan sukses dan alasanya?</b><br/>".
                                $v['opsi_1'] . ", " . $v['alasan_1'] . "<br />" .
                                "<b>2) Kinerja panitia dalam melaksanakan kegiatan PPM 2017?</b><br/>".
                                $v['opsi_3'] . "<br />" .
                                "<b>3) Pengalaman yang paling menyenangkan selama PPM 2017?</b><br/>".
                                $v['alasan_4'] . "<br />" .
                                "<b>4) Pengalaman yang tidak menyenangkan selama PPM 2017?</b><br/>".
                                $v['alasan_5'] . "<br />" .
                                "<b>5) Secara umum bagaimana perasaan Anda telah mengikuti PPM 2017?</b><br/>".
                                $v['alasan_6'] . "<br />" .
                                "<b>6) Apa saja yang perlu diperbaiki dari kegiatan PPM 2017?</b><br/>".
                                $v['alasan_7'] . "<br />" .
                                "<b>7) Pesan dan Kesan selama mengikuti kegiatan PPM 2017</b><br/>".
                                $v['alasan_8'] . "<br />"
                            ."</td>"
                        ."</tr>";
                }
            ?>
        </table>
    </div>
</body>
</html>
