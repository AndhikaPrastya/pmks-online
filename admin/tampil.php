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

  $page = "pmks";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $pmks=query("SELECT a.*, b.*,c.*,d.*,e.*,f.*,g.* FROM pmks a 
               INNER JOIN kk b USING (id_kk)
               INNER JOIN kecamatan c USING (id_kec)
               INNER JOIN desa d USING (id_desa)
               INNER JOIN kat_pmks e USING (id_kat_pmks)
               INNER JOIN program_bantuan f USING (id_program)
               INNER JOIN pegawai g ON a.creator = g.id_pegawai
               WHERE a.id_kk = 1 AND a.id_pmks=1 AND a.is_delete = 1 ");
  // var_dump($kriteria);die;

  if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di tambah');
       document.location.href='pmks.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='pmks.php';
       </script>
       ";
      }
}

  if(isset($_POST["hapus"])){
  // var_dump($_POST);die;
  if(hapusDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='pmks.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='pmks.php';
       </script>
       ";
      }
}

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='pmks.php';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='pmks.php';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">DATA PMKS</h1>

          <!-- isi content -->
          <div class="card shadow mb-2">
            <div class="card-header py-3">


              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" width="100%" cellspacing="0">
                    <thead >

                      <?php foreach ($pmks as $row):?>
                      <tr>
                        <th class="text-left">Nama Kepala Keluarga</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['nm_kpl'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">TTL Kepala Keluarga</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['tgl_lhr_kpl'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">NO NIK</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['nik_kpl'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">NO KK</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['no_kk'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Alamat</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['alamat'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Hubungan</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['hubungan'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Pendidikan</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['pendidikan_kpl'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Pekerjaan</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['pekerjaan_kpl'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Nama PMKS</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['nm_pmks'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Kategori PMKS</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['nm_kat'] ?></td>
                      </tr>
                      <tr>
                        <th class="text-left">Bantuan PMKS</th>
                          <td class="text-left">:</td>
                          <td class="text-left"><?=$row['nm_program'] ?></td>
                      </tr>
                    <?php endforeach; ?>

                    </thead>
                  </tbody>
                </table>
              </div>
            </div>

              
      
            </div> 
          </div> 
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->


      <?php include('templetes/footer.php');?>


