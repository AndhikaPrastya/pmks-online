<?php
date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
require_once "config.php";

$id = $_GET['id'];

$pmksx = query("SELECT * FROM pmks WHERE id_pmks='$id'")[0];
$pmks = query("SELECT a.*, b.*,c.*,d.*,f.*,g.*,h.id_kec,h.nm_kec AS nm_kec_kk,i.id_desa,i.nm_desa AS nm_desa_kk FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               INNER JOIN Kecamatan h ON d.id_kec = h.id_kec
                               INNER JOIN desa i ON d.id_desa = i.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_pmks = $id ");

$pmksy = query("SELECT a.*, b.*,c.*,d.*,f.*,g.* FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_pmks = $id ")[0];


$mpdf = new \Mpdf\Mpdf(['format' => 'legal']);
$data = '
<!DOCTYPE html>
<html>
<head>
   <title>Cetak PMKS</title>
</head>
<body>
   <table margin="auto">
      <tr>
         <td width="20%"><img src="assets/img/pmks.png" width="100px" height="100px"></td>
         <td width="85%">
         <center>
            <font size="5"><b>PEMERINTAH KABUPATEN INDRAMAYU<b></font><br>
            <font size="5"><b>JAWA BARAT<b></font><br>
            <font size="3">Jl.meyjen Sutoyo No.1E Telp. (0234) 2772205, 272327</font><br>
            <font size="3">Fax. (0234) 272797 Kode Pos 45212 E-mail indramayu@indramayukab.go.id</font><br>
         </center>
         </td>
         <td width="20%"><img src="assets/img/logo-blank.png" alt="logo-umc" width="100px" height="100px"></td>
      </tr>
      <tr>
         <td colspan="3"><hr></td>
      </tr>
   </table>

   <table margin="auto">
         <tr>
            <td width="10%">
               <center>
                     <font size="5">Data PMKS</font><br>
               </center>
            </td>
         </tr>
   </table>

   <table border="0" cellpadding="10" cellspacing="0" autosize="1" width="90%">';
          foreach ($pmks as $row) {

            $data .= '<tr>
                        <th colspan="3"><font size="3">IDENTITAS KEPALA KELUARGA</font></th>
                     </tr>
                     <tr>
                        <th  style="text-align:left"><font size="3">Nama Kepala Keluarga</font></th>
                        <td  style="text-align:left"><font size="3">:</font></td>
                        <td  style="text-align:left"><font size="3">'. $row["nm_kpl"] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Tanggal Lahir</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. date('d-M-Y', strtotime($row['tgl_lhr_kpl'])) .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">No NIK</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nik_kpl'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">No KK</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['no_kk'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Kecamatan</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_kec_kk'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Kelurahan/Desa</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_desa_kk'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Alamat</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['alamat_kpl'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Pendidikan</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['pendidikan_kpl'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Pekerjaan</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['pekerjaan_kpl'] .'</font></td>
                     </tr>
                     <tr>
                        <th colspan="3"><font size="3">IDENTITAS PENYANDANG KESEJAHTERAAN SOSIAL</font></th>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Nama</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_pmks'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">No NIK</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nik_pmks'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Nama Ibu Kandung</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_ibu_pmks'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Tanggal Lahir</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. date('d-M-Y', strtotime($row['tgl_lhr_pmks'])) .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Kecamatan</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_kec'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Kelurahan/Desa</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_desa'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Jenis Kelamin</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['jns_klm_pmks'] .'</font></td>
                     </tr>
                      <tr>
                        <th style="text-align:left"><font size="3">Pendidikan</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['pendidikan_pmks'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Kategori PMKS</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_kat'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Program Bantuan Yang Diterima</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['nm_program'] .'</font></td>
                     </tr>
                     <tr>
                        <th style="text-align:left"><font size="3">Hasil Survei</font></th>
                        <td style="text-align:left"><font size="3">:</font></td>
                        <td style="text-align:left"><font size="3">'. $row['hsl_survei'] .'</font></td>
                     </tr>
                     ';
          }

$data .= '</table>
<br>
<table border="0" autosize="1" width="100%">
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3">Indramayu, '.date("d M Y").' </font></td>
   </tr>
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3">A/n. Kepala Bidang Rehabilitasi Sosial Kab.Indramayu </font></td>
   </tr>
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3">Kepala Seksi Rebsos Anak dan Lanjut Usia</font></td>
   </tr>
 </table>
 <br>
 <br>
 <table border="0" autosize="1" width="100%">
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3"><b>ABDUL KHALIM<b></font></td>
   </tr>
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3">Penata Tk. I, III/d</font></td>
   </tr>
   <tr>
     <td></td>
     <td></td>
     <td width="50%" style="text-align:center;"><font size="3">NIP. 19650309 198903 1 012</font></td>
   </tr>
 </table>

</body>
</html>
';
$mpdf->Image('assets/img/logo.png',0,0,210,297,'png','',true,false);
$mpdf->WriteHTML($data);
$mpdf->Output();
?>