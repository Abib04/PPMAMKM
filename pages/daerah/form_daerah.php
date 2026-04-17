<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_daerah"); ?>" method="post" class="form-group-sm" id="formProvinsi">
            <div class="form-group">
                <label for="nama_daerah">Nama Provinsi</label>
                <input type="text" name="nama_daerah" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="id_negara">Negara</label>
                <select name="id_negara" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <?php
                        $sql = db_read("select id_negara, nama_negara from negara order by nama_negara asc");
                        foreach ($sql as $key=>$value){
                            echo "<option value='".$value['id_negara']."'>".$value['nama_negara']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_daerah" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_daerah" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_daerah">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_daerah">Batal</button>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <table class="table table-striped table-bordered" width="100%" cellspacing="0" id="table_daerah">
            <thead>
                <tr>
                    <th>Nama Provinsi</th>
                    <th>Negara</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = db_read("select daerah.id_daerah, daerah.nama_daerah, negara.nama_negara, daerah.status from daerah join negara on negara.id_negara = daerah.id_negara order by nama_daerah asc") or die(mysqli_error($con));
                    foreach ($sql as $key => $value) {
                        echo "<tr>
                                <td>".$value['nama_daerah']."</td>
                                <td>".$value['nama_negara']."</td>
                                <td>".$value['status']."</td>
                                <td>
                                    <a href='".rules("act_read_daerah")."&id=".$value['id_daerah']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_daerah")."&id=".$value['id_daerah']."' class='delete'>Hapus</a>
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

        $("#table_daerah").DataTable();

        $("#formProvinsi").submit(function(){
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

        $("#reset_daerah").click(function(){
            $("#formProvinsi").attr("action","<?php echo rules('act_insert_daerah'); ?>");
            $("#simpan_daerah").html("Tambahkan");
        });

        $("#table_daerah").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_daerah]").val(value['nama_daerah']);
                    $("select[name=id_negara]").val(value['id_negara']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_daerah]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_daerah]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formProvinsi").attr("action",url.replace("read","update"));
            $("#simpan_daerah").html("Perbarui");
            return false;
        });

        $("#table_daerah").on('click','.delete', function(){
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
