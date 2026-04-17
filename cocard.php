<?php
ini_set('display_errors', 1);
@session_start();

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
        // $this->Image('resource/assets/images/co_card_2023.jpg',10,30,190,0,'JPG');
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
    kabupaten.nama_kab as kab,
    ifnull(kelompok.nama_kelompok,'') as kelompok, prodi.nama_prodi from mahasiswa 
    left join kelompok on mahasiswa.id_kelompok = kelompok.id 
    left join kabupaten on mahasiswa.id_kab = kabupaten.id_kab
    left join prodi on mahasiswa.id_prodi = prodi.id 
    where mahasiswa.npm = '".$id."' ");
$nama = '';$npm = '';$hobi = (isset($_POST['hobi']))? $_POST['hobi']:'';$prodi='';$kelompok='';
foreach ($data as $mhs) {
    $nama = $mhs['nama'];
    $npm = $mhs['nim'];
    $nama_prodi = $mhs['nama_prodi'];
    $asal = $mhs['kab'];
    $kelompok = $mhs['kelompok'];
}
if(count($data) == 0)
    exit('data gak ada');
$temp_dir = "resource/mahasiswa/qrcode_cocard/"; 
    if (!file_exists($temp_dir))
        mkdir($temp_dir);

    $qrnamafile = $qrnama.".png";
    $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
    $ukuran = 5; //batasan 1 paling kecil, 10 paling besar
    $padding = 3;

    QRCode::png($qrnama,$temp_dir.$qrnamafile,$quality,$ukuran,$padding);
    
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('resource/assets/images/cocard_ppm_2025.png',40,1,-170,'JPG');
$pdf->Image('resource/mahasiswa/qrcode_cocard/'.$qrnama.'.png',140,170,25,0,'PNG');

if(file_exists('resource/mahasiswa/foto_mhs/'.$id.'.jpg')) {
    $pdf->Image('resource/mahasiswa/foto_mhs/'.$id.'.jpg',95,156,40,50,'JPG');
}  else {
    $pdf->Image('resource/assets/images/troll.jpg',95,156,40,50,'jpg');
}

$pdf->SetTextColor(51,44,43);
if(strlen(singkat_nama($nama)) > 17)
    $pdf->SetFont('Arial','',20);
else
    $pdf->SetFont('Arial','',22);
    
    // echo $kelompok;

$n=45;
$y=92;

$pdf->SetY($y);
$pdf->cell($n);
$pdf->ShadowCell(100,0,ucwords(singkat_nama($nama)),0,0,'L');

$pdf->SetFont('Arial','',22);
$pdf->SetY($y+24);
$pdf->cell($n);
$pdf->ShadowCell(100,0,ucwords(singkat_nama($nama_prodi)),0,0,'L');

$pdf->SetFont('Arial','',19);
$pdf->SetY($y+51);
$pdf->cell($n);
$pdf->ShadowCell(100,0,ucwords(singkat_nama($kelompok)),0,0,'L');

// if(strlen($asal) > 17)
//     $pdf->SetFont('Arial','',16);
// else
//     $pdf->SetFont('Arial','',20);
// $pdf->SetY($y+53);
// $pdf->cell($n);
// $pdf->ShadowCell(100,0,$asal,0,0,'L');


$pdf->SetFont('Arial','I',11);
$pdf->SetTextColor(255,0,0);
$pdf->SetY(265);
$pdf->cell(5);
$pdf->Multicell(180,5,"Harap mencetak cocard ini dengan kertas yang tebal, kemudian potong sesuai pola usahakan rapi, dan buat 2 lubangan di bagian atas cocard dan tambahkan tali. Agar bisa digunakan untuk kalung dada.",1,'C');
$pdf->SetY(158);

$pdf->Output('I');
?>
