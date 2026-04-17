<div class="row">
    <div class="col-md-4">
        <form action="<?php echo rules("act_insert_potensi"); ?>&t=jenis_potensi" method="post" class="form-group-sm" id="formjenispotensi">
            <div class="form-group">
                <label for="jenis_potensi">Jenis Potensi</label>
                <input type="text" name="jenis_potensi" class="form-control" required/>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_jenispotensi">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_jenispotensi">Batal</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered" id="table_jenispotensi">
            <tr>
                <th>Jenis Potensi</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from jenis_potensi");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['jenis_potensi']."</td>
                            <td>
                                <a href='".rules("act_read_potensi")."&t=jenis_potensi&id=".$value['id_jenis']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_potensi")."&t=jenis_potensi&id=".$value['id_jenis']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formjenispotensi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_jenispotensi").attr("disabled","disabled");
                    $("#simpan_jenispotensi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                    //window.location.href=window.location.href+"#bid_potensi";
                }else{
                    alert(response);
                    $("#simpan_jenispotensi").removeAttr("disabled");
                    $("#simpan_jenispotensi").html("Perbarui");
                    //window.location.href=window.location.href+"#bid_potensi";
                }
            });

            return false;
        });

        $("#reset_jenispotensi").click(function(){
            $("#formjenispotensi").attr("action","<?php echo rules('act_insert_potensi'); ?>&t=jenis_potensi");
            $("#simpan_jenispotensi").html("Tambahkan");
        });

        $("#table_jenispotensi").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=jenis_potensi]").val(value['jenis_potensi']);
                });
            });

            $("#formjenispotensi").attr("action",url.replace("read","update"));
            $("#simpan_jenispotensi").html("Perbarui");
            return false;
        });

        $("#table_jenispotensi").on('click','.delete', function(){
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
