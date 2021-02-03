<?php 
session_start();
// if (isset($_SESSION["admin"])){
//     header("location:admin/index.php");
//     exit;
// }
// if (isset($_SESSION["pimpinan"])){
//     header("location:admin/index.php");
//     exit;
// }
// if (!isset($_SESSION["pegawai"])){
//     header("location:../index.php");
//     exit;
// }

  $page = "laporan";
  $page1 = "prog";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $jml_DataHalaman = 5;
  $jml_responden = count(query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!='Tidak Ada'ORDER BY nm_kec ASC"));
  $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

  $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
  $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

  $kec=query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!='Tidak Ada'ORDER BY nm_kec ASC LIMIT $awaldata, $jml_DataHalaman");

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data Program Bantuan PMKS</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                 <a href="../cetak_prog.php" target="_blank" class="btn btn-info"> Cetak</a>
                </div>

                <?php 
                $prog=query("SELECT * FROM program_bantuan WHERE is_delete=1 ORDER By nm_program ASC");
                $jml_prog = count($prog);
                 ?>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th rowspan="2" style="text-align: center;vertical-align: middle;"class="text-center">No</th>
                      <th rowspan="2" style="text-align: center;vertical-align: middle;"class="text-center">Kecamatan</th>
                      <th rowspan="2" style="text-align: center;vertical-align: middle;"class="text-center">Kabupaten</th>
                      <th colspan="<?=$jml_prog ?>" style="text-align: center;vertical-align: middle;"class="text-center">Program Bantuan</th>
                      <th rowspan="2" style="text-align: center;vertical-align: middle;"class="text-center">Jumlah</th>
                      <th rowspan="2" style="text-align: center;vertical-align: middle;"class="text-center">Aksi</th>
                    </tr>
                    <tr>
                      <?php foreach ($prog as $row1):?>
                        <td class="text-center"><?=$row1['nm_program'] ?></td>
                      <?php endforeach; ?>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; ?>
                  <?php foreach ($kec as $row):
                      $id_kec = $row['id_kec'];
                  ?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><?=$row['nm_kec'];?></td>
                        <td class="text-left">Indramayu</td>
                        
                       <?php  
                          foreach ($prog as $row2):
                           $id_prog = $row2['id_program']; 
                           $result = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN program_bantuan c USING (id_program) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec AND c.id_program = $id_prog");
                           $jml =count($result);

                          ?>
                        <td class="text-center"><?=$jml ?></td>
                      <?php endforeach; ?>

                        <?php 
                          $result_tot = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN program_bantuan c USING (id_program) 
                                                 WHERE a.is_delete=1 
                                                 AND b.id_kec = $id_kec");
                           $jml_tot =count($result_tot);
                         ?>
                        <td class="text-center"><?=$jml_tot ?></td>
                        <td class="text-center">
                         <a href="laporan_prog_kec.php?id=<?=$id_kec ?>" class="btn btn-warning btn-sm">Detail</a>
                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>

                    <?php if ($pageAktif==$jml_Halaman): ?>
                      
                    <tr>
                        <td colspan="3" class="text-center"><b>Jumlah</b></td>
                        <?php foreach ($prog as $row3):
                          $id_prog2 = $row3['id_program'];
                          $result_tol = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN program_bantuan c USING (id_program) 
                                                 WHERE a.is_delete=1 
                                                 AND c.id_program = $id_prog2");
                           $jml_tot2 =count($result_tol); ?>
                        <td class="text-center"><b><?=$jml_tot2 ?></b></td>
                        <?php endforeach; ?>
                        <?php 
                          $result_tol2 = query("SELECT a.*,b.*,c.* FROM pmks a 
                                                 INNER JOIN kecamatan b USING (id_kec)
                                                 INNER JOIN program_bantuan c USING (id_program) 
                                                 WHERE a.is_delete=1 ");
                           $jml_tot3 =count($result_tol2); ?>
                        <td class="text-center"><b><?=$jml_tot3 ?></b></td>
                    </tr>
                    <?php endif ?>

                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <ul class="pagination float-right">
                    <?php if ($pageAktif > 1) : ?>
                      <li class="page-item"><a class="page-link" href="?page=<?=$pageAktif-1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i=1; $i <= $jml_Halaman; $i++) : ?>
                      <?php if ($i == $pageAktif) : ?>
                        <li class="page-item active"><a class="page-link" href="?page=<?=$i; ?>"><?=$i; ?></a></li>
                        <?php else : ?>
                          <li class="page-item"><a class="page-link" href="?page=<?=$i; ?>"><?=$i; ?></a></li>
                        <?php endif; ?>
                      <?php endfor; ?>
                      <?php if ($pageAktif < $jml_Halaman) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?=$pageAktif+1; ?>">Next</a></li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
              </div>

            </div> 
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


<?php include('templetes/footer.php');?> 
