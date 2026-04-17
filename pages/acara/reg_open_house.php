<?php
$cek_potensi = ($_SESSION['cek_potensi']>0)? TRUE : cek_potensi();
if($cek_potensi){
?>
<style type="text/css">
    .form-conf input[type=file]{
        display: none;
    }

    .form-conf label{
        color: blue;
    }
</style>
<?php
$_date_open_reg = strtotime(get_session('oh_close'));
//$_date_open_reg = strtotime(date('2021-07-28 19:00:00'));
$_date_cetak = strtotime('2019-09-02 19:00:00');
$_now = strtotime(date('Y-m-d H:i:s'));

//if($_SESSION['username']=="21.12.9999"){ //Buat Maintenance


//if(get_session('mhs_thn') == '2018'){
$fullkuota=true;
if(get_session('mhs_thn') == get_id_active_year() and $fullkuota==false){
?>
<form action="<?php echo rules('act_insert_sesi'); ?>&t=sesi_ruang_oh" method="post" class="form form-inline form-multiline form-group-sm" role="form" id="formOH">
    <table class="table">
        <tr>
            <td style="border-top: 0px;width: 196px;"><label for="nama_kel">Nama Anggota Keluarga</label></td>
            <td style="border-top: 0px;">
                <select name="kel" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <?php
                        $sql = db_read("select id_kel, nama_kel, nama_hub_kel from vkeluarga where npm='".$_SESSION['username']."'");
                        foreach($sql as $val){
                            echo "<option value='".$val['id_kel']."'>".$val['nama_kel']." (".$val['nama_hub_kel'].")</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        
        <tr>
           
            <td style="border-top: 0px;"><label for="tanggal">Tanggal</label></td>
            <td style="border-top: 0px;">
                <select name="tanggal" class="form-control" requied>
                <option value="">--Pilih Tanggal</option>
                <?php
                    $sql= db_read("select distinct(tanggal) as tgl from vsesi where id_acara=3 and year(tanggal)='".get_active_year()."' ");
                    foreach($sql as $val){
                        echo "<option value=\"".$val['tgl']."\" >".$val['tgl']." </option>";
                    }
                ?>
                </select>
            <!--<input type="date" name="tanggal" class="form-control" value="<?php echo $sql[0]['tanggal_mulai']; ?>" readonly /></td>-->
        </tr>
        <tr>
            <td style="border-top: 0px;"><label>Pilih Jam </label></td>
            <td style="border-top: 0px;" id="tampil_jam" >
                
            </td>
        </tr>
        <tr>
            <td style="border-top: 0px;"><label>Pilih Ruang (Sesi Offline)</label></td>
            <td style="border-top: 0px;" id="tampil_ruang" >

            </td>
        </tr>
        <!-- waktu pandemi
        <tr>
            <td style="border-top: 0px;">Tempat</td>
            <td style="border-top: 0px;">[PERTEMUAN OFFLINE] Universitas AMIKOM Yogyakarta</td>
        </tr>
        -->
    </table>
    <p class="hiden"><button type="submit" class="btn btn-primary btn-sm" id="simpan_oh">Simpan</button></p><br />
</form>
<?php } //} ?>
<!--<p>Maaf Pendaftaran OpenHouse Sudah Di tutup</p>-->

<?php
        $sql = db_read("select * from vsesi_oh where npm='".$_SESSION['username']."' and id_thn=".$_SESSION['mhs_thn']." limit 1");
        
        // if (empty($sql) and $_SESSION['username']=="21.12.9999") {
        if (empty($sql)) {
        // echo rules('act_insert_sesi').'&t=sesi_ruang_oh';

?>
<!--<form action="<?php echo rules('act_insert_sesi'); ?>&t=sesi_ruang_oh" method="post" class="form form-inline form-multiline form-group-sm" role="form" id="formOHmn">-->
<!--    <table class="table">-->
<!--        <tr>-->
<!--            <td style="border-top: 0px;width: 196px;"><label for="nama_kel">Nama Anggota Keluarga</label></td>-->
<!--            <td style="border-top: 0px;">-->
<!--                <select name="kel" class="form-control" required>-->
<!--                    <option value="">-- Pilih --</option>-->
                    <?php
                        // $sql = db_read("select id_kel, nama_kel, nama_hub_kel from vkeluarga where npm='".$_SESSION['username']."'");
                        // foreach($sql as $val){
                        //     echo "<option value='".$val['id_kel']."'>".$val['nama_kel']." (".$val['nama_hub_kel'].")</option>";
                        // }
                    ?>
<!--                </select>-->
<!--            </td>-->
<!--        </tr>-->
        
<!--        <tr>-->
<!--            <td style="border-top: 0px;"><label for="tanggal">Tanggal</label></td>-->
<!--            <td style="border-top: 0px;">-->
<!--                <select name="tanggal" class="form-control" requied>-->
<!--                <option value="">--Pilih Tanggal</option>-->
                <?php
                    // $sql= db_read("select distinct(tanggal) as tgl from vsesi where id_acara=3 and year(tanggal)='".get_active_year()."' ");
                    // foreach($sql as $val){
                    //     echo "<option value=\"".$val['tgl']."\" >".$val['tgl']." </option>";
                    // }
                ?>
<!--                </select>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td style="border-top: 0px;"><label>Pilih Jam </label></td>-->
<!--            <td style="border-top: 0px;" id="tampil_jam" >-->
            
<!--            </td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td style="border-top: 0px;"><label>RUANGAN </label></td>-->
<!--            <td style="border-top: 0px;" id="tampil_ruang" >-->
               
<!--            </td>-->
<!--        </tr>-->
        
<!--    </table>-->
    <!--<p class="hiden"><button type="submit" class="btn btn-primary btn-sm" id="simpan_oh">Simpan</button></p><br />-->
<!--</form>-->
<script type="text/javascript">
$("select[name=tanggal]").change(function(){
            if($(this).val()==""){
                $("#tampil_jam").html('');$("#tampil_ruang").html('');
            }else{
                hasil = "<label class='radio-inline'><input type='radio' name='id_sesi' value='132' />13.00-14.40 - (Sesi 3 OH ONLINE)</label><br />"+
                "<label class='radio-inline'><input type='radio' name='id_sesi' value='133' />15.10-16.50 (Sesi 4 OH ONLINE)</label><br />";
                $("#tampil_jam").html(hasil);
                
                $.get("<?php echo rules('act_read_jam'); ?>"+"&tgl="+$(this).val(),function(data,status){
                    var json = $.parseJSON(data);
                    var hasil = "";
                    
                    $("input[type=radio][name=id_sesi]").on('change', function() {
                        console.log($(this).val());
                        var sesi = $(this).val();
                        var tgl = $("select[name=tanggal]").val();
                        $.get("<?php echo rules('act_read_sesi_oh'); ?>"+"&tgl="+tgl+"&sesi="+$(this).val(),function(data,status){
                            var json = $.parseJSON(data);
                            var hasil_jam = "";
                            var tersisa = 0;
                           
                            $.each(json, function(key,value){
                                tersisa = value['max_kuota']-value['terpakai'];
                                if (value['id_ruang']==sesi){
                                    if(tersisa>0){
                                        hasil_jam += "<label class='radio-inline'><input type='radio' name='id_ruang' value='"+value['id_ruang']+"' />" + value['nama_ruang']+" ("+tersisa+")</label><br />";
                                    }else{
                                        hasil_jam += "<label class='radio-inline'>"+value['nama_ruang']+" ("+tersisa+")</label><br />";
                                    }
                                }
                            });
                            $("#tampil_ruang").html(hasil_jam);
                        });
                    });
                });
            }
        });
</script>
<?php        
        }
        // else if (empty($sql)){
        //     echo "ditunggu ya";    
        //     }
        
        else{

?>
<p>Yang akan hadir pada acara open house maksimal 1 orang</p>
<table class="table table-bordered table-hovered" id="table_sesi_oh">
    <tr>
        <th>Nama</th>
        <th>Hubungan Keluarga</th>
        <th>No. Telepon</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Info</th>
    </tr>
    <?php 
       
        foreach ($sql as $key => $value) {
            echo "<tr>
                    <td>".$value['nama_kel']."</td>
                    <td>".$value['nama_hub_kel']."</td>
                    <td>".$value['telepon']."</td>
                    <td>".date_format(date_create($value['tanggal_mulai']),"d M Y")."</td>
                    <td>".$value['jam_mulai']."-".$value['jam_akhir']."</td>"
                    ;

            // if($value['file_kehadiran'] == ""){
            //     echo "<td>
            //             <a href='".base_url('invitation.php?id='.$value['id_sesi_oh'])."&id_kel=".$value['id_kel']."' target='_blank'>Cetak Surat Pernyataan</a><br><br>
            //             <form action='".base_url('data.php?module=mod_uploadfk&id='.$value['id_kel'])."' method='post' enctype='multipart/form-data' class='form-conf'>
            //                 <label for='konfirmasi' class='btn btn-default btn-sm' title='Masukkan file scan/foto surat penyataan kehadiran'>Upload Surat Pernyataan </label>
            //                 <a href='".base_url('resource/assets/images/contoh_pernyataan.jpg')."'  data-toggle='lightbox'> Contoh</a>
            //                 <input type='file' name='konfirmasi' id='konfirmasi' />
            //             </form><br>";
                       // <a href='".rules('act_delete_sesi')."&t=sesi_ruang_oh&op=delete&id=".$value['id_sesi_oh']."&npm=".$_SESSION['username']."&id_kel=".$value['id_kel']."' class='delete'>[Batalkan]</a>
            //         echo "</td>";
            //     echo"</tr>";
            // }else{
                echo "<td>";
                if($value['id_ruang']=='132'|$value['id_ruang']=='133'){
                    echo "pertemuan [Online] open house dengan menggunakan link berikut: <br/>".$value['nama_ruang'];
                }else{
                echo ($_now >= $_date_cetak)? (get_session('mhs_thn') == get_id_active_year() )?"<a href='".base_url('invitation.php?id='.$value['id_sesi_oh'])."&id_kel=".$value['id_kel']."' target='_blank'>Lihat dan Cetak Undangan</a>":'Sudah Bukan waktu untuk anda mencetak undangan.':"Cetak undangan tersedia dalam <span id='countdown'></span>";
                //echo "<br><a href=\"".base_url('resource/assets/images/denah.jpeg')."\" data-toggle='lightbox' >[Lihat denah Amikom]</a><br><br>";
                        //"<a href='".rules('act_delete_sesi')."&t=sesi_ruang_oh&op=delete&id=".$value['id_sesi_oh']."&npm=".$_SESSION['username']."&id_kel=".$value['id_kel']."' class='delete'>[Batalkan]</a>
                }
                echo "</td></tr>";
            }
        
    ?>
</table>
<hr />
<p>
    Perhatian : <br /><br />
    Silahkan datang sesuai jadwal yang nanti tertera di undangan.<br />
    OPEN HOUSE wajib karena ada hal penting yang akan disampaikan Lembaga kepada wali mahasiswa serta sebagai momen penyerahan mahasiswa dari orang tua kepada kampus untuk menimba ilmu di Universitas Amikom Yogkyakarta
</p>
<script type="text/javascript">
    $(document).ready(function(){
        if($("#table_sesi_oh tr").length > 1){
            $("#simpan_oh").attr("disabled","disabled");
            $(".hiden").html("");
        }
    

        $("select[name=tanggal]").change(function(){
            if($(this).val()==""){
                $("#tampil_jam").html('');$("#tampil_ruang").html('');
            }else{
                $.get("<?php echo rules('act_read_jam'); ?>"+"&tgl="+$(this).val(),function(data,status){
                    var json = $.parseJSON(data);
                    var hasil = "";
                    $.each(json, function(key,value){
                        hasil += "<label class='radio-inline'><input type='radio' name='id_sesi' value='"+value['id_sesi']+"' />" + value['jam_mulai'].substr(0,5)+"-"+ value['jam_akhir'].substr( 0, 5)+" ("+value['nama_sesi']+")</label><br />";
                    });
                    $("#tampil_jam").html(hasil);
                    
                    $("input[type=radio][name=id_sesi]").on('change', function() {
                        //console.log($(this).val());
                        var tgl = $("select[name=tanggal]").val();
                        $.get("<?php echo rules('act_read_sesi_oh_mn'); ?>"+"&tgl="+tgl+"&sesi="+$(this).val(),function(data,status){
                            var json = $.parseJSON(data);
                            var hasil_jam = "";
                            var tersisa = 0;
                            
                            $.each(json, function(key,value){
                                tersisa = value['max_kuota']-value['terpakai'];
                                if(tersisa>0){
                                    hasil_jam += "<label class='radio-inline'><input type='radio' name='id_ruang' value='"+value['id_ruang']+"' />" + value['nama_ruang']+" ("+tersisa+")</label><br />";
                                }else{
                                    hasil_jam += "<label class='radio-inline'>"+value['nama_ruang']+" ("+tersisa+")</label><br />";
                                }
                            });
                            $("#tampil_ruang").html(hasil_jam);
                        });
                    });
                });
            }
        });
        

        $("#formOH").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");
            
            var tgl = $("select[name=tanggal]").val();
            var sesi = $("input[type=radio][name=id_sesi]:checked").val();
            var ruang = $("input[type=radio][name=id_ruang]:checked").val();
            
            
            if(tgl==""){
                alert("Tanggal harus dipilih.");
            }else if(sesi=="" || sesi==undefined){
                alert("Jam harus dipilih.");
            }else if(ruang=="" || ruang==undefined){
                alert("Ruang (sesi offline) harus dipilih.");
            }else{

                $.ajax({
                    type: method,
                    url: target,
                    data: data,
                    beforeSend: function(){
                        $("#simpan_oh").attr("disabled","disabled");
                        $("#simpan_oh").html("Menunggu...");
                    }
                }).done(function(response){
                    //console.log(response);
                    if(response == "true"){
                        alert("Berhasil disimpan");
                        $("#simpan_oh").removeAttr("disabled");
                        $("#simpan_oh").html("Simpan");
                        location.reload();
                    }else{
                        alert("Gagal Menyimpan data!");
                        $("#simpan_oh").removeAttr("disabled");
                        $("#simpan_oh").html("Simpan");
                        location.reload();
                    }
                });
            }

            return false;
        });

        $("#konfirmasi").change(function(){
            if ($('#konfirmasi').val() != "") {
                $(".form-conf").submit();
            }
        });

        $("#table_sesi_oh").on('click','.delete', function(){
            var url = $(this).attr("href");
            var c = confirm("Yakin ingin membatalkan?");
            if(c == true){
                $.get(url, function(data, status){
                    if(data == "true"){
                        alert("Berhasil dibatalkan.");
                        location.reload();
                    }else{
                        location.reload();
                    }
                });
            }

            return false;
        });
    });
</script>
<?php if($_now < $_date_cetak){?>
<script>
$(document).ready(function(){
    var countDownDate = new Date('2022-09-24 19:00:00').getTime();
    
    // Update the count down every 1 second
    var x = setInterval(function() {
    
        // Get todays date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        $('#countdown').html(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
        // If the count down is over, reload the page
        if (distance < 0) {
            clearInterval(x);
            // location.reload();
        }
    }, 1000);
});
</script>
<?php } } ?>
<?php
    
}else{
    echo '<h4 style="color:red;"><b>Data Potensi</b> Harus diisi terlebih dahulu minimal satu</h4>';
}
?>
