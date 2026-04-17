<form action="<?php echo rules('act_insert_sesi_kloter'); ?>" method="post" class="form-group-sm" id="formDiv">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="kloter">Kloter</label>
                        <select class="form-control" name="kloter">
                            <option value="">-- Pilih --</option>
                            <?php 
                                $sql = db_read("select * from kloter where id_thn = '".get_year(get_active_year())."'");
                                foreach($sql as $val){
                                    echo "<option value='".$val['id']."'>".$val['nama_kloter']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="avalaible_sesi">List Sesi</label>
                                <select class="form-control" size='9' name="avalaible_sesi" id="avalaible_sesi" multiple>
                                    <?php 
                                        $sql = db_read("select * from vsesi where id_thn='".get_year(get_active_year())."' order by `nama_acara` asc");
                                        foreach ($sql as $key => $value) {
                                            echo "<option value='".$value['id_sesi']."'>".$value['nama_acara']."(".$value['nama_sesi'].") - ".$value['tanggal']." ".$value['jam_mulai']."-".$value['jam_akhir']." </option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <ul class="multiselect-rooms">
                                <li><a href="javascript:void(0);" id="moveAllToRight">&raquo;</a></li>
                                <li><a href="javascript:void(0);" id="moveItemToRight">&gt;</a></li>
                                <li><a href="javascript:void(0);" id="moveItemToLeft">&lt;</a></li>
                                <li><a href="javascript:void(0);" id="moveAllToLeft">&laquo;</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="stored_sesi">Daftar Sesi</label>
                                <select class="form-control" size='9' name="stored_sesi[]" id="stored_sesi" multiple></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_sesi_kloter">Simpan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_sesi_kloter">Batal</button>
        </form>
        <hr />
        <table class="table table-bordered" id="table_sesi_kloter">
            <tr>
                <th>Nama kloter</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Sesi</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select distinct(nama_kloter) from vsesi_kloter");
                $kloter = array();
                $tanggal = array();
                foreach ($sql as $key => $value) {
                    $kloter[] = $value['nama_kloter'];
                }

                for ($i=0; $i < count($kloter); $i++) { 
                    $sql = db_read("select distinct(tanggal) from vsesi_kloter where nama_kloter='".$kloter[$i]."' and id_thn='".get_year(get_active_year())."' order by tanggal");
                    $tanggal = array();
                    foreach($sql as $key => $value){
                        $tanggal[] = $value['tanggal'];
                    }
                    $curi = $i;
                    for($j=0; $j < count($tanggal);  $j++) { 
                        $rec = db_read("select * from vsesi_kloter where nama_kloter='".$kloter[$i]."' and tanggal='".$tanggal[$j]."' and id_thn='".get_year(get_active_year())."' order by mulai");
                        $rec1 = db_read("select * from vsesi_kloter where nama_kloter='".$kloter[$i]."' and id_thn='".get_year(get_active_year())."'");
                        $curj = $j;
                        $tgl = "";
                        foreach ($rec as $key => $value) {
                            if($curi == $i){
                                echo "<tr>
                                        <td rowspan='".count($rec1)."'>".$value['nama_kloter']."</td>
                                        <td rowspan='".count($rec)."'>".$value['tanggal']."</td>
                                        <td>".$value['mulai']."-".$value['selesai']."</td>
                                        <td>".$value['nama_acara']." (".$value['nama_sesi'].")</td>
                                        <td rowspan='".count($rec1)."'>
                                            <a href='".rules('act_read_sesi_kloter')."&id=".$value['id_kloter']."' class='edit'>Edit</a>
                                            <a href='".rules('act_delete_sesi_kloter')."&id=".$value['id_kloter']."' class='delete'>Hapus</a>
                                        </td>
                                    </tr>";
                                    $curi++;
                                    $tgl = $value['tanggal'];
                            }elseif($curj == $j){
                                echo "<tr>";
                                if($tgl != $value['tanggal']){
                                        echo"<td rowspan='".count($rec)."'>".$value['tanggal']."</td>";}
                                    echo "<td>".$value['mulai']."-".$value['selesai']."</td>
                                        <td>".$value['nama_acara']." (".$value['nama_sesi'].")</td>
                                    </tr>";
                                    $curj++;
                            }else{
                                echo "<tr>
                                        <td>".$value['mulai']."-".$value['selesai']."</td>
                                        <td>".$value['nama_acara']." (".$value['nama_sesi'].")</td>
                                    </tr>";
                            }
                        }
                        
                    }
                    
                }
            ?>
        </table>
        <script type="text/javascript">
    $(document).ready(function(){

        //Acara
        $("#formAcara").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_acara").attr("disabled","disabled");
                    $("#simpan_acara").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_acara").removeAttr("disabled");
                    $("#simpan_acara").html("Perbarui");
                }
            });

            return false;
        });

        $("#reset_acara").click(function(){
            $("#formAcara").attr("action","<?php echo rules('act_insert_sesi_kloter'); ?>");
            $("#simpan_acara").html("Tambahkan");
        });

        $("#table_acara").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_acara]").val(value['nama_acara']);
                    $("input[name=keterangan]").val(value['keterangan']);
                    $("input[name=tanggal_mulai]").val(value['tanggal_mulai']);
                    $("input[name=tanggal_selesai]").val(value['tanggal_selesai']);
                });
            });

            $("#formAcara").attr("action",url.replace("read","update"));
            $("#simpan_acara").html("Perbarui");
            return false;
        });

        $("#table_acara").on('click','.delete', function(){
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

        // Div Room

        $("#formDiv").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");
            var select = [];
            $("#stored_sesi option").each(function(i){
                select.push(this.value);
            });

            $.ajax({
                type: method,
                url: target,
                data: data+"&sesi="+select,
                beforeSend: function(){
                    $("#simpan_sesi_kloter").attr("disabled","disabled");
                    $("#simpan_sesi_kloter").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_sesi_kloter").removeAttr("disabled");
                    $("#simpan_sesi_kloter").html("Perbarui");
                }
            });

            return false;
        });

        $("#moveAllToLeft").click(function(){
            $("#stored_sesi option").remove().appendTo("#avalaible_sesi");
        });

        $("#moveAllToRight").click(function(){
            $("#avalaible_sesi option").remove().appendTo("#stored_sesi");
        });

        $("#moveItemToLeft").click(function(){
            $("#stored_sesi option:selected").remove().appendTo("#avalaible_sesi");
        });

        $("#moveItemToRight").click(function(){
            $("#avalaible_sesi option:selected").remove().appendTo($("#stored_sesi"));
        });

        $("#reset_sesi_kloter").click(function(){
            $("#formDiv").attr("action","<?php echo rules('act_insert_sesi_kloter'); ?>");
            $("#simpan_sesi_kloter").html("Tambahkan");
        });

        $("#table_sesi_kloter").on('click','.edit', function(){
            var url = $(this).attr("href");
            var kloter = "";

            $("#avalaible_sesi option").remove();
            $("#stored_sesi option").remove();

            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key, value){
                    //$("input[name=tanggal]").val(value['tanggal']);
                    $("select[name=kloter]").val(value['id_kloter']);
                    $("#stored_sesi").append("<option value='"+value['id_sesi']+"'>"+value['nama_acara']+"("+value['nama_sesi']+") - "+value['tanggal']+" "+value['mulai']+"-"+value['selesai']+" </option>");
                    kloter += value['id_kloter']+";";
                });

                $.get("<?php echo rules('act_read_sesi_kloter'); ?>&id="+kloter+"&par=different", function(data, status){
                        var json = $.parseJSON(data);
                        $.each(json, function(key, value){
                            $("#avalaible_sesi").append("<option value='"+value['id_sesi']+"'>"+value['nama_acara']+"("+value['nama_sesi']+") - "+value['tanggal']+" "+value['jam_mulai']+"-"+value['jam_akhir']+" </option>");
                        });
                });
            });

            $("#formDiv").attr("action",url.replace("read","update"));
            $("#simpan_kloter").html("Perbarui");
            return false;
        });

        $("#table_sesi_kloter").on('click','.delete', function(){
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
