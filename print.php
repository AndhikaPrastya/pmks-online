<?php
require('fpdf/fpdf.php');
require_once "functions.php";
require_once "config.php";

$id_laporan=$_GET['id_laporan'];
$laporan=query("SELECT * FROM laporan WHERE id_laporan='$id_laporan'")[0];

$hasil=query("SELECT a.*, b.* FROM hasil a JOIN alternatif b ON a.id_alternatif=b.id WHERE id_laporan='$id_laporan'");

#setting header laporan
$pdf=new FPDF('P','cm','A4');
$pdf->AddPage();
           
$pdf->SetFont('Times','',14);      
$pdf->Image('assets/img/logo-kopi.png',2,1,2.5,2.5);
$pdf->SetX(1.5);

#setting judul laporan dan header tabel
$judul = "LAPORAN SELEKSI TEMPAT USAHA KOPI";

#tampilkan judul laporan
$pdf->SetFont('Times','B',14);
$pdf->Cell(0,3, $judul, 0, 1, 'C');
$pdf->SetLineWidth(0.01);

#buat header tabel
$pdf->SetFont('Times','B',12);
$pdf->SetX(1.5);
$pdf->Cell(3,1,'Rangking',1,0,'C');
$pdf->Cell(5,1,'Kode alternatif',1,0,'C');
$pdf->Cell(5,1,'Nama Alternatif',1,0,'C');
$pdf->Cell(5,1,'Nilia',1,0,'C');

$i=1;
foreach ($hasil as $key ) {
$nama_alternatif=$key['nama_alternatif'];
$kode_alternatif=$key['kode_alternatif'];
$nilai=$key['nilai'];

$pdf->Ln(1);
$pdf->SetFont('Times','',11);
$pdf->SetX(1.5);
$pdf->Cell(3,1,"$i",1,0,'C');
$pdf->Cell(5,1,"$kode_alternatif",1,0,'C');
$pdf->Cell(5,1,"$nama_alternatif",1,0,'C');
$pdf->Cell(5,1,"$nilai",1,0,'C');

$i++;
}
 
$pdf->SetLineWidth(0);
$pdf->Ln();
$pdf->Output();

?>




