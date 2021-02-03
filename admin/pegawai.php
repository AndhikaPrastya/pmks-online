<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("location:../index.php");
  exit;
}
if (isset($_SESSION["pimpinan"])) {
  header("location:admin/index.php");
  exit;
}
if (isset($_SESSION["pegawai"])) {
  header("location:admin/index.php");
  exit;
}

$page = "pegawai";
date_default_timezone_set('Asia/Jakarta');
include('templetes/sidebar.php');
include('templetes/topbar.php');
require_once "../functions.php";

$jml_DataHalaman = 5;
$jml_responden = count(query("SELECT * FROM pegawai WHERE is_delete=1 ORDER BY id_pegawai"));
$jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

$pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
$awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

$pegawai = query("SELECT * FROM pegawai WHERE is_delete=1 ORDER BY id_pegawai");


if (isset($_POST["hapus"])) {
  // var_dump($_POST);die;
  if (hapusDataPegawai($_POST) > 0) {
    echo "
       <script>
       alert('data berhasil di hapus');
       document.location.href='pegawai.php';
       </script>
       ";
  } else {
    echo "
       <script>
       alert('data gagal di hapus');
       document.location.href='pegawai.php';
       </script>
       ";
  }
}

if (isset($_POST["edit"])) {
  // var_dump($_POST);die;
  if (editDataRole($_POST) > 0) {
    echo "
       <script>
       alert('data berhasil di ubah');
       document.location.href='pegawai.php';
       </script>
       ";
  } else {
    echo "
       <script>
       alert('data gagal di ubah');
       document.location.href='pegawai.php';
       </script>
       ";
  }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-judul">Pengguna</h1>

  <!-- isi content -->
  <div class="card shadow mb-2">

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead class="table-dark">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">NIP</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Role</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <?php $i=$awaldata+1; ?>
          <?php foreach ($pegawai as $row) : ?>

            <tbody>
              <tr>
                <td class="text-center"><?= $i; ?></td>
                <td class="text-center"><?= $row['nip']; ?></td>
                <td class="text-center"><?= $row['nm_pegawai']; ?></td>
                <td class="text-center"><?= $row['role']; ?></td>
                <td class="text-center">
                  <form method="POST">
                    <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_pegawai']; ?>">
                      <i class="fas fa-edit"></i> Edit</button>

                    <input type="hidden" name="id_pegawai" value="<?= $row['id_pegawai']; ?>">
                    <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?= $row['nm_pegawai'] ?>?');">
                      <i class="fas fa-trash-alt"></i> Delete</button>
                  </form>

                </td>
              </tr>
              <?php $i++; ?>
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

    <!-- Modal Edit Data -->
    <?php foreach ($pegawai as $row) : ?>
      <div class="modal fade" id="modalEdit<?= $row['id_pegawai'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
              <div class="modal-header modal-bg" back>
                <h5 class="modal-title modal-text" id="modalEditDataTitle">Form Edit Role Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <input type="hidden" name="id_pegawai" class="form-control" value="<?= $row['id_pegawai'] ?>">
                  <div class="form-group">
                    <label>Nama Pegawai : <b><?= $row['nm_pegawai'] ?></b> </label>

                    <div class="form-group">
                      <label for="role">Role Pengguna :</label>
                      <select name="role" class="form-control text-black">
                        <option value="Admin" <?php if ($row['role'] == "Admin") {
                                                echo "selected";
                                              } ?>>Admin</option>
                        <option value="Pimpinan" <?php if ($row['role'] == "Pimpinan") {
                                                    echo "selected";
                                                  } ?>>Pimpinan</option>
                        <option value="Pegawai" <?php if ($row['role'] == "Pegawai") {
                                                  echo "selected";
                                                } ?>>Pegawai</option>
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


<?php include('templetes/footer.php'); ?>