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

  $page = "user";
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $user=query("SELECT * FROM user ORDER BY id");


  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataUser($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='user.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='user.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataRole($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='user.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='user.php';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">User</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i>
                  Tambah User
                 </button>  -->
                </div>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Username</th>
                      <th class="text-center">Role</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=1;?>
                  <?php foreach ($user as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-center"><?=$row['nama'];?></td>
                        <td class="text-center"><?=$row['username'];?></td>
                        <td class="text-center"><?=$row['role'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id']; ?>">
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['username'] ?>?');">
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


               <!-- Modal Edit Data -->
              <?php foreach ($user as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Role User</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>
                          <input type="hidden" name="id" class="form-control" value="<?=$row['id'] ?>">
                          <div class="form-group"> 
                            <label>Nama User : <b><?=$row['nama'] ?></b> </label>
                          
                          <div class="form-group">
                            <label for="role">Role User :</label>
                                <select name="role" class="form-control">
                                    <option value="Admin" <?php if($row['role'] == "Admin") {echo "selected";} ?> >Admin</option>
                                    <option value="User" <?php if($row['role'] == "User") {echo "selected";} ?> >User</option>
                                </select>
                          </div>
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
