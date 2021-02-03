<?php 
 session_start();
if (isset($_SESSION["user"])){
    header("location:../user/index.php");
    exit;
}
if (!isset($_SESSION["admin"])){
    header("location:../index.php");
    exit;
}

  $page = "laporan";
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";
  require_once "../config.php";

  $id_laporan=$_GET['id_laporan'];
  $laporan=query("SELECT * FROM laporan WHERE id_laporan='$id_laporan'")[0];

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Rangking</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <a class="btn btn-warning float-left" href="laporan.php" role="button">Kembali</a>
                  <a class="btn btn-primary float-right" href="../print.php?id_laporan=<?=$id_laporan?>" role="button">Print</a>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="table-dark">
                   <tr>
                      <th class="text-center">Rangking</th>
                      <th class="text-center">Nama Alternatif</th>
                      <th class="text-center">Kode Alternatif</th>
                      <th class="text-center">Nilai</th>
                    </tr>
                  </thead>

                  <?php $i=1;?>
                  <?php  $hasil=query("SELECT a.*, b.* FROM hasil a JOIN alternatif b ON a.id_alternatif=b.id WHERE id_laporan='$id_laporan'");?>
                  <?php foreach ($hasil as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['kode_alternatif'];?></td>
                        <td class="text-center"><?=$row['nama_alternatif'];?></td>
                        <td class="text-center"><?=$row['nilai'];?></td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
              </div>

            </div>    
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


<?php include('templetes/footer.php');?>
