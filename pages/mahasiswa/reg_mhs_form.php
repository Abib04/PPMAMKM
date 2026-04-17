<ul class="nav nav-tabs">
    <li class="active" role="presentation"><a href="#data_mhs" data-toggle="tab"><b>Data Mahasiswa</b></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="data_mhs">
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="npm">NPM</label>
                    <input type="text" class="form-control" name="npm" data-toggle="tooltip" data-placement="bottom" title="Masukkan NIM yang sudah terdaftar." required />
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" data-toggle="tooltip" data-placement="bottom" title="Masukkan Nama Lengkap." required />
                </div>
                <div class="form-group" style="margin-bottom:33px">
                    <label>Jenis Kelamin : </label><br />
                    <label class="radio-inline">
                      <input type="radio" name="jk" value="laki-laki"> Laki-Laki
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="jk" value="perempuan"> Perempuan
                    </label>
                </div>
                <div class="form-group">
                    <label>Tempat/Tgl Lahir</label>
                    <div class="row">
                        <div class="col-xs-5">
                            <input type="text" name="tempat_lahir" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Masukkan Tempat Kelahiran." required />  
                        </div>
                        <div class="col-xs-7">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" name="tgl_lahir" data-toggle="tooltip" data-placement="bottom" title="Masukkan Tanggal Lahir" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="agama">Agama</label>
                        <select name="agama" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Pilih sesuai dengan agama anda." required>
                            <option value="">-- Pilih --</option>
                            <?php
                                $agama = db_read("select * from agama where status='Y'");
                                foreach($agama as $val){
                                    echo "<option value='".$val['id_agama']."'>".$val['nama_agama']."</option>";
                                }
                            ?>
                        </select>           
                </div>
                <div class="form-group">
                    <label for="alamat_asal">Alamat Asal</label>
                    <textarea class="form-control" row="3" name="alamat_asal" data-toggle="tooltip" data-placement="bottom" title="Masukkan Alamat asal sesuai dengan KTP." required></textarea>
                </div>
                <div class="form-group">
                    <label for="negara">Kewarganegaraan</label>
                    <select name="negara" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Pilih kewarganegaraan." required>
                    <option value="">-- Pilih --</option>
                            <?php
                                $negara = db_read("select * from negara where status='Y'");
                                foreach($negara as $val){
                                    echo "<option value='".$val['id_negara']."'>".$val['nama_negara']."</option>";
                                }
                            ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="daerah">Asal Daerah</label>
                    <select name="daerah" class="form-control" title="Pilih daerah sesuai dengan KTP anda." data-toggle="tooltip" data-placement="bottom" disabled>
                    <option value="">-- Pilih --</option>
                            <?php
                                $daerah = db_read("select * from daerah where status='Y' order by nama_daerah asc");
                                foreach($daerah as $val){
                                    echo "<option value='".$val['id_daerah']."'>".$val['nama_daerah']."</option>";
                                }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kabupaten">Kabupaten</label>
                    <select name="kabupaten" class="form-control" data-toggle="tooltip" data-placement="bottom" disabled></select>
                </div>
                <div class="form-group">
                    <label for="kode_pos">Kode Pos</label>
                    <input type="text" class="form-control" name="kode_pos" maxlength="5" data-toggle="tooltip" data-placement="bottom" title="Masukkan Kode Pos sesuai dengan tempat tinggal di KTP." required />
                </div>
                <div class="form-group" style="margin-top: 20px">
                    <label for="slta_asal">Asal SLTA</label>
                    <input type="text" class="form-control" name="slta_asal" data-toggle="tooltip" data-placement="bottom" title="Masukkan asal SLTA anda." required />
                </div>
                <div class="form-group">
                    <label for="hp">No. Telepon</label>
                    <input type="tel" class="form-control" name="hp" data-toggle="tooltip" data-placement="bottom" title="Masukkan No. Telp. yang bisa dihubungi" maxlength="12" required />
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" data-toggle="tooltip" data-placement="bottom" title="Masukkan E-mail aktif." required />
                </div>
                <div class="form-group">
                    <label for="alamat_yk">Alamat di Yogyakarta</label>
                    <textarea class="form-control" row="3" name="alamat_yk" data-toggle="tooltip" data-placement="bottom" title="Masukkan Alamat anda di Yogyakarta" required></textarea>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $("select[name=kabupaten]").html("<option value=''>-- Pilih --</option>");

        $("select[name=negara]").change(function(){
            if($("select[name=negara]").val() == "101"){
                $("select[name=daerah]").removeAttr("disabled");
                $("select[name=daerah]").attr("title","Pilih Daerah anda.");
            }else{
                $("select[name=daerah]").attr("disabled","disabled");
                $("select[name=daerah]").attr("title","Silahkan pilih kewarganegaraan terlebih dahulu.");
            }
        });

        $("select[name=daerah]").change(function(){
            $.get("<?php echo rules('get_kabupaten'); ?>"+"&daerah="+$(this).val(), function(data, status){
                var json = $.parseJSON(data);
                var res = "<option value=''>-- Pilih --</option>";
                
                $.each(json, function(key,value){
                    res += "<option value='" + value['id_kab'] + "'>" + value['nama_kab'] + "</option>";
                })

                $("select[name=kabupaten]").html(res);
                $("select[name=kabupaten]").removeAttr("disabled");
            });
        });
    });
</script>
