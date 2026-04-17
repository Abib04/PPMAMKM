<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_klg"); ?>&t=hub_keluarga" method="post" class="form-group-sm" id="formHubKlg">
            <div class="form-group">
                <label for="nama_hub">Hubungan Keluarga</label>
                <input type="text" name="nama_hub" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_hub" id="status" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_hub" id="status" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_hubklg">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_hubklg">Batal</button>
        </form>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_hubklg">
            <tr>
                <th>Nama Hub. Kel.</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from hub_keluarga");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_hub_kel']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_klg")."&t=hub_keluarga&id=".$value['id_hub_kel']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_klg")."&t=hub_keluarga&id=".$value['id_hub_kel']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formHubKlg").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_hubklg").attr("disabled","disabled");
                    $("#simpan_hubklg").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_hubklg").removeAttr("disabled");
                    $("#simpan_hubklg").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_hubklg").click(function(){
            $("#formHubKlg").attr("action","<?php echo rules('act_insert_klg'); ?>");
            $("#simpan_hubklg").html("Tambahkan");
        });

        $("#table_hubklg").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_hub]").val(value['nama_hub_kel']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_hub]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_hub]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formHubKlg").attr("action",url.replace("read","update"));
            $("#simpan_hubklg").html("Perbarui");
            return false;
        });

        $("#table_hubklg").on('click','.delete', function(){
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
