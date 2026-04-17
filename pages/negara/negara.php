<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_negara"); ?>" method="post" class="form-group-sm" id="formNegara">
            <div class="form-group">
                <label for="nama_negara">Nama Negara</label>
                <input type="text" name="nama_negara" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_negara" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_negara" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_negara">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_negara">Batal</button>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <table class="table table-striped table-bordered" width="100%" cellspacing="0" id="table_negara">
            <thead>
                <tr>
                    <th>Nama Negara</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = db_read("select * from negara");
                    foreach ($sql as $key => $value) {
                        echo "<tr>
                                <td>".$value['nama_negara']."</td>
                                <td>".$value['status']."</td>
                                <td>
                                    <a href='".rules("act_read_negara")."&id=".$value['id_negara']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_negara")."&id=".$value['id_negara']."' class='delete'>Hapus</a>
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

        $("#table_negara").DataTable();

        $("#formNegara").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_negara").attr("disabled","disabled");
                    $("#simpan_negara").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_negara").removeAttr("disabled");
                    $("#simpan_negara").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_negara").click(function(){
            $("#formNegara").attr("action","<?php echo rules('act_insert_negara'); ?>");
            $("#simpan_negara").html("Tambahkan");
        });

        $("#table_negara").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_negara]").val(value['nama_negara']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_negara]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_negara]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formNegara").attr("action",url.replace("read","update"));
            $("#simpan_negara").html("Perbarui");
            return false;
        });

        $("#table_negara").on('click','.delete', function(){
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
