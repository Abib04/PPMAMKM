<table>
    <tr>
        <td>Internasional </td>
        <td> : </td>
        <td> <b><?= count(db_read("SELECT id_prestasi FROM vprestasi WHERE id_thn = ".get_year(get_active_year())." and cak_prestasi = 'Internasional'")) ?></b></td>
    </tr>
    <tr>
        <td>Nasional </td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_prestasi FROM vprestasi WHERE id_thn = ".get_year(get_active_year())." and cak_prestasi = 'Nasional'")) ?></b></td>
    </tr>
    <tr>
        <td>Regional </td>
        <td> : </td>
        <td><b><?= count(db_read("SELECT id_prestasi FROM vprestasi WHERE id_thn = ".get_year(get_active_year())." and cak_prestasi = 'Regional'")) ?></b> </td>
    </tr>
    <tr>
        <td>Daerah </td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_prestasi FROM vprestasi WHERE id_thn = ".get_year(get_active_year())." and cak_prestasi = 'Lokal'")) ?></b></td>
    </tr>
    <tr>
        <td><b>Total</b></td>
        <td> : </td>
        <td><b> <?= count(db_read("SELECT id_prestasi FROM vprestasi WHERE id_thn = ".get_year(get_active_year()))) ?></b></td>
        </tr>
</table>
<hr />
<div class="row">
<form action="<?= base_url('data.php?module=mod_prestasi&t=prestasi&op=read') ?>" method="get" name="form" id="form_">
    <div class="col-sm-3">
    <div class="form-group form-inline">
    <Select class="form-control" name="tingkat" id="tingkat">
    <option value="">Pilih Tingkat</option>
    <option value="Internasional">Internasional</option>
    <option value="Nasional">Nasional</option>
    <option value="Regional">Regonal</option>
    <option value="Lokal">Lokal</option>
    </Select></div></div>
    <div class="col-sm-4">
    <div class="form-group form-inline">
    <Select class="form-control" name="bidang" id="Bidang">
    <option value="">Pilih Bidang</option>
    <?php
    $bidang = db_read("Select * from bid_prestasi where status = 'Y'");
    foreach($bidang as $kbidang => $vbidang){
        echo "<option value=\"".$vbidang['id_bid_prestasi']."\">".$vbidang['nama_bid']."</option>";
    }
    ?>
    
    </Select></div>
    </div>
    <div class="col-sm-3"><button type"submit" class="btn btn-primary btn-sm" id="filter">Filter</button> <button id="reset" class="btn btn-primary btn-sm">reset</button></div>
    </form>
</div>
<hr />
<table class="table  table-striped table-bordered table-hovered" id="tbl_prestasi">
   <thead>
      <tr>
          <th>NPM</th>
          <th>Nama</th>
          <th>Tingkat</th>
          <th>Kategori</th>
          <th>Prestasi</th>
      </tr>
   </thead>
   <tbody></tbody>
   <tfoot>
    <tr>
        <th>NPM</th>
        <th>Nama</th>
        <th>Tingkat</th>
        <th>Kategori</th>
        <th>Prestasi</th>
    </tr>
    </tfoot>
</table>
<script>
$(document).ready(function() {
    var tabel = $('#tbl_prestasi').dataTable({ 
        "ajax":{
				"url" : "<?= base_url('data.php?module=mod_prestasi&t=prestasi').'&op=read'; ?>",
				"dataSrc" : ""
			},
			"deferRender": true,
			"columns":[
				{"data":"npm"},
				{"data":"nama"},
				{"data":"cak_prestasi"},
                {"data":"nama_bid"},
                {"data":"nama_prestasi"}
			] 
    });

    $("#form_").submit(function(){
        tabel.api().ajax.url($(this).attr('action')+"&"+$(this).serialize()).load();
        return false;
    });
    $("#reset").click(function(){
        tabel.api().ajax.url( "<?= base_url('data.php?module=mod_prestasi&t=prestasi').'&op=read'; ?>").reload();
        return false;
    });
});
</script>
