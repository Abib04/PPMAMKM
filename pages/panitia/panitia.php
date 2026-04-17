<p style="margin-bottom: 10px;">

    <?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
	   <button class="btn btn-sm btn-primary" id="tambah">Tambah</button>
    <?php endif; ?>

	<!--<a class="btn btn-success btn-sm" href="<?php echo base_url('presensi.php?op=panitia'); ?>" target="_blank">Cetak Presensi Panitia</a>-->
    <!--<label for="tahun"><select name="tahun" id="filter_tahun" class="form-control">
	<?php
		$thn = db_read("select * from tahun order by thn desc");
		foreach ($thn as $key => $value) {
			$no = ($value['status']==y)? 'selected' : '';
			echo "<option value=\"".$value['id_thn']."\" ".$no." >".$value['thn']."</option> ";
		}
	?>
    </select></label>-->
</p>

<?php if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
    <div id="pagePanitia" style="margin-bottom: 20px">
        <form action="<?php echo rules("act_insert_panitia"); ?>&t=panitia" id="formPanitia" method="post" class="form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required />
                    </div>
                    <div class="form-group">
                        <label for="noid">No. Identitas</label>
                        <input type="text" class="form-control" name="no_identitas" required />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                            <p>
                                <label class="radio-inline">
                                    <input type="radio" name="jk" value="laki-laki"> Laki-Laki
                                </label>
                        
                                <label class="radio-inline">
                                    <input type="radio" name="jk" value="perempuan"> Perempuan
                                </label>
                            </p>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="posisi_panitia">Posisi Panitia</label>
                        <select name="posisi_panitia" class="form-control" required>
                        <option value="">Pilih</option>
                                <?php
                                    $posisi = db_read("select * from posisi_panitia where status='Y'");
                                    foreach($posisi as $val){
                                        echo "<option value='".$val['id_pp']."'>".$val['nama_pp']."</option>";
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp">No. Telepon</label>
                        <input type="text" class="form-control" name="hp" required />
                    </div>
                    <!--<div class="form-group" style="margin-top: 30px;">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" class="form-control" required>
                            <option value="">Pilih</option>
                            <?php
                            // $tahun = db_read("select * from tahun where status='Y'");
                            // foreach($tahun as $val){
                            //     echo "<option value='".$val['id_thn']."'>".$val['thn']."</option>";
                            // }
                            ?>
                        </select>
                    </div>-->
                </div>
            </div>
            
            <p align="right">
                <button type="submit" class="btn btn-primary btn-sm" id="simpan_panitia">Submit</button>
                <button type="reset" class="btn btn-default btn-sm" id="reset_panitia">Batal</button>
            </p>
        </form>
        <hr />
    </div>
<?php endif; ?>
<table class="table table-hovered table-bordered" id="table_panitia">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Posisi Panitia</th>
            <!--<th>Tahun</th>-->
            <th>Jenis Kelamin</th>
            <th>No. Telp.</th>
            <?php //if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                <th>Aksi</th>
            <?php //endif; ?>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Nama</th>
            <th>Posisi Panitia</th>
            <!--<th>Tahun</th>-->
            <th>Jenis Kelamin</th>
            <th>No. Telp.</th>
            <?php //if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "super_admin") : ?>
                <th>Aksi</th>
            <?php //endif; ?>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
	$(document).ready(function(){
        var table = $("#table_panitia").DataTable({
            "ajax":{
                "url" : "<?php echo BASE_URL; ?>data.php?module=mod_panitia&t=panitia&op=read",
                "dataSrc" : ""
            },
            "deferRender": true,
            "columns": [
                {"data":"nama"},
                {"data":"nama_pp"},
                // {"data":"thn"},
                {"data":"jk"},
                {"data":"hp"},
                {"render": function(data, type, row){
                    var mn_panitia = "<div class='dropdown'>" +
                        "<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' id='action'>" +
                        "-- Pilih -- <span class='caret'></span>" +
                        "</button>" +
                        "<ul class='dropdown-menu' aria-labelledby='action'>" +
                            "<li><a href='<?php echo rules("act_read_panitia"); ?>&t=panitia&id="+row.id_panitia+"' class='edit'>Edit</a></li>" +
                            "<li><a href='<?php echo rules("act_delete_panitia"); ?>&t=panitia&id="+row.id_panitia+"' class='delete'>Hapus</a></li>" +
                            "<li><a href='<?php echo BASE_URL; ?>sertifikat.php?op=panitia&id="+row.id_panitia+"' target='_blank'>Cetak Sertifikat (Maintenance)</a></li>" +
                        "</ul>" +
                        "</div>";

                    return mn_panitia;
                }}
            ]
        });

        <?php if($_SESSION['logged_as'] == "ddi") : ?>
            table.column(5).visible(false);
        <?php endif; ?>

        $("#pagePanitia").hide();

        $("#tambah").click(function(){
            $(this).slideToggle();
            $("#pagePanitia").slideToggle();
        });

        $("#filter_tahun").change(function(){
           thn = $(this).val();
			table.ajax.url( "<?php echo rules("act_read_panitia_full");?>&thn="+$(this).val() ).load();
		});

        $("#reset_panitia").click(function(){
            $("#tambah").slideToggle();
            $("#pagePanitia").slideToggle();
            $("#formPanitia").attr("action","<?php echo rules('act_insert_panitia'); ?>&t=panitia");
        });

        $("#formPanitia").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            if($("input[name=password_]").val() !== $("input[name=password_retype]").val()){
                alert("Password tidak cocok");
            }else{
                if($("input[name=status_panitia]").val() === ""){
                    alert("Pilih status!")
                }else{
                    $.ajax({
                        type: method,
                        url: target,
                        data: data,
                        beforeSend: function(){
                            $("#simpan_panitia").attr("disabled","disabled");
                            $("#simpan_panitia").html("Menunggu...");
                        }
                    }).done(function(response){
                        if(response == "true"){
                            alert("Berhasil disimpan");
                            $("#simpan_panitia").removeAttr("disabled");
                            $("#simpan_panitia").html("Simpan");
                            table.ajax.reload();
                        }else{
                            alert(response);
                            $("#simpan_panitia").removeAttr("disabled");
                            $("#simpan_panitia").html("Simpan");
                        }
                    });       
                }
            }

            return false;
        });

        $("#table_panitia").on('click','.delete', function(){
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

        $("#table_panitia").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama]").val(value['nama']);
                    $("input[name=hp]").val(value['hp']);
                    $("input[name=no_identitas]").val(value['no_identitas']);
                    $("select[name=posisi_panitia]").val(value['id_pp']);
                    $("select[name=tahun]").val(value['id_thn']);
                    $("input[name=jk]:radio[value="+value['jk']+"]").prop("checked",true);
                });

                $("#tambah").slideToggle();
                $("#pagePanitia").slideToggle();
            });

            $("#formPanitia").attr("action",url.replace("read","update"));
            $("#simpan_panitia").html("Perbarui");
            return false;
        });
	});
</script>
