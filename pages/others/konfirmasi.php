
   <div class="form-group" id="action-buttons">
      <lable for="no">
	No. Mahasiswa :
      <div class="row">
      <div class="col-xs-3">
	      <input type="text"  id="npm" name="id" class="form-control" />
      </div>
      <div class="col-xs-9">
            <div class="btn-group">
                  <button  type="button" class="btn btn-primary act-btn" data-url="<?= rules('act_conf_mhs') ?>">Konfirmasi</button></div>
                  <button  type="button" class="btn btn-success act-btn" data-url="<?= rules('act_reset_pass') ?>">Reset Sandi</button>
                  <button  type="button" class="btn btn-danger act-btn" data-url="<?= rules('act_aktifkan_tahun_ini') ?>">Aktifkan mahasiswa untuk PPM Tahun Ini</button>
      </div>
      </div>
      </lable>
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
