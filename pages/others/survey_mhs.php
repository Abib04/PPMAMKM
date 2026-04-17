<?php $sql = db_read("select * from kuisioner where npm='".$_SESSION['username']."'"); ?>
<style>
.form-group > label{
    font-weight: normal;
}
</style>
<form action="<?php echo rules('act_insert_kuisioner'); ?>" method="post" class="form-group-sm">
    <div class="form-group">
        <label>1) Apakah kegiatan PPM 2017 ini berjalan sukses dan alasanya?</label>
        <br />
        <input type="radio" name="rad_1" id="rad_1_ada" value="ya" required />
        <label for="rad_1_ada">Ya</label><br />
        <input type="radio" name="rad_1" id="rad_1_tidak" value="tidak" />
        <label for="rad_1_tidak">Tidak</label>
    </div>
    <div class="form-group">
        <label for="alasan_1">Alasan: </label>
        <textarea class="form-control" name="alasan_1"><?php echo (isset($sql[0]['alasan_1'])) ? $sql[0]['alasan_1'] : ""; ?></textarea>
    </div>

    

    <div class="form-group">
        <label>2) Kinerja panitia dalam melaksanakan kegiatan PPM 2017?</label>
        <br />
        <input type="radio" name="rad_3" id="rad_3_baik" value="baik" required />
        <label for="rad_3_baik">Baik</label><br />
        <input type="radio" name="rad_3" id="rad_3_cukup" value="cukup" />
        <label for="rad_3_cukup">Cukup</label><br />
        <input type="radio" name="rad_3" id="rad_3_kurang" value="kurang"/>
        <label for="rad_3_kurang">Kurang Baik</label>
    </div>

    <div class="form-group">
        <label for="alasan_4">3) Pengalaman yang paling menyenangkan selama PPM 2017?</label>
        <textarea class="form-control" name="alasan_4" required><?php echo (isset($sql[0]['alasan_4'])) ? $sql[0]['alasan_4'] : ""; ?></textarea>
    </div>

    <div class="form-group">
        <label for="alasan_5">4) Pengalaman yang tidak menyenangkan selama PPM 2017?</label>
        <textarea class="form-control" name="alasan_5" required><?php echo (isset($sql[0]['alasan_5'])) ? $sql[0]['alasan_5'] : ""; ?></textarea>
    </div>

    <div class="form-group">
        <label for="alasan_6">5) Secara umum bagaimana perasaan Anda telah mengikuti PPM 2017?</label>
        <textarea class="form-control" name="alasan_6" required><?php echo (isset($sql[0]['alasan_6'])) ? $sql[0]['alasan_6'] : ""; ?></textarea>
    </div>

    <div class="form-group">
        <label for="alasan_7">6) Apa saja yang perlu diperbaiki dari kegiatan PPM 2017?</label>
        <textarea class="form-control" name="alasan_7" required><?php echo (isset($sql[0]['alasan_7'])) ? $sql[0]['alasan_7'] : ""; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="alasan_8">7) Pesan dan Kesan selama mengikuti kegiatan PPM 2017</label>
        <textarea class="form-control" name="alasan_8" required><?php echo (isset($sql[0]['alasan_8'])) ? $sql[0]['alasan_8'] : ""; ?></textarea>
    </div>

    <?php if(count($sql) > 0):?>
        <p><b>Terima kasih Anda sudah mengisi survey</b></p>
    <?php else: ?>
        <button class="btn btn-primary btn-sm text-right" type="submit">Simpan</button>
    <?php endif; ?>
</form>

<script>
    $(document).ready(function(){
        $("form").submit(function(){
            var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $("button").attr("disabled","disabled");
                    $("button").html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                    alert("Terima kasih telah mengisi survey.");
                    location.reload();
                }else{
                    alert(response);
                    $("button").removeAttr("disabled");
                    $("button").html("Simpan");
                }
            });

            return false;
        });

        <?php if(count($sql) > 0): ?>
                    $("input[name=rad_1]:radio[value=<?php echo $sql[0]['opsi_1']; ?>]").prop("checked",true);
                    $("input[name=rad_2]:radio[value=<?php echo $sql[0]['opsi_2']; ?>]").prop("checked",true);
                    $("input[name=rad_3]:radio[value=<?php echo $sql[0]['opsi_3']; ?>]").prop("checked",true);
        <?php endif; ?>
    });
</script>
