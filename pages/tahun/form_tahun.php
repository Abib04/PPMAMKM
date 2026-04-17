<div class="row">
    <div class="col-md-4">
        <form action="<?php echo rules("act_insert_thn"); ?>" method="post" class="form-group-sm" id="formTahun">
            <div class="form-group">
                <label for="thn">Tahun</label>
                <input type="text" name="thn" id="thn" maxlength="4" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Aktif</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_tahun" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_tahun" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_tahun">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_tahun">Batal</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered" id="table_tahun">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = db_read("select * from tahun order by thn asc");
                    foreach($sql as $val){
                        echo "<tr>
                                <td>$val[thn]</td>
                                <td>$val[status]</td>
                                <td>
                                    <a href='".rules("act_read_thn")."&id=".$val['id_thn']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_thn")."&id=".$val['id_thn']."' class='delete'>Hapus</a>
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

        function ajaxSubmit(method, data, target){
            $.ajax({
                type: method,
                url: target,
                data: data
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_tahun").removeAttr("disabled");
                    $("#simpan_tahun").html("Tambahkan");
                }
            });
        }

        $("#formTahun").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $("#simpan_tahun").attr("disabled","disabled");
            $("#simpan_tahun").html("Menunggu...");

            if($("input[name=status_tahun]").val() == "Y"){
                $.get("data.php?module=mod_tahun&op=read&status=Y", function(response, status){
                    var json = $.parseJSON(response);
                    if(json.length > 0){
                        var c = confirm("Tahun lainnya ada yang aktif.\nJika anda tetap ingin melanjutkan, tahun lainnya akan di non-aktifkan.\n\nLanjutkan? ");

                        if(c){
                            $.post("<?php echo rules('act_update_thn'); ?>","status=N", function(response, status){
                                if(response == "true"){
                                    ajaxSubmit(method, data, target);
                                }else{
                                    alert(response);
                                    $("#simpan_tahun").removeAttr("disabled");
                                    $("#simpan_tahun").html("Tambahkan");
                                }
                            });
                        }else{
                            $("#simpan_tahun").removeAttr("disabled");
                            $("#simpan_tahun").html("Tambahkan");
                        }
                    }else{
                        ajaxSubmit(method, data, target);
                    }
                });
            }else{
                ajaxSubmit(method, data, target);
            }

            return false;
        });

        $("#reset_tahun").click(function(){
            $("#formTahun").attr("action","<?php echo rules('act_insert_thn'); ?>");
            $("#simpan_tahun").html("Tambahkan");
        });

        $("#table_tahun").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=thn]").val(value['thn']);
                    $("input[name=status_tahun]:radio[value="+value['status']+"]").prop("checked",true);
                });
            });

            $("#formTahun").attr("action",url.replace("read","update"));
            $("#simpan_tahun").html("Perbarui");
            return false;
        });

        $("#table_tahun").on('click','.delete', function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin menghapus data ini?");
            if(c){
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
