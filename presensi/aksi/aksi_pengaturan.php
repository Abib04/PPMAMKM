<?php
include "../koneksi.php";

if($_GET['page']=='simpan')
{
	$kontras = $_POST['kontras'];
	$cerah   = $_POST['cerah'];
	$zoom  	 = $_POST['zoom'];
	$tajam 	 = isset($_POST['tajam']) ? strval($_POST['tajam']) : '';
	$hitam_p = isset($_POST['hitam_p']) ? strval($_POST['hitam_p']) : '';
	$p_horiz = isset($_POST['p_horiz']) ? strval($_POST['p_horiz']) : '';
	$p_vert  = isset($_POST['p_vert']) ? strval($_POST['p_vert']) : '';

	/* FLIP VERTICAL */
	if ($p_vert=='on')
	{
		$flipV=1;
	}
	else
	{
		$flipV=0;
	}
	/* FLIP HORIZONTAL */	
	if ($p_horiz=='on')
	{
		$flipH=1;
	}
	else
	{
		$flipH=0;
	}
	/* HITAM PUTIH */
	if ($hitam_p=='on')
	{
		$h_p=1;
	}
	else
	{
		$h_p=0;
	}
	/* KETAJAMAN */
	if ($tajam=='on')
	{
		$sharp="[0, -1, 0, -1, 5, -1, 0, -1, 0]";
	}
	else
	{
		$sharp="[]";
	}

	$line=file('../js/webcodecamjquery.js',FILE_SKIP_EMPTY_LINES);
	$line[56]="            flipVertical: ".$flipV.","."\n";
	$line[57]="            flipHorizontal: ".$flipH.","."\n";
	$line[58]="            zoom: ".$zoom.","."\n";
	$line[61]="            brightness: ".$cerah.","."\n";//+1 JIKA LINE 50 maka 49
	$line[63]="            grayScale: ".$h_p.","."\n";
	$line[64]="            contrast: ".$kontras.","."\n";
	$line[66]="            sharpness: ".$sharp.","."\n";
	$content=implode('',$line);
	file_put_contents('../js/webcodecamjquery.js',$content);
}
?>
