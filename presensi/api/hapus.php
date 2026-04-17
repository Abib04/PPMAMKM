<?php
	include "../koneksi.php";
	
	$npm 	= $_POST['npm'];
	
	$delete = $db->query("DELETE FROM presensi1 WHERE npm ='$npm'");
	
	$respose = array();
	if($rows > 0)
	{
		if($delete)
		{
			$respose['code'] = 1;
			$respose['message'] = "Delete Success";
		}
		else
		{
		$respose['code'] = 0;
		$respose['message'] = "Failed Delete";
		}
	}
	else
	{
		$respose['code'] = 0;
		$respose['message'] = "Failed Delete, data not found";
	}
	
	echo json_encode($respose);
 ?>
