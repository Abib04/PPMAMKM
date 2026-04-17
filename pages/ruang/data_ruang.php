<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_ruang"); ?>" method="post" id="formRuang">
            <div class="form-group">
                <label for="nama_ruang">Nama Ruangan</label>
                <input type="text" name="nama_ruang" class="form-control" />
            </div>
            <div class="form-group">
                <label for="max_kuota">Maksimal Kuota</label>
                <input type="number" name="max_kuota" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_ruang">Simpan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_ruang">Batal</button>
        </form>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_ruang">
            <thead>
                <tr>
                    <th>Nama Ruangan</th>
                    <th>Maks. Kuota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = db_read("select * from ruang");
                    foreach($sql as $val){
                        echo "<tr>
                                <td>$val[nama_ruang]</td>
                                <td>$val[max_kuota]</td>
                                <td>
                                    <a href='".rules("act_read_ruang")."&id=".$val['id_ruang']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_ruang")."&id=".$val['id_ruang']."' class='delete'>Hapus</a>
                                </td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table_ruang").DataTable();
        $("#formRuang").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_ruang").attr("disabled","disabled");
                    $("#simpan_ruang").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_ruang").removeAttr("disabled");
                    $("#simpan_ruang").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_ruang").click(function(){
            $("#formruang").attr("action","<?php echo rules('act_insert_ruang'); ?>");
            $("#simpan_ruang").html("Tambahkan");
        });

        $("#table_ruang").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_ruang]").val(value['nama_ruang']);
                    $("input[name=max_kuota]").val(value['max_kuota']);
                });
            });

            $("#formRuang").attr("action",url.replace("read","update"));
            $("#simpan_ruang").html("Perbarui");
            return false;
        });

        $("#table_ruang").on('click','.delete', function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin menghapus data ini?");
            if(c == true){
                $.get(url, function(data, status){
                    if(data == "true"){
                        alert("Berhasil dihapus.");
                        location.reload();
                    }else{
                        alert(data);
                    }
                });
            }

            return false;
        });
    });
</script>
