<?php
session_start();

require('lib/fpdf.php');
require('lib/qr_lib_gen/qrlib.php');
require('lib/db_lib.php');

if($_SESSION['login'] != 1 ){
    exit("Maaf, anda tidak bisa mengakses halaman ini.");
}
$id = (in_array($_SESSION['logged_as'],array('super_admin','ddi')) and isset($_GET['npm']))? $_GET['npm'] : $_SESSION['username'];
$qrnama = 'ppm'.get_active_year().'-'.$id;

$cek = db_read("SELECT * FROM barcode WHERE npm = '".$id."'");
    if (count($cek) < 1):
        $masukan = db_insert('barcode', array('npm' => $id,'qr_code' => $qrnama,'qr_level'=> 1));    
    endif;

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('resource/assets/images/co_card.png',10,30,190,0,'PNG');
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function ShadowCell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $color='G', $distance=-0.5)
    {
        if($color=='G')
            $ShadowColor = 100;
        elseif($color=='B')
            $ShadowColor = 0;
        else
            $ShadowColor = $color;
        $TextColor = $this->TextColor;
        $x = $this->x;
        $this->SetTextColor($ShadowColor);
        $this->Cell($w, $h, $txt, $border, 0, $align, $fill, $link);
        $this->TextColor = $TextColor;
        $this->x = $x;
        $this->y += $distance;
        $this->Cell($w, $h, $txt, 0, $ln, $align);
    }

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->setTitle('Cocard-PPM'.get_active_year().'-'.str_replace('.','_',$id).'.pdf');
$data = db_read("SELECT nama as nama, npm as nim , 
    concat(prodi.jenjang,' ',prodi.nama_prodi) as prodi ,
    concat(mahasiswa.tempat_lahir,', ',
    date_format(mahasiswa.tgl_lahir,'%d-%m-%Y')) as ttl,
    ifnull(kelompok.nama_kelompok,'Belum Punya Kelompok') as kelompok from mahasiswa 
    left join kelompok on mahasiswa.id_kelompok = kelompok.id 
    left join prodi on mahasiswa.id_prodi = prodi.id 
    where mahasiswa.npm = '".$id."'");

$temp_dir = "resource/mahasiswa/qrcode1/"; 
    if (!file_exists($temp_dir))
        mkdir($temp_dir);

    $qrnamafile = $qrnama.".png";
    $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
    $ukuran = 5; //batasan 1 paling kecil, 10 paling besar
    $padding = 3;

    QRCode::png($qrnama,$temp_dir.$qrnamafile,$quality,$ukuran,$padding);
$pdf->AliasNbPages();
$pdf->AddPage();
if(file_exists('resource/mahasiswa/foto_mhs/'.$id.'.jpg')):
    $pdf->Image('resource/mahasiswa/foto_mhs/'.$id.'.jpg',38.9,100,48,64,'JPG');
    else :
        $pdf->Image('resource/assets/images/troll.jpg',38.9,100,48,64,'jpg');
    endif;
    $pdf->Image('resource/assets/images/fill.png',36,96,53,73,'PNG');
$pdf->Image('resource/mahasiswa/qrcode1/'.$qrnama.'.png',93,120,43,0,'PNG');
$pdf->SetTextColor(255,255,255);
if(strlen(singkat_nama($data[0]['nama'])) <= 14):
    $pdf->SetFont('Arial','B',29);
    elseif(strlen(singkat_nama($data[0]['nama'])) <= 22):
        $pdf->SetFont('Arial','B',22);
    elseif(strlen(singkat_nama($data[0]['nama'])) <= 29):
        $pdf->SetFont('Arial','B',18);
    else:
        $pdf->SetFont('Arial','B',16);
endif;
$pdf->SetY(104);
$pdf->SetX(92);
$pdf->ShadowCell(70,0,ucwords(singkat_nama($data[0]['nama'])),0,0,'L');
$pdf->SetFont('Arial','B',18);
$pdf->SetY(114);
$pdf->SetX(91.8);
$pdf->ShadowCell(93,0,$data[0]['prodi'],0,0,'L');

$pdf->SetY(124);
$pdf->SetX(138);
$pdf->ShadowCell(93,0,'NPM : '.$data[0]['nim'],0,0,'L');


if(isset($_POST['hobi'])){
    $pdf->SetY(134);
    $pdf->SetX(138);
    $pdf->ShadowCell(93,0,'Hobi : ',0,0,'L');
    $hobis = explode(',',cleanchar($_POST['hobi']));
    if($jum = count($hobis) and $jum > 0){
        for ($i=0; $i < $jum; $i++) { 
            if($i >= 3)
                break;
            $pdf->SetY(142+$i*8);
            $pdf->SetX(138);
            $pdf->ShadowCell(93,0, ($i+1).'. '.trim($hobis[$i]),0,0,'L');
        }
    }
}

if(strlen(trim($data[0]['kelompok'])) > 22)
$pdf->SetY(168);
else
$pdf->SetY(173);
$pdf->SetX(40);
$pdf->SetFont('Arial','B',32);
$pdf->Multicell(130,10,$data[0]['kelompok'],0,'C');


$pdf->SetY(230);
$pdf->SetFont('Arial','I',11);
$pdf->SetTextColor(255,0,0);
$pdf->cell(5);
$pdf->Multicell(180,5,"Ini bagian Depan. \nFoto harus sudah diupload sesuai ketentuan jika tidak akan mengguakan foto default, bagi peserta ppm yang tidak mengindahkan aturan akan mendapat sanksi dari panitia pada saat pelaksanaan PPM. Harap mencetak cocard ini dengan kertas yang tebal, kemudia potong sesuai pola usahakan rapi, dan buat 2 lubagan di bagian atas cocard dan tambahkan tali. Agar bisa digunakan untuk kalung dada.",1,'C');
$pdf->SetY(158);


$pdf->AddPage();
if(file_exists('resource/mahasiswa/foto_mhs/'.$id.'.jpg')):
    $pdf->Image('resource/mahasiswa/foto_mhs/'.$id.'.jpg',38.9,100,48,64,'JPG');
else :
    $pdf->Image('resource/assets/images/troll.jpg',38.9,100,48,64,'jpg');
endif;
$pdf->Image('resource/assets/images/fill.png',36,96,53,73,'PNG');
$pdf->Image('resource/mahasiswa/qrcode1/'.$qrnama.'.png',93,120,43,0,'PNG');
$pdf->SetTextColor(255,255,255);
if(strlen(singkat_nama($data[0]['nama'])) <= 14):
    $pdf->SetFont('Arial','B',29);
    elseif(strlen(singkat_nama($data[0]['nama'])) <= 22):
        $pdf->SetFont('Arial','B',22);
    elseif(strlen(singkat_nama($data[0]['nama'])) <= 29):
        $pdf->SetFont('Arial','B',18);
    else:
        $pdf->SetFont('Arial','B',16);
endif;
$pdf->SetY(104);
$pdf->SetX(92);
$pdf->ShadowCell(70,0,ucwords(singkat_nama($data[0]['nama'])),0,0,'L');
$pdf->SetFont('Arial','B',18);
$pdf->SetY(114);
$pdf->SetX(91.8);
$pdf->ShadowCell(93,0,$data[0]['prodi'],0,0,'L');

$pdf->SetY(124);
$pdf->SetX(138);
$pdf->ShadowCell(93,0,'NPM : '.$data[0]['nim'],0,0,'L');


if(isset($_POST['hobi'])){
    $pdf->SetY(134);
    $pdf->SetX(138);
    $pdf->ShadowCell(93,0,'Hobi : ',0,0,'L');
    $hobis = explode(',',cleanchar($_POST['hobi']));
    if($jum = count($hobis) and $jum > 0){
        for ($i=0; $i < $jum; $i++) { 
            if($i >= 3)
                break;
            $pdf->SetY(142+$i*8);
            $pdf->SetX(138);
            $pdf->ShadowCell(93,0,($i+1).'. '.trim($hobis[$i]),0,0,'L');
        }
    }
}

if(strlen(trim($data[0]['kelompok'])) > 22)
$pdf->SetY(168);
else
$pdf->SetY(173);
$pdf->SetX(40);
$pdf->SetFont('Arial','B',32);
$pdf->Multicell(130,10,$data[0]['kelompok'],0,'C');
$pdf->SetY(230);
$pdf->SetFont('Arial','I',11);
$pdf->SetTextColor(255,0,0);
$pdf->cell(5);
$pdf->Multicell(180,5,"Ini bagian Belakang",0,'C');
$pdf->SetY(158);
$pdf->Output('I');
?>
