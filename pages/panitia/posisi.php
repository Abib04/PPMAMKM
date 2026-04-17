<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_panitia"); ?>&t=posisi_panitia" method="post" class="form-group-sm" id="formPosisi">
            <div class="form-group">
                <label for="nama_pp">Nama Posisi</label>
                <input type="text" name="nama_pp" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_pp" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_pp" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_pp">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_pp">Batal</button>
        </form>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_pp">
            <tr>
                <th>Nama Posisi</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from posisi_panitia order by nama_pp asc");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_pp']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_panitia")."&t=posisi_panitia&id=".$value['id_pp']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_panitia")."&t=posisi_panitia&id=".$value['id_pp']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formPosisi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_pp").attr("disabled","disabled");
                    $("#simpan_pp").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_pp").removeAttr("disabled");
                    $("#simpan_pp").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_pp").click(function(){
            $("#formPosisi").attr("action","<?php echo rules('act_insert_panitia'); ?>&t=posisi_panitia");
            $("#simpan_pp").html("Tambahkan");
        });

        $("#table_pp").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_pp]").val(value['nama_pp']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_pp]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_pp]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formPosisi").attr("action",url.replace("read","update"));
            $("#simpan_pp").html("Perbarui");
            return false;
        });

        $("#table_pp").on('click','.delete', function(){
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
