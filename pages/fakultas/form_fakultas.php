<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_fakultas"); ?>" method="post" class="form-group-sm" id="form_fakultas">
            <div class="form-group">
                <label for="nama_fakultas">Fakultas</label>
                <input type="text" name="nama_fakultas" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_fakultas" id="status" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_fakultas" id="status" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_fakultas">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_fakultas">Batal</button>
        </form>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_fakultas">
        <thead>
            <tr>
                <th>Nama fakultas</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = db_read("select * from fakultas");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_fakultas']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_fakultas")."&id=".$value['id']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_fakultas")."&id=".$value['id']."' class='delete'>Hapus</a>
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
        $("#table_fakultas").DataTable();
        $("#form_fakultas").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_fakultas").attr("disabled","disabled");
                    $("#simpan_fakultas").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_fakultas").removeAttr("disabled");
                    $("#simpan_fakultas").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_fakultas").click(function(){
            $("#form_fakultas").attr("action","<?php echo rules('act_insert_fakultas'); ?>");
            $("#simpan_fakultas").html("Tambahkan");
        });
        
        $("#table_fakultas").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_fakultas]").val(value['nama_fakultas']);
                    if(value['status'] == "Y"){
                        $("input[name=status_fakultas]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_fakultas]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#form_fakultas").attr("action",url.replace("read","update"));
            $("#simpan_fakultas").html("Perbarui");
            return false;
        });

        $("#table_fakultas").on('click','.delete', function(){
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
