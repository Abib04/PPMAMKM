<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_penyakit"); ?>&t=penyakit" method="post" class="form-group-sm" id="formPenyakit">
            <div class="form-group">
                <label for="nama_penyakit">Nama Penyakit</label>
                <input type="text" name="nama_penyakit" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_penyakit" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_penyakit" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_penyakit">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_penyakit">Batal</button>
        </form>
    <?php echo count(db_read("select npm from penyakit_mahasiswa where id_np='23' and id_tahun='10'"));?>
    </div>
    <div class="col-xs-8">
        <table class="table table-bordered" id="table_penyakit">
        <thead>
            <tr>
                <th>Nama penyakit</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = db_read("select * from penyakit order by nama_penyakit asc");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_penyakit']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_penyakit")."&t=penyakit&id=".$value['id_np']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_penyakit")."&t=penyakit&id=".$value['id_np']."' class='delete'>Hapus</a>
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
        $("#table_penyakit").DataTable();
        $("#formPenyakit").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_penyakit").attr("disabled","disabled");
                    $("#simpan_penyakit").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_penyakit").removeAttr("disabled");
                    $("#simpan_penyakit").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_penyakit").click(function(){
            $("#formPenyakit").attr("action","<?php echo rules('act_insert_penyakit'); ?>&t=penyakit");
            $("#simpan_penyakit").html("Tambahkan");
        });

        $("#table_penyakit").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_penyakit]").val(value['nama_penyakit']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_penyakit]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_penyakit]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formPenyakit").attr("action",url.replace("read","update"));
            $("#simpan_penyakit").html("Perbarui");
            return false;
        });

        $("#table_penyakit").on('click','.delete', function(){
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
