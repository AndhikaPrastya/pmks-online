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

  $laporan=query("SELECT * FROM laporan ORDER BY id_laporan ASC");


  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataLaporan($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='laporan.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='laporan.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataLaporan($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='laporan.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='laporan.php';
       </script>
       ";
      }
}


?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Laporan</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="table-dark">
                   <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Nama Laporan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=1;?>
                  <?php foreach ($laporan as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['nama_laporan'];?></td>

                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_laporan']; ?>"> 
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id_laporan" value="<?=$row['id_laporan'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nama_laporan'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>

                            <a href="rangking.php?id_laporan=<?=$row['id_laporan'] ?>" class="btn btn-info btn-sm" ><i class="fas fa-chart-bar"></i> Rangking</a>
                            </form>     
                       </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
              </div>

           

            <!-- Modal Edit Data -->
              <?php foreach ($laporan as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id_laporan'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit laporan</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <input type="hidden" name="id_laporan" class="form-control" value="<?=$row['id_laporan'] ?>">

                            <div class="form-group">
                              <label for="nama_laporan" class="col-form-label">Nama laporan :</label>
                              <input type="text" class="form-control mt-1" name="nama_laporan" value="<?=$row['nama_laporan'] ?>" required>
                            </div>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" name="edit" class="btn btn-primary">Update</button>
                         </div>
                       </form>
                     </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>

            </div>    
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


<?php include('templetes/footer.php');?>
