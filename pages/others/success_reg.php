Berhasil Disimpan!<br />Silahkan login dengan akun berikut:<br /><br />

Nomor Mahasiswa : <span style="font-weight:bold" id="npm"><?= $_SESSION['success_npm'] ?></span> 
<span style="background-color:#fff; font-size: smaller; cursor: pointer;" onclick="copyToClipboard('#npm')"> Salin </span><br />
Password        : <span style="font-weight:bold" id="password">
<?php
$passwd = $_SESSION['success_passwd'];
$len = strlen($passwd);
if ($len > 2) {
  echo htmlspecialchars($passwd[0] . str_repeat('*', $len - 2) . $passwd[$len - 1]);
} elseif ($len == 2) {
  echo htmlspecialchars($passwd[0] . '*');
} else {
  echo htmlspecialchars($passwd);
}
?>
</span> 
<!-- <span style="background-color:#fff; font-size: smaller; cursor: pointer;" onclick="copyToClipboard('#password')"> Salin </span> -->

<!-- Password dapat diganti setelah anda login. -->

<div id="snackbar">Berhasil di salin!</div>

<style>
    
    #snackbar {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
    }

    #snackbar.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;} 
      to {bottom: 30px; opacity: 1;}
    }
    
    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    
    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;} 
      to {bottom: 0; opacity: 0;}
    }
    
    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
    
</style>

<script>
	$(document).ready(function(){
		setCookie('nama','',0);
		setCookie('npm','',0);
		setCookie('tempat_lahir','',0);
		setCookie('tgl_lahir','',0);
		setCookie('jk_mhs','',0);
		setCookie('agama','',0);
		setCookie('daerah','',0);
		setCookie('negara','',0);
		setCookie('kabupaten','',0);
		setCookie('kecamatan','',0);
		setCookie('alamat_asal','',0);
		setCookie('alamat_yk','',0);
		setCookie('rt','',0);
		setCookie('rw','',0);
		setCookie('kode_pos','',0);
		setCookie('slta_asal','',0);
		setCookie('hp','',0);
		setCookie('email','',0);
	});
	
	// copy clipboard
	function copyToClipboard(element) {
          var $temp = $("<input>");
          $("body").append($temp);
          $temp.val($(element).text()).select();
          document.execCommand("copy");
          $temp.remove();
          
          var x = document.getElementById("snackbar");
          
        if(element == '#npm'){
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            const input = document.getElementById("usr");
            input.focus();
            input.select();
        }else if(element == '#password'){
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            const input = document.getElementById("pwd");
            input.focus();
            input.select();
        }
	}

</script>
