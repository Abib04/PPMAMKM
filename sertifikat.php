<?php

require('lib/fpdf.php');
require('lib/db_lib.php');

if($_SESSION['login'] != 1 ){
    exit("Maaf, anda tidak bisa mengakses halaman ini.");
}

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('resource/assets/images/tmp.png',10,30,190,0,'PNG');
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    // $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    // $this->Ln(20);
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
}

// Instanciation of inherited class
$pdf = new PDF();
$data = db_read("SELECT nama as nama, npm as nim , concat(mahasiswa.tempat_lahir,', ',date_format(mahasiswa.tgl_lahir,'%d-%m-%Y')) as ttl,(select kelompok.nama_kelompok from kelompok WHERE kelompok.id = mahasiswa.id_kelompok) as kelompok from mahasiswa where npm = '".$_SESSION['username']."'");
// array('nama' => 'RAHAYU DEWI KURNIANINGSIH',
//                 'nim' => '17.92.0042',
//                 'ttl' => 'Bekasi'.', '.'02-10-1992',
//                 'hobi' => 'A, B, C',
//                 'kelompok' => 'Sultan Hasanudin');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=http://2d-code.co.uk/',60,30,90,0,'PNG');
//$pdf->Image('resource/mahasiswa/foto_mhs/'.$_SESSION['username'].'.jpg',49,96,35,0,'JPG');
$pdf->SetFont('Arial','',14);
$pdf->SetTextColor(248,87,2);
$pdf->Text(95,105,$data[0]['nama']);
$pdf->Text(95,112,$data[0]['nim']);
$pdf->Text(95,119,$data[0]['ttl']);
$pdf->Text(95,126,'Hobi :');
$pdf->SetY(158);
$pdf->SetFont('Arial','',18);
$pdf->Cell(0,0,$data[0]['kelompok'],0,0,'C');
$pdf->Output();

//error_reporting(E_ALL & ~E_NOTICE);
?>
