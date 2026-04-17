<form action="<?php echo rules("act_change_passwd"); ?>" method="post" id="formGantiPasswd" class="form-group-sm">
	<div class="row">
		<div class="col-xs-5">
			<div class="form-group">
		        <label for="password_lama">Password Lama</label>
		        <input class="form-control" type="password" name="password_lama" />
		    </div>
		    <div class="form-group">
		        <label for="password_baru">Password Baru</label>
		        <input class="form-control" type="password" id="pwd" class="masked" name="password_baru" />
		    </div>
		    <label for="password_baru_conf">Ulangi Password</label>
		    <div class="input-group" style="width: 100%;">
                <input id="password_show" class="form-control" type="password" name="password_baru_conf">
                <span style="width:20%" id="password_show_button" class="input-group-addon"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
            </div><br>
		    <p>
		    	<button type="submit" id="simpan_passwd" class="btn btn-primary btn-sm">Simpan</button>
		    </p>
		</div>
	</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#password_show_button").mouseup(function(){
            $("#password_show").attr("type", "password");
        });
        $("#password_show_button").mousedown(function(){
            $("#password_show").attr("type", "text");
        });
    });


	$(document).ready(function(){
		$("#formGantiPasswd").submit(function(){
			var method = $(this).attr("method");
            var data = $(this).serialize();
            var target = $(this).attr("action");

            $.ajax({
                type: method,
                url: target,
                data: data,
                beforeSend: function(){
                    $(this).attr("disabled","disabled");
                    $(this).html("Menunggu...");
                }
            }).done(function(response){
                if(response == "true"){
                	alert("Berhasil diganti");
                	$(this).removeAttr("disabled");
                    $(this).html("Simpan");
                }else{
                	alert(response);
                	$(this).removeAttr("disabled");
                    $(this).html("Simpan");
                }
            });

            return false;
		});
	});
	
</script>
