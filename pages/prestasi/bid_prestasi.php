<div class="row">
    <div class="col-md-4">
        <form action="<?php echo rules("act_insert_prestasi"); ?>&t=bid_prestasi" method="post" class="form-group-sm" id="formbidprestasi">
            <div class="form-group">
                <label for="nama_bid">Nama Bidang Prestasi</label>
                <input type="text" name="nama_bid" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Aktif</label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_bid" id="status" value="Y" />Ya
                </label>
                
                <label class="radio-inline">
                    <input type="radio" name="status_bid" id="status" value="N" />Tidak
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_bidprestasi">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_bidprestasi">Batal</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered" id="table_bidprestasi">
            <tr>
                <th>Nama Bid. Prestasi</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select * from bid_prestasi");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['nama_bid']."</td>
                            <td>".$value['status']."</td>
                            <td>
                                <a href='".rules("act_read_prestasi")."&t=bid_prestasi&id=".$value['id_bid_prestasi']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_prestasi")."&t=bid_prestasi&id=".$value['id_bid_prestasi']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formbidprestasi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_bidprestasi").attr("disabled","disabled");
                    $("#simpan_bidprestasi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                }else{
                    alert(response);
                    $("#simpan_bidprestasi").removeAttr("disabled");
                    $("#simpan_bidprestasi").html("Tambahkan");
                }
            });

            return false;
        });

        $("#reset_bidprestasi").click(function(){
            $("#formbidprestasi").attr("action","<?php echo rules('act_insert_klg'); ?>");
            $("#simpan_bidprestasi").html("Tambahkan");
        });

        $("#table_bidprestasi").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("input[name=nama_bid]").val(value['nama_bid']);
                    if("<?php echo $sql[0]['status']; ?>" == "Y"){
                        $("input[name=status_bid]:radio[value=Y]").prop("checked",true);
                    }else{
                        $("input[name=status_bid]:radio[value=N]").prop("checked",true);
                    }
                });
            });

            $("#formbidprestasi").attr("action",url.replace("read","update"));
            $("#simpan_bidprestasi").html("Perbarui");
            return false;
        });

        $("#table_bidprestasi").on('click','.delete', function(){
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
