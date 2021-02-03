<?php 
session_start();
if (!isset($_SESSION["admin"])){
    header("location:../index.php");
    exit;
}
if (isset($_SESSION["pimpinan"])){
    header("location:admin/index.php");
    exit;
}
if (isset($_SESSION["pegawai"])){
    header("location:admin/index.php");
    exit;
}

  $page = "laporan";
  $page1 = "wil";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $jml_DataHalaman = 5;
  $jml_responden = count(query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete FROM desa a 
               INNER JOIN kecamatan b USING (id_kec) WHERE a.is_delete=1 AND b.is_delete=1 
               AND a.nm_desa!='Tidak Ada' AND b.nm_kec!='Tidak Ada'
               ORDER BY b.nm_kec ASC"));
  $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

  $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
  $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

  $desa=query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete FROM desa a 
               INNER JOIN kecamatan b USING (id_kec) WHERE a.is_delete=1 AND b.is_delete=1 
               AND a.nm_desa!='Tidak Ada' AND b.nm_kec!='Tidak Ada'
               ORDER BY b.nm_kec ASC LIMIT $awaldata, $jml_DataHalaman");

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data PMKS Wilayah</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <a href="../cetak_wil.php" target="_blank" class="btn btn-info"> Cetak</a>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kecamatan</th>
                      <th class="text-center">Kelurahan</th>
                      <th class="text-center">Jumlah PMKS</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; ?>
                  <?php foreach ($desa as $row):
                    $id_desa = $row['id_desa'];
                    $jml_pmks = count(query("SELECT a.*,d.is_delete FROM pmks a 
                     INNER JOIN kk d USING (id_kk)
                     WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_desa=$id_desa"));
                    ?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><?=$row['nm_kec'];?></td>
                        <td class="text-left"><?=$row['nm_desa'];?></td>
                        <td class="text-center"><?=$jml_pmks ?></td>
                        <td class="text-center">
                         <a href="laporan_wil_detail.php?id=<?=$id_desa ?>" class="btn btn-warning btn-sm">Detail</a>
                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>

                      <?php if ($pageAktif==$jml_Halaman): ?>
                      <tr>
                        <td colspan="3" class="text-center"><b>Jumlah</b></td>
                        <?php 
                          $result_tol2 = query("SELECT * FROM pmks
                                                WHERE is_delete=1 ");
                           $jml_tot2 =count($result_tol2); ?>
                        <td class="text-center"><b><?=$jml_tot2 ?></b></td>
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
 