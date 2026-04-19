
    <div class="form-group" id="action-buttons" style="background:#fff; padding:20px; border-radius:12px; border:1px solid #eaeaea; box-shadow:0 4px 6px rgba(0,0,0,0.02); margin-top:15px;">
        <label for="no" style="font-weight: 600; font-size: 1.1rem; color: var(--primary); margin-bottom: 15px; display: block;">No. Mahasiswa :</label>
        <div class="row">
            <div class="col-xs-12 col-md-4 mb-3">
                <input type="text" id="npm" name="id" class="form-control input-lg" style="border-radius: 8px; box-shadow: none;" placeholder="Masukkan NIM..." />
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="btn-group btn-group-justified" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="btn btn-primary act-btn" style="border-radius: 8px; font-weight: 600; flex: 1; padding: 10px;" data-url="<?= rules('act_conf_mhs') ?>"><i class="fa fa-check"></i> Konfirmasi</button>
                    <button type="button" class="btn btn-success act-btn" style="border-radius: 8px; font-weight: 600; flex: 1; padding: 10px;" data-url="<?= rules('act_reset_pass') ?>"><i class="fa fa-refresh"></i> Reset Sandi</button>
                    <button type="button" class="btn btn-danger act-btn" style="border-radius: 8px; font-weight: 600; flex: 1; padding: 10px;" data-url="<?= rules('act_aktifkan_tahun_ini') ?>"><i class="fa fa-power-off"></i> Aktifkan PPM Tahun Ini</button>
                </div>
            </div>
        </div>
    </div>
<div class="row">
      <div class="col-xs-12">
            <div class="" role="alert" id="alert_container" style="display: none;"></div>
      </div>
</div>
<script>
$(document).ready(function(){
    var form = $("#action-buttons");
    form.on('click','.act-btn',function(){
      var url = $(this).data('url');

      if (url === "<?= rules('act_reset_pass') ?>") {
            if (!confirm("Apakah Anda yakin ingin mereset sandi mahasiswa ini?")) {
                  return false;
            }
      }

      if (url === "<?= rules('act_aktifkan_tahun_ini') ?>") {
            if (!confirm("Apakah Anda yakin ingin mengaktifkan mahasiswa ke tahun ini?")) {
                  return false;
            }
      }

      $.get(url+'&xhr=ok&id='+$('#npm').val(),function(data){
            console.log(data);
            var obj = JSON.parse(data);
            $("#alert_container").removeClass();
            $("#alert_container").addClass(obj.class).html(obj.message);
            $("#alert_container").fadeIn(1000);
            // setTimeout(function(){$("#alert_container").removeClass("alert-danger alert-success").html("");},3000);
            setTimeout(function(){$("#alert_container").fadeOut(1000);},5000);
      });
      return false;
    });
});
</script>
