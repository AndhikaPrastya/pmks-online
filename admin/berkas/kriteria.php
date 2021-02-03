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

  $page = "kriteria";
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $kriteria=query("SELECT * FROM kriteria ORDER BY id");
  // var_dump($kriteria);die;

  if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataKriteria($_POST)>0){
    echo"
       <script>
       alert('data berhasil di tambah');
       document.location.href='kriteria.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='kriteria.php';
       </script>
       ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataKriteria($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='kriteria.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='kriteria.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataKriteria($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='kriteria.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='kriteria.php';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Kriteria</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                  Tambah Kriteria
                </button>

                <a class="btn btn-success float-right" href="bobot_kriteria.php" role="button">Hitung Bobot Prioritas</a>
                </div>


                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Nama Kriteria</th>
                      <th class="text-center">Type</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=1;?>
                  <?php foreach ($kriteria as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['kode_kriteria'];?></td>
                        <td class="text-center"><?=$row['nama'];?></td>
                        <td class="text-center"><?=$row['type'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>">
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['kode_kriteria'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>
                          </form>

                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
              </div>

              <!-- Modal Tambah Data -->
              <div class="modal fade" id="modalTambah" tabindex="-2" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header modal-bg" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Form Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label for="kode_kriteria" class="col-form-label">Kode Kriteria:</label>
                              <input type="text" class="form-control mt-1" id="kode_kriteria" name="kode_kriteria"  required>
                            </div>

                            <div class="form-group">
                              <label for="nama" class="col-form-label">Nama Kriteria:</label>
                              <input type="text" class="form-control mt-1" id="nama" name="nama"  required>
                            </div>

                            <div class="form-group">
                              <label for="type" class="col-form-label">Tipe Kriteria:</label>
                              <select class="custom-select" id="type" name="type">
                                <option value="Benefit">Benefit</option>
                                <option value="Cost">Cost</option>
                              </select>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="tambah" class="btn btn-primary">Insert</button>
                            </div>
                          </form>
                        </div>
                    </form>
                  </div>
                </div>
              </div>

               <!-- Modal Edit Data -->
              <?php foreach ($kriteria as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Kriteria</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                          <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">

                          <div class="form-group"> 
                            <label>Kode Kriteria : </label>
                             <input type="text" name="kode_kriteria" class="form-control" value="<?=$row['kode_kriteria'] ?>" required>
                          </div>

                          <div class="form-group"> 
                            <label>Nama Kriteria : </label>
                            <input type="text" name="nama" class="form-control" value="<?=$row['nama'] ?>" required>
                          </div>

                          <div class="form-group">
                            <label for="type" class="col-form-label">Tipe Kriteria:</label>
                            <select class="custom-select" id="type" name="type">
                              <option value="Benefit">Benefit</option>
                              <option value="Cost">Cost</option>
                            </select>
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


