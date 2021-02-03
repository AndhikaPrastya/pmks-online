<?php
date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
require_once "config.php";

$kec=query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!='Tidak Ada'ORDER BY nm_kec ASC");

$ktr=query("SELECT * FROM kat_pmks WHERE is_delete=1 ORDER By nm_kat ASC");
$jml_ktr = count($ktr);


$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$data = '
<!DOCTYPE html>
<html>
<head>
   <title>Cetak Kriteria PMKS</title>
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
            <td width="30%">
               <center>
                     <font size="5">Data Kriteria PMKS</font><br>
               </center>
            </td>
         </tr>
   </table>
   <br>



   <table border="1" cellpadding="10" cellspacing="0" autosize="1" width="100%">
            <tr>
               <th rowspan="2"><font size="3">No</font></th>
               <th rowspan="2"><font size="3">Kecamatan</font></th>
               <th rowspan="2"><font size="3">Kabupaten</font></th>
               <th colspan="'.$jml_ktr.'"><font size="3">PMKS</font></th>
               <th rowspan="2"><font size="3">Jumlah</font></th>
            </tr>
            <tr>';
               foreach ($ktr as $row1) {
               $data .= '<td style="text-align:center;"><font size="3">'. $row1["nm_kat"] .'</font></td>';
               } 
               $data .= '</tr>';

            $i = 1;
            foreach ($kec as $row) {
                      $id_kec = $row['id_kec'];

               $data .= '<tr>
                              <td style="text-align:center;"><font size="3">'. $i++ . '</font></td>
                              <td style="text-align:center;"><font size="3">'. $row["nm_kec"] .'</font></td>
                              <td style="text-align:center;"><font size="3">Indramayu</font></td>';

              foreach ($ktr as $row2) {
                           $id_kat = $row2['id_kat_pmks']; 
                           $result = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec AND c.id_kat_pmks = $id_kat");
                           $jml =count($result);
               $data .= '<td style="text-align:center;"><font size="3">'. $jml . '</font></td>';
             }

               $result_tot = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec");
                          $jml_tot =count($result_tot);
               $data .= '<td style="text-align:center;"><font size="3">'. $jml_tot . '</font></td>';
             }

              $data .= '<tr>
                              <td colspan="3" style="text-align:center;"><font size="3"><b>Jumlah</b></font></td>';

             foreach ($ktr as $row3) {
                          $id_kat2 = $row3['id_kat_pmks'];
                          $result_tol = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND c.id_kat_pmks = $id_kat2");
                           $jml_tot =count($result_tol);

              $data .= '<td style="text-align:center;"><font size="3">'. $jml_tot . '</font></td>';
            }

             $result_tol2 = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 ");
                           $jml_tot2 =count($result_tol2);

             $data .= '<td style="text-align:center;"><font size="3">'. $jml_tot2 . '</font></td>
                		 </tr>';

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