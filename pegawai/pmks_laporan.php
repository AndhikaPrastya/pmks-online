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
$page1 = "all";
date_default_timezone_set('Asia/Jakarta');
include('templetes/sidebar.php');
include('templetes/topbar.php');
require_once "../functions.php";

$id = $_GET['id'];

$pmksx = query("SELECT * FROM pmks WHERE id_pmks='$id'")[0];
$pmks = query("SELECT a.*, b.*,c.*,d.*,f.*,g.*,h.id_kec,h.nm_kec AS nm_kec_kk,i.id_desa,i.nm_desa AS nm_desa_kk FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               INNER JOIN Kecamatan h ON d.id_kec = h.id_kec
                               INNER JOIN desa i ON d.id_desa = i.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_pmks = $id ");

$pmksy = query("SELECT a.*, b.*,c.*,d.*,f.*,g.* FROM pmks a 
                               INNER JOIN kat_pmks b USING (id_kat_pmks)
                               INNER JOIN program_bantuan c USING (id_program)
                               INNER JOIN kk d USING (id_kk)
                               INNER JOIN Kecamatan f ON a.id_kec = f.id_kec
                               INNER JOIN desa g ON a.id_desa = g.id_desa
                               WHERE a.is_delete = 1 AND d.is_delete = 1 AND a.id_pmks = $id ")[0];

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-judul">Data Kartu Keluarga - NO KK : <?= $pmksy['no_kk'] ?></h1>
  <!-- isi content -->
  <div class="card shadow mb-2">
    <div class="card-header py-3">
      <a href="../cetak_pmks.php?id=<?=$id ?>" target="_blank" class="btn btn-info"> Cetak</a>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <tbody>
              <?php foreach ($pmks as $row) : ?>
                <tr>
                  <th colspan="3" scope="row" class="text-center">
                    <font size="4">IDENTITAS KEPALA KELUARGA</font>
                  </th>
                </tr>
                <tr>
                  <th scope="row">Nama Kepala Keluarga</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_kpl'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Tanggal Lahir</th>
                  <td>:</td>
                  <td class="text-left"><?= date('d-M-Y', strtotime($row['tgl_lhr_kpl'])) ?></td>
                </tr>
                <tr>
                  <th scope="row">No NIK</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nik_kpl'] ?></td>
                </tr>
                <tr>
                  <th scope="row">No KK</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['no_kk'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Kecamatan</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_kec_kk'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Kelurahan/Desa</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_desa_kk'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Alamat</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['alamat_kpl'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Pendidikan</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['pendidikan_kpl'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Pekerjaan</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['pekerjaan_kpl'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Hubungan dengan PMKS</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['hubungan'] ?></td>
                </tr>
                <tr>
                  <th colspan="3" scope="row" class="text-center">
                    <font size="4">IDENTITAS PENYANDANG KESEJAHTERAAN SOSIAL</font>
                  </th>
                </tr>
                <tr>
                  <th scope="row">Nama</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_pmks'] ?></td>
                </tr>
                <tr>
                  <th scope="row">NIK</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nik_pmks'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Nama Ibu Kandung</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_ibu_pmks'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Tanggal Lahir</th>
                  <td>:</td>
                  <td class="text-left"><?= date('d-M-Y', strtotime($row['tgl_lhr_pmks'])) ?></td>
                </tr>
                <tr>
                  <th scope="row">Kecamatan</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_kec'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Kelurahan/Desa</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_desa'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Jenis Kelamin</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['jns_klm_pmks'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Pendidikan</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['pendidikan_pmks'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Kategori PMKS</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_kat'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Program Bantuan Yang Diterima</th>
                  <td>:</td>
                  <td class="text-left"><?= $row['nm_program'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Hasil Survei</th>
                  <td>:</td>
                  <td class="text-left"><b><?= $row['hsl_survei'] ?></b></td>
                </tr>
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
<br>

<?php include('templetes/footer.php'); ?>