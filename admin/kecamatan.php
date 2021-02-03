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

  $page  = "wilayah";
  $page1 = "kecamatan";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $id_pegawai=$_SESSION['id_pegawai'];
  $pegawai=query("SELECT id_pegawai FROM pegawai WHERE id_pegawai='$id_pegawai'")[0];

  $jml_DataHalaman = 5;
  $jml_responden = count(query( "SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY id_kec"));
  $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

  $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
  $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

  $kec=query("SELECT * FROM kecamatan WHERE is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY id_kec LIMIT $awaldata, $jml_DataHalaman");
  // var_dump($kecamatan);die;

  if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataKecamatan($_POST)>0){
    echo"
       <script>
       alert('data berhasil di tambah');
       document.location.href='kecamatan.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='kecamatan.php';
       </script>
       ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataKecamatan($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='kecamatan.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='kecamatan.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataKecamatan($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='kecamatan.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='kecamatan.php';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Kecamatan</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                  Tambah Kecamatan
                </button>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Nama Kecamatan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; ?>
                  <?php foreach ($kec as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><?=$row['nm_kec'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_kec']; ?>">
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id_kec" value="<?=$row['id_kec'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nm_kec'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>
                          </form>

                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
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

              <!-- Modal Tambah Data -->
              <div class="modal fade" id="modalTambah" tabindex="-2" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header modal-bg" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Tambah Kecamatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label for="nm_kec" class="col-form-label">Nama Kecamatan:</label>
                              <input type="text" class="form-control mt-1" id="nm_kec" name="nm_kec"  required>
                            </div>

                            <input type="hidden" class="form-control mt-1" id="is_delete" name="is_delete" 
                            value="1">
                            <input type="hidden" class="form-control mt-1" id="row_edit" name="row_edit" 
                            value="0">
                            <input type="hidden" class="form-control mt-1" id="id_pegawai" name="id_pegawai" 
                            value="<?= $pegawai['id_pegawai'] ?>">
                            <input class="input100" type="hidden" name="time_input" id="time_input" 
                                                        value="<?=date("Y-m-d H:i:s"); ?>">

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" name="tambah" class="btn btn-primary">Insert</button>
                            </div>
                          </form>
                        </div>
                    </form>
                  </div>
                </div>
              </div>

               <!-- Modal Edit Data -->
              <?php foreach ($kec as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id_kec'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Edit Kecamatan</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>

                            <input type="hidden" name="id_kec" class="form-control" value="<?=$row['id_kec'] ?>">
                            <!-- Data lama -->
                            <input type="hidden" name="nm_kec2" class="form-control" value="<?=$row['nm_kec']?>">
                            <input type="hidden" name="is_delete2" class="form-control" value="0">
                            <input type="hidden" name="row_edit2" class="form-control" value="<?=$row['id_kec']?>">
                            <input type="hidden" name="id_pegawai2" class="form-control" value="<?=$row['creator']?>">
                            <input type="hidden" name="time_input2" class="form-control" value="<?=date("Y-m-d H:i:s"); ?>">
                            <!-- Data Baru -->
                            <input type="hidden" name="is_delete" class="form-control" value="1">
                            <input type="hidden" name="row_edit" class="form-control" value="<?=$row['row_edit']?>">
                            <input type="hidden" name="id_pegawai" class="form-control" value="<?=$row['creator']?>">
                            <input type="hidden" name="time_input" class="form-control" value="<?=$row['time_input']?>">

                           
                            <div class="form-group">
                              <label for="nm_kec2" class="col-form-label">Nama Kecamatan:</label>
                              <input type="text" class="form-control mt-1" id="nm_kec" name="nm_kec" value="<?=$row['nm_kec'] ?>" required>
                            </div>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


      <?php include('templetes/footer.php');?>


