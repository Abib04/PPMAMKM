<ul class="nav nav-pills">
    <li role="presentation" class="active"><a href="#acara" data-toggle="tab">List Acara</a></li>
    <li role="presentation" ><a href="#dftracara" data-toggle="tab">Daftar Acara</a></li>
    <li role="presentation"><a href="#div_room" data-toggle="tab">Pembagian ruangan</a></li>
</ul>
<hr  />
<div class="tab-content">
    <div id="acara" class="tab-pane fade in active">
    <div class="row">
    <div class="col-xs-5">
        <form action="<?php echo rules('act_insert_acara'); ?>" method="post" id="formAcaramaster" class="form-group-sm">
            <div class="row form-group-sm">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="thn">Nama Acara</label>
                        <input type="text" name="nama_acara" id="nama_acara" class="form-control" required/>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary btn-sm" id="simpan_acaramaster">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_acaramaster">Batal</button>
        </form>
        </div>
        <div class="col-xs-7">
        <table class="table table-bordered" id="table_list_acara">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Acara</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = db_read("select * from acara");
                    $no = 1;
                    foreach ($sql as $key => $value) {
                        echo "<tr>
                                <td>".$no."</td>
                                <td>".$value['nama_acara']."</td>
                                
                                <td>
                                    <a href='".rules("act_read_acara")."&id=".$value['id_acara']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_acara")."&id=".$value['id_acara']."' class='delete'>Hapus</a>
                                </td>
                            </tr>";$no++;
                    }
                ?>
            </tbody>
        </table>
        </div>
        </div>
    </div>
    <div id="dftracara" class="tab-pane fade in ">
        <form action="<?php echo rules('act_insert_acara_tahun'); ?>" method="post" id="formAcara" class="form-group-sm">
            <div class="row form-group-sm">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama_acara">Nama Acara</label>
                        <select name="nama_acara" id="nama_acara" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <?php
                                $sql = db_read("select * from acara");
                                foreach ($sql as $key => $value) {
                                    echo "<option value=\"".$value['id_acara']."\">".$value['nama_acara']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="method">Method</label>
                        <select name="method" id="method" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control" required/>
                    </div>
                </div>
            </div>

            <div class="row form-group-sm">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Mulai</label>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="tanggal_mulai" required>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Selesai</label>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="tanggal_selesai" required>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm" id="simpan_acara">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_acara">Batal</button>
        </form>
        <hr />
        <code>
            <b>Method:</b>
            <ol type="1">
            <li>Pembagian by kelompok</li>
            <li>Pembagian by fakultas</li>
            <li>Pembagian by kelompok dengan jumlah ruangan sama (dengan yang "Pembagian ruangan") di setiap kloter dan sesi</li>
            <li>Pembagian by prodi</li>
            </ol>
        </code>
        <table class="table table-bordered" id="table_acara">
            <thead>
                <tr>
                    <th>Nama Acara</th>
                    <th>Method</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = db_read("SELECT * FROM `vacara` where id_thn='".get_year(get_active_year())."' ORDER by tanggal_mulai");
                    foreach ($sql as $key => $value) {
                        $ket = (strlen($value['keterangan']) > 25)? substr($value['keterangan'],0,23)."..." : $value['keterangan'];
                        echo "<tr>
                                <td>$value[nama_acara]</td>
                                <td>$value[method_th]</td>
                                <td>$ket</td>
                                <td>$value[tanggal_mulai] s/d $value[tanggal_selesai]</td>
                                <td>
                                    <a href='".rules("act_read_acara_tahun")."&id=".$value['id_acara_thn']."' class='edit'>Edit</a>
                                    <a href='".rules("act_delete_acara_tahun")."&id=".$value['id_acara_thn']."' class='delete'>Hapus</a>
                                </td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>
         
    </div>
    <div id="div_room" class="tab-pane fade in">
        <form action="<?php echo rules('act_insert_divroom'); ?>" method="post" class="form-group-sm" id="formDiv">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="acara">Acara</label>
                        <select class="form-control" name="acara">
                            <option value="">-- Pilih --</option>
                            <?php 
                                $sql = db_read("select *,(select nama_acara from acara where acara.id_acara = acara_tahun.id_acara) as nama_acara from acara_tahun where id_thn='".get_year(get_active_year())."' order by nama_acara asc");
                                foreach ($sql as $key => $value) {
                                    echo "<option value='".$value['id']."'>".$value['nama_acara']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label for="available_rooms">Ruang Yang Tersedia</label>
                                <select class="form-control" size='9' name="available_rooms" id="available_rooms" multiple>
                                     <?php 
                                        $sql = db_read("select * from ruang");
                                        foreach($sql as $val){
                                            echo "<option value='".$val['id_ruang']."'>".$val['nama_ruang']."</option>";
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
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label for="stored_rooms">Ruang Yang Digunakan</label>
                                <select class="form-control" size='9' name="stored_rooms[]" id="stored_rooms" multiple></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_ruangan">Simpan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_ruangan">Batal</button>
        </form>
        <hr />
        <table class="table table-bordered" id="table_ruangan">
            <tr>
                <th>Nama Acara</th>
                <th>Tanggal</th>
                <th>Ruangan</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("SELECT distinct(nama_acara),tanggal FROM `vdivroom` where id_thn='".get_year(get_active_year())."' ORDER BY `vdivroom`.`tanggal` ASC");
                $acara = array();
                $tanggal = array();
                foreach ($sql as $key => $value) {
                    $acara[] = $value['nama_acara'];
                    //$tanggal[] = $value['tanggal'];
                }
                
                /*if($_SESSION['username']=='dev_admin'){
                    echo '<pre>';
                    print_r($tanggal);
                    echo '</pre>';
                }*/
                
                for ($i=0; $i < count($acara); $i++) { 
                    $sql = db_read("select distinct(tanggal) from vdivroom where nama_acara='".$acara[$i]."' and id_thn='".get_year(get_active_year())."'");
                    // $tanggal = array();
                    // foreach ($sql as $key => $value) {
                    //     $tanggal[] = $value['tanggal'];
                    // }
                    // sort($tanggal);
                    //if($_SESSION['username']=='dev_admin'){
                    foreach ($sql as $key_tgl => $value_tgl) {
                        $rec = db_read("select * from vdivroom inner join ruang on ruang.id_ruang=vdivroom.id_ruang where nama_acara='".$acara[$i]."' and tanggal='".$value_tgl['tanggal']."' and id_thn='".get_year(get_active_year())."'");
                        $n = 1;
                        foreach ($rec as $key => $value) {
                            if($n == 1){
                                echo "<tr>
                                        <td rowspan='".count($rec)."'>".$value['nama_acara']."</td>
                                        <td rowspan='".count($rec)."'>".$value['tanggal']."</td>
                                        <td>".$value['nama_ruang']."</td>
                                        <td>".$value['max_kuota']."</td>
                                        <td rowspan='".count($rec)."'>
                                            <a href='".rules('act_read_divroom')."&par=same&acara=".$value['id_acara_thn']."&tanggal=".$value_tgl['tanggal']."' class='edit'>Edit</a>
                                            <a href='".rules('act_delete_divroom')."&acara=".$value['id_acara_thn']."' class='delete'>Hapus</a>
                                        </td>
                                    </tr>";
                            }else{
                                echo "<tr>
                                        <td>".$value['nama_ruang']."</td>
                                        <td>".$value['max_kuota']."</td>
                                    </tr>";
                            }

                            $n++;
                        }
                    }
                    //}
                    
                    /* LAMA sebelum 4 agustus 2022
                    for($j=0; $j < count($tanggal);  $j++) { 
                        $rec = db_read("select * from vdivroom inner join ruang on ruang.id_ruang=vdivroom.id_ruang where nama_acara='".$acara[$i]."' and tanggal='".$tanggal[$j]."' and id_thn='".get_year(get_active_year())."'");
                        $n = 1;
                        
                        foreach ($rec as $key => $value) {
                            if($n == 1){
                                echo "<tr>
                                        <td rowspan='".count($rec)."'>".$value['nama_acara']."</td>
                                        <td rowspan='".count($rec)."'>".$value['tanggal']."</td>
                                        <td>".$value['nama_ruang']."</td>
                                        <td>".$value['max_kuota']."</td>
                                        <td rowspan='".count($rec)."'>
                                            <a href='".rules('act_read_divroom')."&par=same&acara=".$value['id_acara_thn']."&tanggal=".$tanggal[$j]."' class='edit'>Edit</a>
                                            <a href='".rules('act_delete_divroom')."&acara=".$value['id_acara_thn']."' class='delete'>Hapus</a>
                                        </td>
                                    </tr>";
                            }else{
                                echo "<tr>
                                        <td>".$value['nama_ruang']."</td>
                                        <td>".$value['max_kuota']."</td>
                                    </tr>";
                            }

                            $n++;
                        }
                    }
                    */
                }
            ?>
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){

        $('#table_ruangan').on('dblclick','.inline',function(){
            var id_dr = $(this).data('id');
            var nilai = $(this).html();
            var element = "<input type='number' class='inline-editor' min='1' max='3200' width='20' data-before='"+nilai+"' data-id='"+id_dr+"' name='kuota' value='"+nilai+"' />";
            $(this).parent().html(element);
            // console.log(id_dr+' '+nilai);
            return false;
        });
        $('#table_ruangan').on('keyup','.inline-editor',function(event){
            var id_dr = $(this).data('id');
            if(event.keyCode == 13){
                if($(this).data('before') != nilai){
                var nilai = $(this).val();
                $.post("<?= base_url('data.php?module=mod_divroom&op=inlene_edit&token='.$_SESSION['token']) ?>",{'id_dr':id_dr,'nilai':nilai},function(data){
                    
                    var res = JSON.parse(data);
                    // console.log(res.message);
                    if(res.status == 200)
                    alert(res.message);
                });
                var element = "<a data-id='"+id_dr+"' class='inline'>"+nilai+"</a>";
                $(this).parent().html(element);
                } 
                // console.log(element);
            } else if(event.keyCode == 27){
                var nilai = $(this).data('before');
                var element = "<a data-id='"+id_dr+"' class='inline'>"+nilai+"</a>";
                $(this).parent().html(element);
            }
            return false;
        });
        //Acara 
        $("#formAcaramaster").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_acaramaster").attr("disabled","disabled");
                    $("#simpan_acaramaster").html("Menunggu...");
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

        $("#reset_acaramaster").click(function(){
            $("#formAcaramaster").attr("action","<?php echo rules('act_insert_acara'); ?>");
            $("#simpan_acaramaster").html("Tambahkan");
        });

        $("#table_list_acara").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("#formAcaramaster input[name=nama_acara]").val(value['nama_acara']);
                    // console.log(value);
                });
            });

            $("#formAcaramaster").attr("action",url.replace("read","update"));
            $("#simpan_acaramaster").html("Perbarui");
            return false;
        });

        $("#table_list_acara").on('click','.delete', function(){
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

        //Acara PPM Current
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
            $("#formAcara").attr("action","<?php echo rules('act_insert_acara'); ?>");
            $("#simpan_acara").html("Tambahkan");
        });

        $("#table_acara").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("select[name=nama_acara]").val(value['id_acara']);
                    $("select[name=method]").val(value['method_th']);
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
            $("#stored_rooms option").each(function(i){
                select.push(this.value);
            });

            $.ajax({
                type: method,
                url: target,
                data: data+"&ruang="+select,
                beforeSend: function(){
                    $("#simpan_ruangan").attr("disabled","disabled");
                    $("#simpan_ruangan").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_ruangan").removeAttr("disabled");
                    $("#simpan_ruangan").html("Perbarui");
                }
            });

            return false;
        });

        $("#moveAllToLeft").click(function(){
            $("#stored_rooms option").remove().appendTo("#available_rooms");
        });

        $("#moveAllToRight").click(function(){
            $("#available_rooms option").remove().appendTo("#stored_rooms");
        });

        $("#moveItemToLeft").click(function(){
            $("#stored_rooms option:selected").remove().appendTo("#available_rooms");
        });

        $("#moveItemToRight").click(function(){
            $("#available_rooms option:selected").remove().appendTo($("#stored_rooms"));
        });

        $("#reset_ruangan").click(function(){
            $("#formDiv").attr("action","<?php echo rules('act_insert_divroom'); ?>");
            $("#stored_rooms option").remove().appendTo("#available_rooms");
            // $("#simpan_ruangan").html("Tambahkan");
        });

        $("#table_ruangan").on('click','.edit', function(){
            var url = $(this).attr("href");
            var ruang = "";

            $("#available_rooms option").remove();
            $("#stored_rooms option").remove();

            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key, value){
                    $("input[name=tanggal]").val(value['tanggal']);
                    $("select[name=acara]").val(value['id_acara_thn']);
                    $("#stored_rooms").append("<option value='"+value['id_ruang']+"'>"+value['nama_ruang']+"</option>");
                    ruang += value['id_ruang']+";";
                });

                $.get("<?php echo rules('act_read_divroom'); ?>&id="+ruang+"&par=different", function(data, status){
                        var json = $.parseJSON(data);
                        $.each(json, function(key, value){
                            $("#available_rooms").append("<option value='"+value['id_ruang']+"'>"+value['nama_ruang']+"</option>");
                        });
                });
            });

            $("#formDiv").attr("action",url.replace("read","update"));
            $("#simpan_acara").html("Perbarui");
            return false;
        });

        $("#table_ruangan").on('click','.delete', function(){
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
