<table>
    <tr>
        <td>Sudah survey </td>
        <td> : </td>
        <td><b><?php echo count(db_read("select npm from kuisioner where id_thn='".get_year(get_active_year())."'"));?></b></td>
    </tr>
</table>
<hr />
<a href="survey_print.php">Cetak Survey</a>
<br /><br />
<table class="table table-bordered table-hovered" id="tbl_answer">
    <thead>
    <tr>
        <th>NPM</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>NPM</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>
    </tfoot>
</table>

<div class="modal fade" id="detailAnswer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Jawaban</h4>
            </div>
            <div class="modal-body" id="answer"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var table = $("#tbl_answer").DataTable({
            "ajax":{
                "url" : "<?php echo BASE_URL; ?>data.php?module=mod_kuisioner&op=read",
                "dataSrc" : ""
            },
            "deferRender": true,
            "columns":[
                {"data":"npm"},
                {"data":"nama"},
                {"render":function(data, type, row){
                    return "<a href='#detailAnswer' class='detail' data-npm='"+row.npm+"' data-toggle='modal'>Detail</a> <a href='<?php echo rules('act_delete_kuisioner'); ?>&id="+row.npm+"' class='delete'>Hapus</a>";
                }}
            ]
        });

        $("#tbl_answer").on('click','.detail',function(){
            var npm = $(this).data('npm');
            var result = "";
            $.getJSON("<?php echo BASE_URL;?>data.php?module=mod_kuisioner&op=read&npm="+npm, function(data){
                result = "NPM : " + data[0].npm + "<br />" +
                        "Nama : " + data[0].nama + "<br />" + "<br />" +
                    "<p class='text-justify'>" +
                    "<b>1) Apakah kegiatan PPM 2017 ini berjalan sukses dan alasanya?</b><br/>" +
                    data[0].opsi_1 + ", " + data[0].alasan_1 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>2) Kinerja panitia dalam melaksanakan kegiatan PPM 2017?</b><br/>" +
                    data[0].opsi_3 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>3) Pengalaman yang paling menyenangkan selama PPM 2017?</b><br/>" +
                    data[0].alasan_4 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>4) Pengalaman yang tidak menyenangkan selama PPM 2017?</b><br/>" +
                    data[0].alasan_5 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>5) Secara umum bagaimana perasaan Anda telah mengikuti PPM 2017?</b><br/>" +
                    data[0].alasan_6 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>6) Apa saja yang perlu diperbaiki dari kegiatan PPM 2017?</b><br/>" +
                    data[0].alasan_7 +
                    "</p>" +
                    "<p class='text-justify'>" +
                    "<b>7) Pesan dan Kesan selama mengikuti kegiatan PPM 2017</b><br/>" +
                    data[0].alasan_8 +
                    "</p>";
                    "<p class='text-justify'>" +
                    "<b>8) Pesan dan Kesan selama mengikuti kegiatan PPM 2017</b><br/>" +
                    data[0].alasan_8 +
                    "</p>";

                $("#answer").html(result);
            });
        });

        $("#tbl_answer").on('click','.delete',function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin menghapus data ini?");
            if(c == true){
                $.get(url, function(data, status){
                    if(data == "true"){
                        alert("Berhasil dihapus.");
                        table.ajax.reload();
                    }else{
                        alert(data);
                        table.ajax.reload();
                    }
                });
            }

            return false;
        });
    });
</script>
