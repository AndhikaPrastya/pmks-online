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

  $page = "index";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $id = $_SESSION["id_pegawai"];
  $user = query("SELECT * FROM pegawai WHERE is_delete=1 AND id_pegawai = $id")[0];

  if(isset($_POST["ubahpass"])) {
            // var_dump($_POST);die;
            if(ubahpass($_POST) > 0){
              echo "
              <script>
              alert('Data Berhasil Diubah dan Silahkan Login Kembali');
              document.location.href = 'reset.php';
              </script>
              ";
            } else {
              echo "
              <script>
              alert('Data Gagal Diubah!');
              document.location.href = 'profil.php';
              </script>
              ";
            }
  }

  if(isset($_POST["editPegawai"])) {
            // var_dump($_POST);die;
            if(editDataPegawai($_POST) > 0){
              echo "
              <script>
              alert('Data Berhasil Diubah!');
              document.location.href = 'profil.php';
              </script>
              ";
            } else {
              echo "
              <script>
              alert('Data Gagal Diubah!');
              document.location.href = 'profil.php';
              </script>
              ";
            }
  }
       

?>

        <!-- Begin Page Content -->
        <div class="container-fluid ">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Profil Pengguna</h1>

          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title"><?=$user['nm_pegawai'] ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?=$user['nip'] ?></h6>
              <table>
                <tr>
                  <td>No HP</td>
                  <td>:</td>
                  <td><?=$user['no_telepon'] ?></td>
                </tr>
                <tr>
                  <td>alamat</td>
                  <td>:</td>
                  <td><?=$user['alamat'] ?></td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td>:</td>
                  <td><?=$user['username'] ?></td>
                </tr>
                <tr>
                  <td>Hak Akses</td>
                  <td>:</td>
                  <td><?=$user['role'] ?></td>
                </tr>
              </table>
              <button type="button" id="editProfil" name="editProfil" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEditProfil">Edit Profile</button>
              <button type="button" id="editPass" name="editPass" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditPass">Ganti Password</button>
            </div>
          </div>
         
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

<?php include('templetes/footer.php');?>



      <div class="modal fade" id="modalEditPass" tabindex="-2" role="dialog" aria-labelledby="modalEditPassTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                  <div class="modal-header modal-bg  text-white bg-success" back>
                        <h5 class="modal-title modal-text text-white" id="modalEditPassTitle">Ganti Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form >
                         <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?=$_SESSION['id_pegawai']?>">
                         <div class="form-group">
                           <label for="password1" class="col-form-label text-dark"> Password Baru : </label>
                           <input type="password" class="form-control mt-1" id="password1" name="password1"  required>
                         </div>
                         <div class="form-group">
                           <label for="password2" class="col-form-label text-dark"> Konfirmasi Password Baru : </label>
                           <input type="password" class="form-control mt-1" id="password2" name="password2"  required>
                         </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="ubahpass" class="btn btn-primary">Ubah Password</button>
                      </div>
                        </form>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


            <div class="modal fade" id="modalEditProfil" tabindex="-2" role="dialog" aria-labelledby="modalEditProfilTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                  <div class="modal-header modal-bg  text-white bg-primary" back>
                        <h5 class="modal-title modal-text text-white" id="modalEditProfilTitle">Edit Profil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form >
                            <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?=$_SESSION['id_pegawai']?>">
                            <!-- Data lama -->
                            <input type="hidden" name="nm_pegawai2" class="form-control" value="<?=$user['nm_pegawai']?>">
                            <input type="hidden" name="nip2" class="form-control" value="<?=$user['nip']?>">
                            <input type="hidden" name="no_telepon2" class="form-control" value="<?=$user['no_telepon']?>">
                            <input type="hidden" name="alamat2" class="form-control" value="<?=$user['alamat']?>">
                            <input type="hidden" name="username2" class="form-control" value="<?=$user['username']?>">
                            <input type="hidden" name="password2" class="form-control" value="<?=$user['password']?>">
                            <input type="hidden" name="role2" class="form-control" value="<?=$user['role']?>">
                            <input type="hidden" name="is_delete2" class="form-control" value="0">
                            <input type="hidden" name="row_edit2" class="form-control" value="<?=$user['id_pegawai']?>">
                            <input type="hidden" name="time_input2" class="form-control" value="<?=date("Y-m-d H:i:s"); ?>">

                         <div class="form-group">
                           <label for="nm_pegawai" class="col-form-label text-dark"> Nama Pegawai : </label>
                           <input type="text" class="form-control mt-1" id="nm_pegawai" name="nm_pegawai" value="<?=$user['nm_pegawai'] ?>"  required>

                           <label for="nip" class="col-form-label text-dark"> NIP : </label>
                           <input type="text" class="form-control mt-1" id="nip" name="nip" value="<?=$user['nip'] ?>"  required>

                           <label for="no_telepon" class="col-form-label text-dark"> No Telephone : </label>
                           <input type="text" class="form-control mt-1" id="no_telepon" name="no_telepon" value="<?=$user['no_telepon'] ?>"  required>

                           <label for="alamat" class="col-form-label text-dark"> Alamat : </label>
                           <input type="text" class="form-control mt-1" id="alamat" name="alamat" value="<?=$user['alamat'] ?>"  required>

                           <label for="username" class="col-form-label text-dark"> Username : </label>
                           <input type="text" class="form-control mt-1" id="username" name="username" value="<?=$user['username'] ?>"  required>

                           <label for="role" class="col-form-label text-dark"> Hak Akses : </label>
                           <input type="text" class="form-control mt-1" id="role" name="role" value="<?=$user['role'] ?>" readonly>
                         </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="editPegawai" class="btn btn-primary">Ubah Profil</button>
                      </div>
                        </form>
                      </div>
                    </form>
                  </div>
                </div>
              </div>