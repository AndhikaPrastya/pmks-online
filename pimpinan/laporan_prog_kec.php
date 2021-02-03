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

$id=$_GET['id'];

$jml_DataHalaman = 5;
$jml_responden = count(query("SELECT a.*, b.*,c.*,d.*,f.*,g.*,h.id_kec,
                               h.nm_kec AS nm_kec_kk,i.id_desa,i.nm_desa AS nm_desa_kk FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               INNER JOIN Kecamatan h ON d.id_kec = h.id_kec
                               INNER JOIN desa i ON d.id_desa = i.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_kec=$id ORDER BY nm_kec ASC, nm_desa ASC"));
$jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

$pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
$awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

$pmks=query("SELECT a.*, b.*,c.*,d.*,f.*,g.*,h.id_kec,h.nm_kec AS nm_kec_kk,i.id_desa,i.nm_desa AS nm_desa_kk FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               INNER JOIN Kecamatan h ON d.id_kec = h.id_kec
                               INNER JOIN desa i ON d.id_desa = i.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_kec=$id ORDER BY nm_kec ASC, nm_desa ASC LIMIT $awaldata, $jml_DataHalaman");

$pmksx=query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete FROM desa a 
              INNER JOIN kecamatan b USING (id_kec) WHERE a.is_delete=1 AND b.is_delete=1 AND a.id_kec=$id")[0];


?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data PMKS Kec.<?=$pmksx['nm_kec'] ?></h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"> <i class="fas fa-plus"></i>
                  Tambah User
                 </button>  -->
                </div>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kelurahan</th>
                      <th class="text-center">NIK</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Kategori PMKS</th>
                      <th class="text-center">Program Bantuan</th>
                      <th class="text-center">Hasil Survei</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; ?>
                  <?php foreach ($pmks as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><?=$row['nm_desa'];?></td>
                        <td class="text-left"><?=$row['nik_pmks'];?></td>
                        <td class="text-left"><?=$row['nm_pmks'];?></td>
                        <td class="text-left"><?=$row['nm_kat'];?></td>
                        <td class="text-left"><?=$row['nm_program'];?></td>
                        <td class="text-left"><?=$row['hsl_survei'];?></td>
                        <td class="text-center">
                         <a href="pmks_laporan.php?id=<?=$row['id_pmks'] ?>" class="btn btn-warning btn-sm">Detail</a>
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

            </div> 
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


<?php include('templetes/footer.php');?>
