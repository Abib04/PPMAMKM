<button class="btn btn-sm btn-primary" style="margin-bottom: 10px;" id="tambahAdmin">Tambah</button>
<div id="pageAdmin" style="margin-bottom: 10px;">
    <form action="<?php echo rules("act_insert_admin"); ?>" method="post" class="form-group-sm" id="formAdmin">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="user_level">User Level</label>
            <select name="user_level" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="super_admin">Super Admin</option>
                <option value="ddi">Data dan Informasi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password_">Password</label>
            <input class="form-control" name="password_" type="password" />
        </div>
        <div class="form-group">
            <label for="password_retype">Ketik Password Lagi</label>
            <input class="form-control" name="password_retype" type="password" />
        </div>
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <select name="tahun" class="form-control" required>
                <option value="">-- Pilih --</option>
                <?php
                    $sql = db_read("select * from tahun");
                    foreach($sql as $key=>$value){
                        echo "<option value='$value[id_thn]'>$value[thn]</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group" style="margin-bottom:33px">
            <label>Status : </label><br />
            <label class="radio-inline">
              <input type="radio" name="status_admin" value="Y"> Ya
            </label>
            <label class="radio-inline">
              <input type="radio" name="status_admin" value="N"> Tidak
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" id="simpan_admin">Simpan</button>
        <button type="reset" class="btn btn-default btn-sm" id="reset_admin">Batal</button>
    </form>
</div>
<table class="table table-hovered table-bordered" id="table_admin">
    <thead>
        <tr>
            <th>Username</th>
            <th>User Level</th>
            <th>Tahun</th>
            <th>Aktif</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Username</th>
            <th>User Level</th>
            <th>Tahun</th>
            <th>Aktif</th>
            <th>Aksi</th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
	$(document).ready(function(){
        var table = $("#table_admin").DataTable({
            "ajax":{
                "url" : "<?php echo BASE_URL; ?>data.php?module=mod_admin&op=read_full",
                "dataSrc" : ""
            },
            "deferRender": true,
            "columns": [
                {"data":"username"},
                {"data":"user_level"},
                {"data":"thn"},
                {"data":"status"},
                {"render": function(data, type, row){
                    var mn_admin = "<a href='<?php echo rules("act_read_admin"); ?>&id="+row.id_admin+"' class='edit'>Edit</a>" +
                        " <a href='<?php echo rules("act_delete_admin"); ?>&id="+row.id_admin+"' class='delete'>Hapus</a>";

                    return mn_admin;
                }}
            ],
        });

        $("#pageAdmin").hide();

        $("#tambahAdmin").click(function(){
            $(this).slideToggle();
            $("#pageAdmin").slideToggle();
        });

        $("#reset_admin").click(function(){
            $("#tambahAdmin").slideToggle();
            $("#pageAdmin").slideToggle();
            $("#formAdmin").attr("action","<?php echo rules('act_insert_admin'); ?>");
        });

        $("#formAdmin").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            if($("input[name=password_]").val() !== $("input[name=password_retype]").val()){
                alert("Password tidak cocok");
            }else{
                if($("input[name=status_admin]").val() === ""){
                    alert("Pilih status!")
                }else{
                    $.ajax({
                        type: method,
                        url: target,
                        data: data,
                        beforeSend: function(){
                            $("#simpan_admin").attr("disabled","disabled");
                            $("#simpan_admin").html("Menunggu...");
                        }
                    }).done(function(response){
                        if(response == "true"){
                            alert("Berhasil disimpan");
                            table.ajax.reload();
                            $("#simpan_admin").removeAttr("disabled");
                            $("#simpan_admin").html("Simpan");
                        }else{
                            alert(response);
                            $("#simpan_admin").removeAttr("disabled");
                            $("#simpan_admin").html("Simpan");
                        }
                    });       
                }
            }

            return false;
        });

        $("#table_admin").on('click','.delete', function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin menghapus data ini?");
            if(c == true){
                $.get(url, function(data, status){
                    if(data == "true"){
                        alert("Berhasil dihapus.");
                        table.ajax.reload();
                    }else{
                        alert(data);
                    }
                });
            }

            return false;
        });

        $("#table_admin").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=username]").val(value['username']);
                    $("select[name=user_level]").val(value['user_level']);
                    $("select[name=tahun]").val(value['id_thn']);
                    $("input[name=status_admin]:radio[value=<?php echo $sql[0]['status']; ?>]").prop("checked",true);
                });

                $("#tambahAdmin").slideToggle();
                $("#pageAdmin").slideDown();
            });

            $("#formAdmin").attr("action",url.replace("read","update"));
            $("#simpan_admin").html("Perbarui");
            return false;
        });
	});
</script>
