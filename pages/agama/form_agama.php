<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_agama"); ?>" method="post" class="form-group-sm" id="formAgama">
            <div class="form-group">
                <label for="nama_agama">Agama</label>
                <input type="text" name="nama_agama" id="nama_agama" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_agama" id="status" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_agama" id="status" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_agama">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_agama">Batal</button>
        </form>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_agama">
            <tr>
                <th>Nama Agama</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from agama");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_agama']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_agama")."&id=".$value['id_agama']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_agama")."&id=".$value['id_agama']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formAgama").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_agama").attr("disabled","disabled");
                    $("#simpan_agama").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_agama").removeAttr("disabled");
                    $("#simpan_agama").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_agama").click(function(){
            $("#formAgama").attr("action","<?php echo rules('act_insert_klg'); ?>");
            $("#simpan_agama").html("Tambahkan");
        });

        $("#table_agama").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_agama]").val(value['nama_agama']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_agama]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_agama]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formAgama").attr("action",url.replace("read","update"));
            $("#simpan_agama").html("Perbarui");
            return false;
        });

        $("#table_agama").on('click','.delete', function(){
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
