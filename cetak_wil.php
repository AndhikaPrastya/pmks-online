<?php
date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
require_once "config.php";

$desa=query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete FROM desa a 
               INNER JOIN kecamatan b USING (id_kec) WHERE a.is_delete=1 AND b.is_delete=1 
               AND a.nm_desa!='Tidak Ada' AND b.nm_kec!='Tidak Ada'
               ORDER BY b.nm_kec ASC");


$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
$data = '
<!DOCTYPE html>
<html>
<head>
   <title>Cetak Wilayah PMKS</title>
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
                     <font size="5">Data PMKS Wilayah Desa / Kelurahan</font><br>
               </center>
            </td>
         </tr>
   </table>
   <br>


   <table border="1" cellpadding="10" cellspacing="0" autosize="1" width="100%">
            <tr>
               <th><font size="3">No</font></th>
               <th><font size="3">Kecamatan</font></th>
               <th><font size="3">Kelurahan</font></th>
               <th><font size="3">Jumlah PMKS</font></th>
            </tr>';

            $i = 1;
            foreach ($desa as $row) {
            	    $id_desa = $row['id_desa'];
                    $jml_pmks = count(query("SELECT a.*,d.is_delete FROM pmks a 
                     INNER JOIN kk d USING (id_kk)
                     WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_desa=$id_desa"));

               $data .= '<tr>
                              <td style="text-align:center;"><font size="3">'. $i++ . '</font></td>
                              <td style="text-align:center;"><font size="3">'. $row["nm_kec"] .'</font></td>
                              <td style="text-align:center;"><font size="3">'. $row["nm_desa"] .'</font></td>
                              <td style="text-align:center;"><font size="3">'. $jml_pmks .'</font></td>
                        </tr>';
            }
            	$data .= '<tr>
                              <td colspan="3" style="text-align:center;"><font size="3"><b>Jumlah</b></font></td>';

            	$result_tol2 = query("SELECT * FROM pmks WHERE is_delete=1 ");
                $jml_tot2 =count($result_tol2);

                $data .= '    <td colspan="3" style="text-align:center;"><font size="3"><b>'. $jml_tot2 .'</b></font></td>
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