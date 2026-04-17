<ul class="nav nav-pills">

    <li role="presentation" class="active"><a href="#kloter" data-toggle="tab">Kloter</a></li>

    <li role="presentation"><a href="#kelompok" data-toggle="tab">Kelompok</a></li>

</ul>

<hr  />

<div class="tab-content">

    <div id="kloter" class="tab-pane fade in active">

        <form action="<?php echo rules('act_insert_kloter'); ?>" method="post" id="formKloter" class="form-group-sm">

            <div class="row form-group-sm">

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="thn">Kloter</label>

                        <input type="text" name="kloter" id="kloter" class="form-control" required/>

                    </div>

                </div>

            </div>



            <button type="submit" class="btn btn-primary btn-sm" id="simpan_kloter">Tambahkan</button>

            <button type="reset" class="btn btn-default btn-sm" id="reset_kloter">Batal</button>

        </form>

        <hr />

        <table class="table table-bordered" id="table_kloter">

            <thead>

                <tr>

                    <th>Kloter</th>

                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php 

                    $sql = db_read("select * from kloter where id_thn='".get_year(get_active_year())."'");

                    foreach ($sql as $key => $value) {

                        echo "<tr>

                                <td>$value[nama_kloter]</td>

                                <td>

                                    <a href='".rules("act_read_kloter")."&id=".$value['id']."' class='edit'>Edit</a>

                                    <a href='".rules("act_delete_kloter")."&id=".$value['id']."' class='delete'>Hapus</a>

                                </td>

                            </tr>";

                    }

                ?>

            </tbody>

        </table>

    </div>

    <div id="kelompok" class="tab-pane fade in">

        

            <div class="row">

            <form action="<?php echo rules('act_insert_kelompok'); ?>" method="post" class="form-group-sm" id="formKelompok">

                <div class="col-xs-5">

                    <div class="form-group">

                        <label for="acara">Kloter</label>

                        <select class="form-control" name="kloter">

                            <option value="">-- Pilih --</option>

                            <?php 

                                $sql = db_read("select * from kloter where id_thn='".get_year(get_active_year())."' order by nama_kloter asc");

                                foreach ($sql as $key => $value) {

                                    echo "<option value='".$value['id']."'>".$value['nama_kloter']."</option>";

                                }

                            ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="thn">Kelompok</label>

                        <input type="text" name="kelompok" id="kelompok" class="form-control" required/>

                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" id="simpan_kelompok">Simpan</button>

                    <button type="reset" class="btn btn-default btn-sm" id="reset_kelompok">Batal</button>

                </div>

                <div class="col-xs-7">

                    <table class="table table-bordered" id="table_kelompok">

                    <thead>

                        <tr>
                            <th>No</th>
                            
                            <th>Id</th>
                            
                            <th>Nama Kelompok</th>

                            <th>Kloter</th>

                            <th>Aksi</th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php

                        $sql = db_read("select kelompok.id as id_kelompok, kloter.id as id_kloter, kelompok.nama_kelompok, kloter.nama_kloter from kelompok join kloter on kelompok.id_kloter=kloter.id where kloter.id_thn = ".get_year(get_active_year()));
                        
                        $no = 1;
                        foreach ($sql as $key => $value) {

                            echo "<tr>";
                            
                            echo "<td>".$no++."</td>";
                            
                            echo "<td>".$value['id_kelompok']."</td>";

                            echo "<td>".$value['nama_kelompok']."</td>";

                            echo "<td>".$value['nama_kloter']."</td>";

                            echo "<td>

                                    <a href='".rules("act_read_kelompok")."&id=".$value['id_kelompok']."' class='edit'>Edit</a>

                                    <a href='".rules("act_delete_kelompok")."&id=".$value['id_kelompok']."' class='delete'>Hapus</a>

                                </td>";

                            echo "</tr>";

                        }

                        ?>

                        </tbody>

                    </table>        

                </div>    

            </form>

            </div>



            

        

        <hr />

        

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function(){



        $("#formKloter").submit(function(e){

            var method = $(this).attr("method");

            var data = $(this).serialize();

            var target = $(this).attr("action");



            $.ajax({

                type: method,

                url: target,

                data: data,

                beforeSend: function(){

                    $("#simpan_kloter").attr("disabled","disabled");

                    $("#simpan_kloter").html("Menunggu...");

                }

            }).done(function(response){

                if(response == "true"){

                    alert("Berhasil disimpan");

                    location.reload();

                }else{

                    alert(response);

                    $("#simpan_kloter").removeAttr("disabled");

                    $("#simpan_kloter").html("Perbarui");

                }

            });



            e.preventDefault();

            return false;

        });



        $("#reset_kloter").click(function(){

            $("#formKloter").attr("action","<?php echo rules('act_insert_kloter'); ?>");

            $("#simpan_kloter").html("Tambahkan");

        });



        $("#table_kloter").on('click','.edit', function(){

            var url = $(this).attr("href");

            $.get(url, function(data, status){

                var json = $.parseJSON(data);

                $.each(json, function(key,value){

                    $("input[name=kloter]").val(value['nama_kloter']);

                });

            });



            $("#formKloter").attr("action",url.replace("read","update"));

            $("#simpan_kloter").html("Perbarui");

            return false;

        });



        $("#table_kloter").on('click','.delete', function(){

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



        $("#formKelompok").submit(function(){

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

                    $("#simpan_kelompok").attr("disabled","disabled");

                    $("#simpan_kelompok").html("Menunggu...");

                }

            }).done(function(response){

                if(response == "true"){

                    alert("Berhasil disimpan");
                    
                    location.reload();

                }else{

                    alert(response);

                    $("#simpan_kelompok").removeAttr("disabled");

                    $("#simpan_kelompok").html("Perbarui");

                }

            });



            return false;

        });



        $("#reset_kelompok").click(function(){

            $("#formKelompok").attr("action","<?php echo rules('act_insert_kelompok'); ?>");

            $("#simpan_kelompok").html("Tambahkan");

        });

        $("#table_kelompok").DataTable();

        $("#table_kelompok").on('click','.edit', function(){

            var url = $(this).attr("href");

            var ruang = "";



            $.get(url, function(data, status){

                var json = $.parseJSON(data);

                $.each(json, function(key, value){

                    $("input[name=kelompok]").val(value['nama_kelompok']);

                    $("select[name=kloter]").val(value['id_kloter']);

                });



                // $.get("<?php echo rules('act_read_kelompok'); ?>&id="+ruang+"&par=different", function(data, status){

                //         var json = $.parseJSON(data);

                //         $.each(json, function(key, value){

                //             $("#available_rooms").append("<option value='"+value['id_ruang']+"'>"+value['nama_ruang']+"</option>");

                //         });

                // });

            });



            $("#formKelompok").attr("action",url.replace("read","update"));

            $("#simpan_kelompok").html("Perbarui");

            return false;

        });



        $("#table_kelompok").on('click','.delete', function(){

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
