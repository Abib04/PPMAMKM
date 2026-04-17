<?php
$cek_potensi = ($_SESSION['cek_potensi']>0)? TRUE : cek_potensi();
if($cek_potensi){
?>
<div class="form-group form-group-sm">

    <form action="<?php echo rules("act_insert_penyakit"); ?>&t=penyakit_mahasiswa" method="post" id="formPenyakit">

        <div class="row">

            <?php

                $id = (isset($_GET['npm'])) ? cleanchar($_GET['npm']) : $_SESSION['username'];

                $penyakit = db_read("select * from penyakit where status='Y'");

                $penyakit_mhs = db_read("select id_np from penyakit_mahasiswa where npm='".$id."'");

            ?>

                    <?php foreach ($penyakit as $val_penyakit) : ?>

                        <div class="col-xs-4">

                            <div class='checkbox'>

                                <label>

                                    <input type='checkbox' name='penyakit[]' value='<?php echo $val_penyakit['id_np']?>' /> <?php echo $val_penyakit['nama_penyakit']; ?>

                                </label>

                            </div>

                        </div>

                    <?php endforeach; 
                    /*
                    ?>



                <div class="col-xs-9">

                    <div class="form-group form-inline">

                        <label for="lainnya" class="control-label">Jika penyakit tidak ada di daftar, silahkan tulis di bawah ini.</label>

                        <input type="text" name="lainnya" class="form-control" />

                    </div>

                </div>
            <?php
                */

            ?>

        </div>

        <?php

            if($_SESSION['login'] == 1 and $_SESSION['logged_as'] == "mahasiswa"){

                echo "<p align='right'><button type='submit' id='simpan_penyakit' class='btn btn-primary btn-sm'>Simpan</button></p>";

            }

        ?>

    </form>

    <div class="row">

        <div class="col-xs-5">

            <table class="table table-hovered table-bordered" id="table_penyakit">

                <tr>

                    <td>Nama Penyakit</td>

                    <td>Aksi</td>

                </tr>

                <?php 

                    if($_SESSION['logged_as'] == "mahasiswa"){

                        $sql = db_read("select id_penyakit, nama_penyakit from vpenyakit where npm='".$_SESSION['username']."'");

                    }else{

                        $sql = db_read("select id_penyakit, nama_penyakit from vpenyakit where npm='".$_GET['npm']."'");

                    }

                    foreach ($sql as $key => $value) {

                        echo "<tr>

                                <td>".$value['nama_penyakit']."</td>

                                <td>

                                    <a href='".rules("act_delete_penyakit")."&t=penyakit_mahasiswa&id=".$value['id_penyakit']."' class='delete'>Hapus</a>

                                </td>

                            </tr>";

                    }

                ?>

            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function(){

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

                    $("#simpan_penyakit").html("Simpan");

                }

            });



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
<?php
    
}else{
    echo '<h4 style="color:red;"><b>Data Potensi</b> Harus diisi terlebih dahulu minimal satu</h4>';
}
?>
