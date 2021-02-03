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

  $page = "alternatif";
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";
  require_once "../config.php";

  $alternatif=query("SELECT * FROM alternatif ORDER BY id ASC");
  $kriteriaxx = query("SELECT * FROM kriteria ORDER BY id");
  $jml_kriteria = count($kriteriaxx);

  if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataAlternatif($_POST)>0){
    echo"
       <script>
       alert('data berhasil ditambah');
       document.location.href='alternatif.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='alternatif.php';
       </script>
       ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataAlternatif($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='alternatif.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='alternatif.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataAlternatif($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='alternatif.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='alternatif.php';
       </script>
       ";
      }
}

 if(isset($_POST["nilai"])){
  // var_dump($_POST);die;
  $krt=query("SELECT * FROM kriteria ORDER BY id");
    foreach ($krt as $key) {
        $id=$_POST['alt'];
        $nm=$key['id'];
        $idkrt='krt'.$nm;
        $krt=$_POST[$idkrt];
        $nil='nilai'.$nm;
        $nnil=$_POST[$nil];
        // echo "id alternatif ".$id."<br>"."id kriteria= ".$krt."<br>"." nilai= ".$nnil."<br>";die;
        $query="UPDATE nilai_alternatif SET nilai=$nnil
                where id_alternatif=$id and id_kriteria=$krt";
        mysqli_query($koneksi,$query);
        echo"
       <script>
       alert('Penilaian berhasil ditambahkan');
       document.location.href='alternatif.php';
       </script>
       ";
    }
}

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Alternatif</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Alternatif </button>
                  <a class="btn btn-success float-right" href="hasil.php" role="button">Next</a>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center table-white align-middle" colspan="3">ALTERNATIF</th>
                      <th class="text-center" colspan="<?php echo $jml_kriteria; ?>">KRITERIA</th>
                      <th class="text-center table-white align-middle" rowspan="2">Aksi</th>
                    </tr>

                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Nama</th>
                      <?php foreach ($kriteriaxx as $keyx) : ?>
                        <th class="text-center"><?=$keyx['kode_kriteria']; ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>

                  <?php $i=1;?>
                  <?php foreach ($alternatif as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['kode_alternatif'];?></td>
                        <td class="text-center"><?=$row['nama_alternatif'];?></td>


                        <?php
                            $id=$row['id'];
                            $penilaian = query(" SELECT * FROM nilai_alternatif WHERE id_alternatif=$id"); 
                            foreach ($penilaian as $row2) : ?>

                        <td class="text-center"><?=$row2['nilai']; ?></td>

                              <?php 
                                  $hasil[][]=$row2['nilai'];
                                  endforeach; 
                              ?>
                        






                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>"> 
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nama_alternatif'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>

                            <button type="button" id="nilai" name="nilai" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalNilai<?= $row['id']; ?>"> 
                             <i class="far fa-calendar-check"></i> Nilai</button>
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
                <div class="modal-dialog modal-dialog-centered role="document">
                  <div class="modal-content ">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header modal-bg" back>
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Form Alternatif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>
                            <input type="hidden" class="form-control mt-1" id="id" name="id"  required>
                            <div class="form-group">
                              <label for="kode_alternatif" class="col-form-label">Kode Alternatif :</label>
                              <input type="text" class="form-control mt-1" id="kode_alternatif" name="kode_alternatif"  required>
                            </div>

                            <div class="form-group">
                              <label for="nama_alternatif" class="col-form-label">Nama Alternatif :</label>
                              <input type="text" class="form-control mt-1" id="nama_alternatif" name="nama_alternatif"  required>
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
              <?php foreach ($alternatif as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Alternatif</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                            <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">

                            <div class="form-group">
                              <label for="kode_alternatif" class="col-form-label">Kode Alternatif :</label>
                              <input type="text" class="form-control mt-1" name="kode_alternatif" value="<?=$row['kode_alternatif'] ?>" required>
                            </div>

                            <div class="form-group">
                              <label for="nama_alternatif" class="col-form-label">Nama Alternatif :</label>
                              <input type="text" class="form-control mt-1" name="nama_alternatif" value="<?=$row['nama_alternatif'] ?>" required>
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

               <!-- Modal Edit Data -->
              <?php foreach ($alternatif as $row)  : ?>
              <div class="modal fade" id="modalNilai<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalNilaiDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalNilaiDataTitle">Form Penilaian <b> <?=$row['nama_alternatif'] ?></b></h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>

                         <?php  $kriteria=query("SELECT * FROM kriteria ORDER BY id"); 
                         foreach ($kriteria as $row1):?>

                            <div class="form-group row">
                              <label for="inputPassword" class="col-sm-4 col-form-label"><?=$row1['nama'] ?></label>
                              <div class="col-sm-8">
                                <input type="hidden" name="alt" value="<?=$row['id'] ?>">
                                <input type="hidden" name="krt<?=$row1['id']?>" value="<?=$row1['id']?>">
                                <input type="number" class="form-control" name="nilai<?=$row1['id']?>" id="nilai<?=$row1['id']?>" min="0" max="10" value="1" required>
                              </div>
                            </div>

                        <?php endforeach; ?>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" name="nilai" class="btn btn-primary">Nilai</button>
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
