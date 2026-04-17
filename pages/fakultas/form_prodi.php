<div class="row">
    <div class="col-xs-4">
        <form action="<?php echo rules("act_insert_prodi"); ?>" method="post" class="form-group-sm" id="formProdi">
            <div class="form-group">
                <label for="nama_prodi">Nama Prodi</label>
                <input type="text" name="nama_prodi" class="form-control" required/>
            </div>
            
            <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <select class="form-control" name="fakultas" required>
                    <option value="">-- Pilih --</option>
                    <?php
                    $sql = db_read("select id,nama_fakultas from fakultas order by nama_fakultas asc");
                    foreach ($sql as $key => $value) {
                        echo "<option value='".$value['id']."'>".$value['nama_fakultas']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="kode">Kode</label>
                <input name="kode" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jenjang</label>
                <br />
                <label class="radio-inline">
                    <input type="radio" name="jenjang_prodi" value="D3" />Diploma III
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="jenjang_prodi" value="S1" />Strata 1
                </label>
            </div>
            <div class="form-group">
                <label>Status</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_prodi" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_prodi" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_prodi">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_prodi">Batal</button>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <table class="table table-striped table-bordered" width="100%" cellspacing="0" id="table_prodi">
            <thead>
                <tr>
                    <th>Prodi</th>
                    <th>Jenjang</th>
                    <th>Fakultas</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = db_read("select * from vprodi order by nama_fakultas asc");
                    foreach ($sql as $key => $value) {
                        echo "<tr>
                                <td>".$value['nama_prodi']."</td>
                                <td>".$value['jenjang']."</td>
                                <td>".$value['nama_fakultas']."</td>
                                <td>".$value['status_prodi']."</td>
                                <td>
                                    <a href='".rules("act_read_prodi")."&id=".$value['id']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_prodi")."&id=".$value['id']."' class='delete'>Hapus</a>
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

        $("#table_prodi").DataTable();

        $("#formProdi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_prodi").attr("disabled","disabled");
                    $("#simpan_prodi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_prodi").removeAttr("disabled");
                    $("#simpan_prodi").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_prodi").click(function(){
            $("#formProdi").attr("action","<?php echo rules('act_insert_prodi'); ?>");
            $("#simpan_prodi").html("Tambahkan");
        });

        $("#table_prodi").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_prodi]").val(value['nama_prodi']);
                    $("input[name=kode]").val(value['kode']);
                    $("select[name=fakultas]").val(value['id_fakultas']);
                    if(value['jenjang'] == "D3"){
                        $("input[name=jenjang_prodi]:radio[value=D3]").prop("checked",true);
                    }else{
                        $("input[name=jenjang_prodi]:radio[value=S1]").prop("checked",true);
                    }
                    if(value['status'] == "Y"){
                        $("input[name=status_prodi]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_prodi]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formProdi").attr("action",url.replace("read","update"));
            $("#simpan_prodi").html("Perbarui");
            return false;
        });

        $("#table_prodi").on('click','.delete', function(){
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
