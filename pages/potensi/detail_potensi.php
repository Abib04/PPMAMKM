<div class="row">
    <div class="col-md-4">
        <form action="<?php echo rules("act_insert_potensi"); ?>&t=potensi_bidang" method="post" class="form-group-sm" id="formdetailpotensi">
            <div class="form-group">
				<label for="id_jenis">Jenis Potensi</label>
				<select name="id_jenis" class="form-control">
					<option value="">-- Pilih --</option>
					<?php 
					$sql = db_read("select id_jenis, jenis_potensi from jenis_potensi where 1");
					foreach ($sql as $key => $value): ?>
						<option value="<?php echo $value['id_jenis']; ?>"><?php echo $value['jenis_potensi']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="form-group">
				<label for="id_bidang">Bidang Potensi</label>
				<select name="id_bidang" class="form-control">
					<option value="">-- Pilih --</option>
					<?php 
					$sql = db_read("select id_bidang, nama_bidang from bidang where 1");
					foreach ($sql as $key => $value): ?>
						<option value="<?php echo $value['id_bidang']; ?>"><?php echo $value['nama_bidang']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
            
            <button type="submit" class="btn btn-primary btn-sm" id="simpan_detailpotensi">Tambahkan</button>
            <button type="reset" class="btn btn-default btn-sm" id="reset_detailpotensi">Batal</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table table-bordered" id="table_detailpotensi">
            <tr>
                <th>Jenis Potensi</th>
                <th>Bidang</th>
                <th>Aksi</th>
            </tr>
            <?php
                $sql = db_read("select pb.*, jenis_potensi, nama_bidang from jenis_potensi jp JOIN potensi_bidang pb ON jp.id_jenis=pb.id_jenis JOIN bidang b ON pb.id_bidang=b.id_bidang");
                foreach ($sql as $key => $value) {
                    echo "<tr>
                            <td>".$value['jenis_potensi']."</td>
                            <td>".$value['nama_bidang']."</td>
                            <td>
                                <a href='".rules("act_read_potensi")."&t=potensi_bidang&id=".$value['id_pb']."' class='edit'>Edit</a>
                                <a href='".rules("act_delete_potensi")."&t=potensi_bidang&id=".$value['id_pb']."' class='delete'>Hapus</a>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#formdetailpotensi").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("#simpan_detailpotensi").attr("disabled","disabled");
                    $("#simpan_detailpotensi").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Berhasil disimpan");
                    location.reload();
                    //window.location.href=window.location.href+"#bid_potensi";
                }else{
                    alert(response);
                    $("#simpan_detailpotensi").removeAttr("disabled");
                    $("#simpan_detailpotensi").html("Tambahkan");
                    //window.location.href=window.location.href+"#bid_potensi";
                }
            });

            return false;
        });

        $("#reset_detailpotensi").click(function(){
            $("#formdetailpotensi").attr("action","<?php echo rules('act_insert_potensi'); ?>&t=potensi_bidang");
            $("#simpan_detailpotensi").html("Tambahkan");
        });

        $("#table_detailpotensi").on('click','.edit', function(){
            var url = $(this).attr("href");
            $.get(url, function(data, status){
                var json = $.parseJSON(data);
                $.each(json, function(key,value){
                    $("select[name=id_jenis]").val(value['id_jenis']);
                    $("select[name=id_bidang]").val(value['id_bidang']);
                });
            });

            $("#formdetailpotensi").attr("action",url.replace("read","update"));
            $("#simpan_detailpotensi").html("Perbarui");
            return false;
        });

        $("#table_detailpotensi").on('click','.delete', function(){
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
