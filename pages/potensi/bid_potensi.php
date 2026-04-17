<div class="row">
    <div class="col-md-4">
        <form action="<?php echo rules("act_insert_potensi"); ?>&t=bidang" method="post" class="form-group-sm" id="formbidpotensi">
            <div class="form-group">
                <label for="nama_bidang">Nama Bidang Potensi</label>
                <input type="text" name="nama_bidang" class="form-control" required/>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_bidpotensi">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_bidpotensi">Batal</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered" id="table_bidpotensi">
            <tr>
                <th>Nama Bid. Potensi</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from bidang");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_bidang']."</td>
                            <td>
                                <a href='".rules("act_read_potensi")."&t=bidang&id=".$value['id_bidang']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_potensi")."&t=bidang&id=".$value['id_bidang']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formbidpotensi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_bidpotensi").attr("disabled","disabled");
                    $("#simpan_bidpotensi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                    //window.location.href=window.location.href+"#bid_potensi";
                }else{
                    alert(response);
                    $("#simpan_bidpotensi").removeAttr("disabled");
                    $("#simpan_bidpotensi").html("Tambahkan");
                    //window.location.href=window.location.href+"#bid_potensi";
                }
            });

            return false;
        });

        $("#reset_bidpotensi").click(function(){
            $("#formbidpotensi").attr("action","<?php echo rules('act_insert_potensi'); ?>&t=bidang");
            $("#simpan_bidpotensi").html("Tambahkan");
        });

        $("#table_bidpotensi").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_bidang]").val(value['nama_bidang']);
                });
            });

            $("#formbidpotensi").attr("action",url.replace("read","update"));
            $("#simpan_bidpotensi").html("Perbarui");
            return false;
        });

        $("#table_bidpotensi").on('click','.delete', function(){
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
