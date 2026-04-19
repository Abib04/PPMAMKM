<button class="btn btn-sm btn-primary mb-3" style="margin-bottom: 20px; border-radius: 8px; font-weight: 600;" id="tambahAdmin"><i class="fa fa-plus"></i> Tambah Administrator</button>
<div id="pageAdmin" style="margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
    <form action="<?php echo rules("act_insert_admin"); ?>" method="post" id="formAdmin">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="username">Username</label>
                    <input type="text" name="username" class="form-control" style="border-radius: 8px; box-shadow: none;" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="user_level">Status User</label>
                    <div class="radio" style="margin-top: 10px;">
                        <label class="radio-inline" style="margin-right: 15px; font-weight: normal;">
                            <input type="radio" name="status_admin" value="Y"> Aktif
                        </label>
                        <label class="radio-inline" style="font-weight: normal;">
                            <input type="radio" name="status_admin" value="N"> Non-Aktif
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="password_">Password</label>
                    <input class="form-control" name="password_" type="password" style="border-radius: 8px; box-shadow: none;" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="password_retype">Ulangi Password</label>
                    <input class="form-control" name="password_retype" type="password" style="border-radius: 8px; box-shadow: none;" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="user_level">User Level</label>
                    <select name="user_level" class="form-control" style="border-radius: 8px; box-shadow: none;" required>
                        <option value="">-- Pilih Akses Level --</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="ddi">Data dan Informasi</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label style="font-weight: 600;" for="tahun">Tahun Angkatan</label>
                    <select name="tahun" class="form-control" style="border-radius: 8px; box-shadow: none;" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php
                            $sql = db_read("select * from tahun");
                            foreach($sql as $key=>$value){
                                echo "<option value='$value[id_thn]'>$value[thn]</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group mt-3" style="text-align: right; margin-top: 15px;">
            <button type="reset" class="btn btn-default" style="border-radius: 8px;" id="reset_admin">Batal</button>
            <button type="submit" class="btn btn-primary" style="background: var(--primary); border: none; border-radius: 8px; font-weight: 600;" id="simpan_admin">Simpan Data</button>
        </div>
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
