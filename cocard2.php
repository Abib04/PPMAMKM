<?php

require('lib/fpdf.php');
require('lib/qr_lib_gen/qrlib.php');

$id = '16.01.3906';
$qrnama = 'ppm2018-16.01.3906';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        // $this->Image('resource/assets/images/co_card.png',10,30,190,0,'PNG');
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

    $nama = 'ENGGAR WICAKSONO';
    $npm = '16.01.3906';
    $asal = 'TEMANGGUNG';
    $kelompok = 'PULAU MIANGAS';

// Instanciation of inherited class
$pdf = new PDF();
$pdf->setTitle('Cocard-PPM2018-16.01.3906.pdf');

$pdf->AliasNbPages();
$pdf->AddPage();

    $pdf->Image('resource/mahasiswa/foto_mhs/troll.jpg',21.7,101,43,0,'JPG');

$pdf->Image('resource/assets/images/frn_cocard.png',10,10,190,0,'PNG');

$pdf->Image('resource/mahasiswa/foto_mhs/troll.jpg',80,167,50,0,'PNG');
$pdf->SetTextColor(51,44,43);
    $pdf->SetFont('Arial','',20);

$pdf->SetY(113);
$pdf->cell(90);
$pdf->ShadowCell(100,0,': '.$nama,0,0,'L');

$pdf->SetFont('Arial','',20);
$pdf->SetY(124);
$pdf->cell(90);
$pdf->ShadowCell(93,0,': '.$npm,0,0,'L');

$pdf->SetY(135);
$pdf->cell(90);
$pdf->ShadowCell(93,0,': '.$asal,0,0,'L');

$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','I',30);
$pdf->SetY(90);
$pdf->cell(20);
$pdf->ShadowCell(150,0,$kelompok,0,0,'C');

$pdf->SetFont('Arial','I',11);
$pdf->SetTextColor(255,0,0);
$pdf->SetY(245);
$pdf->cell(5);
$pdf->Multicell(180,5,"Ini bagian Depan. \nFoto harus sudah diupload sesuai ketentuan jika tidak akan mengguakan foto default, bagi peserta ppm yang tidak mengindahkan aturan akan mendapat sanksi dari panitia pada saat pelaksanaan PPM. Harap mencetak cocard ini dengan kertas yang tebal, kemudia potong sesuai pola usahakan rapi, dan buat 2 lubagan di bagian atas cocard dan tambahkan tali. Agar bisa digunakan untuk kalung dada.",1,'C');
$pdf->SetY(158);

$pdf->Output('I');
?>
