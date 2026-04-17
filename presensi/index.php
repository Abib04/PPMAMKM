<?php
session_start();
include 'koneksi.php';

$id_acara = $_SESSION['acara'];

if(empty($_SESSION['acara'])) {
    header('location: login.php');
}

$date = date("Y-m-d");
$result = $db->query("SELECT * FROM acara WHERE id_acara = $_SESSION[acara]");
$acara = mysqli_fetch_assoc($result);

$result1 = $db->query("SELECT * FROM ruang WHERE id_ruang = $_SESSION[ruang]");
$ruang = mysqli_fetch_assoc($result1);

// $countSesi = $db->query("SELECT COUNT(*) FROM presensi LEFT JOIN vjadwalperson ON vjadwalperson.npm = presensi.npm and vjadwalperson.id_kelompok = presensi.id_kelompok
//                         and vjadwalperson.id_acara = 1 WHERE presensi.id_acara = $acara[id_acara] AND id_ruang = $acara[id_ruang] AND presensi.id_thn = 12 AND presensi.tgl = $date
//                         AND (jam_msk BETWEEN '06:32:04' AND '08:17:41')");

?>

<html>
    <head>
        <link rel="icon" href="images/fav.png" type="image/ico" sizes="32x32"> 
        <title>Presensi Mahasiswa PPM</title>

        <link rel="stylesheet" type="text/css" href="css/bulma.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/input-masked.js"></script>
        <script type="text/javascript" src="js/sound.js"></script>
        <script type="text/javascript" src="js/qrcodelib.js"></script>
        <script type="text/javascript" src="js/webcodecamjquery.js"></script>
    </head>

    <body class="has-background-white-ter" onkeydown="myManual()">

    	<div class="preloader">
            <div class="loading">
            <img src="images/load.gif" width="250">
            </div>
        </div>

    <div class="container body-index">

    	<div class="modal" id="manual">
  				<div class="modal-background"></div>
  			<div class="modal-card">
    				<header class="modal-card-head">
      					<p class="modal-card-title">Presensi Manual</p>
      					<button class="delete" data-dismiss="modal"></button>
    				</header>
    			<section class="modal-card-body">
                    <center><small><div class="hasil"></div></small></center>
    				<form id="manual">
    					<b style="font-size: 20px;">NIM:</b>
                		<input class="input npm" type="text" id='npm' autocomplete="off" ondblclick="createSelection(this,6,10);" >
                	</form>
    			</section>
    			<footer class="modal-card-foot">
      				<button class="button is-success" onclick="myAbsen()">Proses</button>
      				<button class="button" data-dismiss="modal">Kembali</button>
    			</footer>
  			</div>
		</div>


		<div class="modal" id="manual1">
  				<div class="modal-background"></div>
  			<div class="modal-card">
    				<header class="modal-card-head">
      					<p class="modal-card-title">Gagalkan Presensi</p>
      					<button class="delete" data-dismiss="modal"></button>
    				</header>
    			<section class="modal-card-body">
                    <center><small><div class="hasil"></div></small></center>
    				<form id="frm_btl">
    					<b style="font-size: 20px;">NIM:</b>
                		<input class="input npm" type="text" id='npm2' autocomplete="off">
                	</form>
    			</section>
    			<footer class="modal-card-foot">
      				<button class="button is-success" onclick="myAbsenG()">Proses</button>
      				<button class="button" data-dismiss="modal">Kembali</button>
    			</footer>
  			</div>
		</div>

    	<div class="columns">
            <div class="column is-4">
                <div class="box" style="position: relative;display: inline-block;">
                    <canvas></canvas>
                        <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                </div>
                <center><select class="select"></select></center><br>
                <p class="subtitle has-text-danger has-text-centered">
                    <a href="#" data-toggle="modal" data-target="#manual">Presensi Manual</a> (F4) <br>
                    <a href="#" data-toggle="modal" data-target="#manual1">Gagalkan Presensi</a> (F2)
                </p>
                <div class="notification is-warning" style="padding-top: 1px;">
                    <p class="subtitle">
                        <div id="status_cam">
                            
                            <div id="kamera_siap">Kamera Siap!</div>   
                        </div>                   
                        <div class="hasil"></div>
                    </p>
                </div>

                <?php if (in_array($_SESSION['username'],array('tim_ddi','dev'))) {
                ?>
                    <a href="export.php" class="button is-info" style="width: 100%">Export Presensi to Exel</a>
                <?php } ?>
            </div>
            
          
          <div class="column is-8">
                <div class="box">
                    <nav class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <p class="title has-text-weight-bold is-3">
                                    <?php echo $acara['nama_acara']; ?> | <?php echo $ruang['nama_ruang']; ?> 
                                </p>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <span class="title is-5" id="jam"></span> &nbsp; &nbsp;
                                <div class="buttons">
                                    <a href="pengaturan.php" class="button is-hover">Pengaturan</a>
                                    <a href="keluar.php" class="button is-danger">Keluar</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="show"><?php include 'absendata.php'; ?></div>

        </div>
        
        <div class="info-warning"></div>
        
        
    </div>
</div>

  <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

            // Fungsi Notifikasi
            function FungsiMenunggu() {
            $('#kamera_siap').hide();
            $('#cam_not_ready').fadeIn('fast');
            var sec = 1
            var timer = setInterval(function() { 
                $('#cam_not_ready span').text(sec--);
                if (sec < 0) {
                    $('li').fadeOut();
                    $('#cam_not_ready').hide();
                    $('#kamera_siap').show();                      
                    clearInterval(timer);                                               
                   } 
                }, 250);
            }


            // Fungsi Cek QRCODE Webcam
            var arg = {
                resultFunction: function(result) {
                $.post('aksi/qr_cek.php?aksi=cek',{id:result.code},function(data){
                if(data.status == 'sukses')
                {
                    FungsiMenunggu();
                    $('.hasil').html($('<li>' + data.ket+ '</li>'));
                    $('#data-tabel').prepend("<tr><td>"+data[0].nama+"</td><td>"+data[0].npm+"</td><td>JEC</td><td>"+data.jam+"</td></tr>");

                        // if (data.rows[0].foto=='')
                        // {
                        //     $('#foto_p').attr('src', 'images/no-image.jpg');
                        // }
                        // else
                        // {
                        //     $('#foto_p').attr('src', '../resource/mahasiswa/foto_mhs/'+ data.rows[0].npm+ '.jpg');
                        // }
                        // $('.show').load("absendata.php");                        
                    }
                    else 
                    {
                    FungsiMenunggu();
                    $('.hasil').html($('<li>' + data.ket+ '</li>'));
                        // $('.show').load("absendata.php");                        
                    }

                },'json');
                }
                };


                // Fungsi Cek NIM Absen Manual
            function myAbsen() {
                $.playSound("audio/beep.mp3");

                var input = $("input").val();
                $.post('aksi/oh_cek.php?aksi=cek',{id:input},function(data){
                    // var dt = JSON.parse(data);
                if(data !== undefined)
                {
                    FungsiMenunggu();
                    $('.hasil').html($('<li>' + data.ket+ '</li>'));
                    if(data.status == 'sukses')
                    $('#data-tabel').prepend("<tr><td>"+data[0].nama+"</td><td>"+data[0].npm+"</td><td>JEC</td><td>"+data.jam+"</td></tr>");
                }
                else 
                {
                FungsiMenunggu();
                $('.hasil').html($('<li class=has-text-centered><center> <b>NIM '+input+' tidak diketahui<b><center></li>'));
                }
                },'json');
            };


            // Fungsi cek NIM Gagal Absen
            function myAbsenG() {
                $.playSound("audio/beep.mp3");
            	var input1 = $("#npm2").val();

            	$.post('aksi/qr_cek.php?aksi=gagal',{id:input1},function(data){
                    console.log(data);
                    if ($.trim(data) == "berhasil") {
                    
                    FungsiMenunggu();
                    $('.hasil').html($('<li class=has-text-centered><center><b>\''+input1+'\' Berhasil Di hapus</b></li>'));
                    // $('.show').load("absendata.php");
                }
                    else if ($.trim(data) == "gagal") {
                
                    FungsiMenunggu();
                    $('.hasil').html($('<li class=has-text-centered><center><b>\''+input1+'\' Gagal di hapus</b><center></li>'));
                }
                });
            };
            
            function createSelection(field, start, end) {
                if( field.createTextRange ) {
                var selRange = field.createTextRange();
                selRange.collapse(true);
                selRange.moveStart('character', start);
                selRange.moveEnd('character', end);
                selRange.select();
                field.focus();
                } else if( field.setSelectionRange ) {
                field.focus();
                field.setSelectionRange(start, end);
                } else if( typeof field.selectionStart != 'undefined' ) {
                field.selectionStart = start;
                field.selectionEnd = end;
                field.focus();
                }
            }

            // Fungsi Webcam dan Select Camera
            var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
            decoder.buildSelectMenu("select");
            decoder.play();
            $('select').on('change', function(){
                decoder.stop().play();
            });

            
            // Load Mahasiswaa Absen
            // $(document).ready(function(){
            //     $('.show').load("absendata.php")
            // });


            // Fungsi event KLIK keyboard F4 dan F2
            function myManual(){
                if(event.keyCode == 115) {
                    $('#manual').modal('show');
                }
                else if(event.keyCode == 113) {
                    $('#manual1').modal('show');
                }
        	}
            
        </script>
        


        <script>
            // Fokus Form input Modal absen manual dan gagal absen
            $('#manual').on('shown.bs.modal', function () {
            $(".input").focus();
            });

            $('#manual1').on('shown.bs.modal', function () {
            $(".input").focus();
            });

            // menampilkan loading halaman selama 2dtk
            $(document).ready(function(){
            $(".preloader").fadeOut(1900);
            })
        </script>

        <script>
            // Membuat inputan Masking di form input absen manual dan gagal absen
        	$(document).ready(function($){
        		$('.npm').mask("99.99.9999", {placeholder:"__.__.____"});
        	});

        </script>
        <script>
        $(document).ready(function(){
            $('#manual').submit(function(){
                var inputText = document.getElementById('npm');
                myAbsen();
                createSelection(inputText,6,10);
                return false;
            });
            $('#frm_btl').submit(function(){
                var inputText = document.getElementById('npm2');
                myAbsenG();
                createSelection(inputText,6,10);
                return false;
            });
        });
        </script>
</body>
</html>
