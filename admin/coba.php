<?php 
  require_once "../functions.php";

  $jml_DataHalaman = 5;
  $jml_responden = count(query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!='Tidak Ada'ORDER BY nm_kec ASC"));
  $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

  $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
  $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

  $kec=query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!='Tidak Ada'ORDER BY nm_kec ASC LIMIT $awaldata, $jml_DataHalaman");

?>

          <h1 class="h3 mb-4 text-judul">Data Kriteria PMKS</h1>

                <?php 
                $ktr=query("SELECT * FROM kat_pmks WHERE is_delete=1 ORDER By nm_kat ASC");
                $jml_ktr = count($ktr);
                 ?>

                <table  cellspacing="0" border="1">
                  <thead class="table-dark">
                    <tr>
                      <th rowspan="2" >No</th>
                      <th rowspan="2" >Kecamatan</th>
                      <th rowspan="2" >Kabupaten</th>
                      <th colspan="<?=$jml_ktr ?>" >PMKS</th>
                      <th rowspan="2" >Jumlah</th>
                      <th rowspan="2" >Aksi</th>
                    </tr>
                    <tr>
                      <?php foreach ($ktr as $row1):?>
                        <td ><?=$row1['nm_kat'] ?></td>
                      <?php endforeach; ?>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; 
                  foreach ($kec as $row):
                      $id_kec = $row['id_kec'];
                  ?>

                    <tbody>
                      <tr>
                        <td ><?=$i;?></td>
                        <td ><?=$row['nm_kec'];?></td>
                        <td >Indramayu</td>
                        
                       <?php  
                          foreach ($ktr as $row2):
                           $id_kat = $row2['id_kat_pmks']; 
                           $result = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec AND c.id_kat_pmks = $id_kat");
                           $jml =count($result);
                          ?>
                        <td ><?=$jml ?></td>
                      <?php endforeach; ?>

                        <?php
                          
                          $result_tot = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec");
                          $jml_tot[$id_kec] =count($result_tot);
                         ?>
                        <td ><?=$jml_tot ?></td>
                        <td >
                         <a href="laporan_krt_kec.php?id=<?=$id_kec ?>" class="btn btn-warning btn-sm">Detail</a>
                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" ><b>Jumlah</b></td>
                        <?php foreach ($ktr as $row3):
                          $id_kat2 = $row3['id_kat_pmks'];
                          $result_tol = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN kat_pmks c USING (id_kat_pmks) 
                                                 WHERE a.is_delete=1 
                                                 AND c.id_kat_pmks = $id_kat2");
                           $jml_tot[$id_kec] =count($result_tol); ?>
                           <?php 
                           print_r($jml_tot);

                            ?>
                        <td ><b><?=$jml_tot ?></b></td>
                        <?php endforeach; ?>
                        <?php $jml_tot_all =array_sum($jml_tot); ?> 
                        <td ><b><?=$jml_tot_all ?></b></td>
                    </tr>
                  </tbody>
                </table>

