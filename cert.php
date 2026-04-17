<?php
@session_start();
// ini_set('display_errors', 1);

require('lib/fpdf.php');
require('lib/db_lib.php');

if($_SESSION['login'] != 1 ){
    exit("Maaf, anda tidak bisa mengakses halaman ini.");
}

$npm = (is_npm($_SESSION['username']))? $_SESSION['username']:'';

class PDF extends FPDF
{
    // Page header
    function Header()
    {

        $this->Image('resource/assets/images/cert/header.png',-0.5,0,211,0,'PNG');

    }

// Page footer
    function Footer()
    {  
        $this->Image('resource/assets/images/cert/bawah.png',-0.5,272,211,0,'PNG');

    }
}

// Instanciation of inherited class
$ser = db_read("SELECT `nama`,`npm`,`no`,`posisi`,`predikat`,`no_cert`,`tanggal_terbit` as `tanggal` FROM `vsertifikat` WHERE `npm` = '".$_SESSION['username']."'");
if(!count($ser) > 0)
    die("data tidak ada!!");

$data = $ser[0];
$tglacara = db_read("SELECT min(`tgl_mulai`) as mulai, MAX(`tgl_selesai`) as selesai FROM `acara_tahun` WHERE id_thn = ".$_SESSION['mhs_thn'])[0];
$tanggal = date('j m Y',strtotime($data['tanggal']));
$tahun = date('Y',strtotime($data['tanggal']));
$temp = explode(' ',$tanggal);
$tanggal = $temp[0].' '.nama_bulan_indo($temp[1]).' '.$temp[2];
$pdf = new PDF('P','mm','A4');
$pdf->setTitle('Sertifikat_PPM_'.$data['no_cert'].'.pdf');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('Dotdigital','','enhanced_dot_digital.php');
$pdf->SetFont('Dotdigital','',12);
$pdf->Text(5,17,$data['no_cert']);
$pdf->SetFont('Arial','B',11);
$pdf->Image("resource/mahasiswa/qrcode_sertif/".$_SESSION['username'].".png",64,196,48,0,'PNG');
$pdf->Image("resource/mahasiswa/foto_mhs/".$_SESSION['username'].".jpg",110,200.55,0,38.5,'JPG');
$pdf->SetX(0);
$pdf->SetY(80);
$pdf->Cell(190,6,'No : '.$data['no'],'',0,'C','','');
$pdf->SetFont('Arial','',12);
$pdf->SetY(90);
$pdf->MultiCell(190,6,"Diberikan Kepada :\n\n\n\nAtas partisipasinya sebagai :\n\n\nPada kegiatan :\n \n\n\nyang dilaksanakan tanggal ".singkat_tanggal($tglacara['mulai'],$tglacara['selesai'])."\ndi UNIVERSITAS AMIKOM YOGYAKARTA\n\nDengan Predikat :\n\n\nSertifikat ini diterbitkan di Yogyakarta, ".$tanggal,'','C',false);
$pdf->SetFont('Arial','B',12);
$pdf->SetY(140);
$pdf->MultiCell(190,6,"Penggalian Potensi Mahasiswa (PPM) ".$tahun." \n\"Show Your Creative Innovation\"",'','C',false);

$pdf->SetFont('Times','B',18);
$pdf->SetY(97);
$pdf->Cell(190,6,$data['nama'],'',0,'C','','');
$pdf->SetY(105);
$pdf->Cell(190,6,$data['npm'],'',0,'C','','');
$pdf->SetFont('Times','B',20);
$pdf->SetY(122);
$pdf->Cell(190,6,$data['posisi'],'',0,'C','','');
$pdf->SetY(182);
$pdf->Cell(190,6,strtoupper($data['predikat']),'',0,'C','','');
$pdf->SetY(268);
$pdf->SetFont('Arial','I',9);
$pdf->MultiCell(190,4,"Sertifikat ini diterbitkan oleh Direktur Kemahasiswaan Universitas Amikom Yogyakarta, \ndan dapat divalidasi di http://ppm.amikom.ac.id/ atau scan QRcode",'','L',false);
// $pdf->SetTextColor(248,87,2);
// $pdf->SetFont('Arial','',18);
$pdf->Output('I');
?>
