<table>
    <tr>
        <td><b>Akademik</b></td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_potensi FROM vpotensi WHERE jenis_potensi='Akademik' AND id_thn = ".get_year(get_active_year()))) ?></b></td>
    </tr>
    <tr>
        <td><b>Non Akademik</b></td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_potensi FROM vpotensi WHERE jenis_potensi='Non-Akademik' AND id_thn = ".get_year(get_active_year()))) ?></b></td>
    </tr>
    <tr>
        <td><b>Total</b></td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_potensi FROM vpotensi WHERE id_thn = ".get_year(get_active_year()))) ?></b></td>
    </tr>
</table>
<hr />
<div class="row">
<form action="<?= base_url('data.php?module=mod_potensi&t=potensi&op=read_spesial') ?>" method="get" name="form" id="form_">
    <div class="col-sm-2">
        <div class="form-group form-inline">
        <Select class="form-control" name="id_thn" id="id_thn">
        <option value="">Tahun</option>
        <?php
        $thn = db_read("Select * from tahun order by thn DESC ");
        foreach($thn as $kthn => $vthn){
            echo "<option value=\"".$vthn['id_thn']."\">".$vthn['thn']."</option>";
        }
        ?>
        
        </Select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group form-inline">
        <Select class="form-control" name="jenis" id="Jenis">
        <option value="">Pilih Jenis</option>
        <?php
        $jenis = db_read("Select * from jenis_potensi ");
        foreach($jenis as $kjenis => $vjenis){
            echo "<option value=\"".$vjenis['id_jenis']."\">".$vjenis['jenis_potensi']."</option>";
        }
        ?>
        
        </Select>
        </div>
    </div>
    <div class="col-sm-3">
    <div class="form-group form-inline">
    <Select class="form-control" name="bidang" id="Bidang">
    <option value="">Pilih Bidang</option>
    <?php
    $bidang = db_read("Select * from bidang ");
    foreach($bidang as $kbidang => $vbidang){
        echo "<option value=\"".$vbidang['id_bidang']."\">".$vbidang['nama_bidang']."</option>";
    }
    ?>
    
    </Select></div>
    </div>
    <div class="col-sm-3"><button type"submit" class="btn btn-primary btn-sm" id="filter">Filter</button> 
    <button type="button" id="reset" class="btn btn-primary btn-sm">reset</button></div>
    </form>
</div>
<hr />
<table class="table  table-striped table-bordered table-hovered" id="tbl_potensi">
   <thead>
      <tr>
          <th>NPM</th>
          <th>Nama</th>
          <th>Kontak</th>
          <th>Kontak Wali</th>
          <th>Jenis Potensi</th>
          <th>Bidang</th>
          <th>Potensi</th>
      </tr>
   </thead>
   <tbody></tbody>
   <tfoot>
    <tr>
        <th>NPM</th>
        <th>Nama</th>
        <th>Kontak</th>
        <th>Jenis Potensi</th>
        <th>Bidang</th>
        <th>Potensi</th>
    </tr>
    </tfoot>
</table>
<script>
$(document).ready(function() {
    var tabel = $('#tbl_potensi').dataTable({ 
        "ajax":"<?= base_url('data.php?module=mod_potensi&t=potensi').'&op=read_spesial'; ?>",
			"deferRender": true,
			"processing": true,
            "serverSide": true,
            "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"],
            ],
            "iDisplayLength": 25,
			"columns":[
				{"data":"npm"},
				{"data":"nama"},
                {"data":"kontak_mhs"},
                {"data":"kontak_wali"},
				{"data":"jenis_potensi"},
                {"data":"nama_bidang"},
                {"data":"potensi"}
                
			]
    });

    $("#form_").submit(function(){
        tabel.api().ajax.url($(this).attr('action')+"&"+$(this).serialize()).load();
        return false;
    });
    $("#reset").click(function(){
        //tabel.api().ajax.url( "<?= base_url('data.php?module=mod_potensi&t=potensi').'&op=read'; ?>").reload();
        //alert("|TES");
        //return true;
        $("select[name=jenis]").val("");
        $("select[name=bidang]").val("");
        tabel.api().ajax.url( "<?= base_url('data.php?module=mod_potensi&t=potensi').'&op=read_spesial'; ?>").load();
    });
});
</script>
