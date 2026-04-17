<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_kab"); ?>" method="post" class="form-group-sm" id="formKab">
            <div class="form-group">
                <label for="nama_kab">Nama Kabupaten</label>
                <input type="text" name="nama_kab" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="negara">Negara</label>
                <select class="form-control" name="negara" required>
                    <option value="">-- Pilih --</option>
                    <?php
                    $sql = db_read("select id_negara,nama_negara from negara order by nama_negara asc");
                    foreach ($sql as $key => $value) {
                        echo "<option value='".$value['id_negara']."'>".$value['nama_negara']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="daerah">Provinsi</label>
                <select class="form-control" name="daerah" required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_kab" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_kab" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_kab">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_kab">Batal</button>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <table class="table table-striped table-bordered" width="100%" cellspacing="0" id="table_kab">
            <thead>
                <tr>
                    <th>Kabupaten</th>
                    <th>Provinsi</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = db_read("select * from vkabupaten order by nama_daerah asc");
                    foreach ($sql as $key => $value) {
                        echo "<tr>
                                <td>".$value['nama_kab']."</td>
                                <td>".$value['nama_daerah']."</td>
                                <td>".$value['status']."</td>
                                <td>
                                    <a href='".rules("act_read_kab")."&id=".$value['id_kab']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_kab")."&id=".$value['id_kab']."' class='delete'>Hapus</a>
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

        $("#table_kab").DataTable();

        $("select[name=negara]").change(function(){
            $.get("<?php echo rules('get_provinsi'); ?>"+"&negara="+$(this).val(), function(data, status){
                var json = $.parseJSON(data);
                var res = "<option value=''>-- Pilih --</option>";

                $.each(json, function(key,value){
                    res += "<option value='" + value['id_daerah'] + "'>" + value['nama_daerah'] + "</option>";
                })

                $("select[name=daerah]").html(res);
            });
        });

        $("#formKab").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_daerah").attr("disabled","disabled");
                    $("#simpan_daerah").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_daerah").removeAttr("disabled");
                    $("#simpan_daerah").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_kab").click(function(){
            $("#formKab").attr("action","<?php echo rules('act_insert_kab'); ?>");
            $("#simpan_kab").html("Tambahkan");
        });

        $("#table_kab").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_kab]").val(value['nama_kab']);
                    $("select[name=negara]").val(value['id_negara']),
                    $.get("<?php echo rules('get_provinsi'); ?>"+"&negara="+value['id_negara'], function(data, status){
                        var json = $.parseJSON(data);
                        var res = "<option value=''>-- Pilih --</option>";

                        $.each(json, function(k,v){
                            if(v['id_daerah'] == value['id_daerah']){
                                res += "<option value='" + v['id_daerah'] + "' selected>" + v['nama_daerah'] + "</option>";
                            }else{
                                res += "<option value='" + v['id_daerah'] + "'>" + v['nama_daerah'] + "</option>";
                            }
                        })

                        $("select[name=daerah]").html(res);
                    });

                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_kab]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_kab]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formKab").attr("action",url.replace("read","update"));
            $("#simpan_kab").html("Perbarui");
            return false;
        });

        $("#table_kab").on('click','.delete', function(){
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
