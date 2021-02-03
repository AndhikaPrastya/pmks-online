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

  $page   = "pmks";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $id_pegawai=$_SESSION['id_pegawai'];
  $pegawai=query("SELECT id_pegawai FROM pegawai WHERE id_pegawai='$id_pegawai'")[0];

  $jml_DataHalaman = 5;
  $jml_responden = count(query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete,c.id_desa,c.nm_desa,c.is_delete FROM kk a 
               INNER JOIN kecamatan b USING (id_kec)
               INNER JOIN desa c USING (id_desa) 
               WHERE a.is_delete=1 AND b.is_delete=1 AND c.is_delete=1
               ORDER BY a.no_kk ASC"));

  $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

  $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
  $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

  $kk=query("SELECT a.*,b.id_kec,b.nm_kec,b.is_delete,c.id_desa,c.nm_desa,c.is_delete FROM kk a 
               INNER JOIN kecamatan b USING (id_kec)
               INNER JOIN desa c USING (id_desa) 
               WHERE a.is_delete=1 AND b.is_delete=1 AND c.is_delete=1 
               ORDER BY a.no_kk = 'Tidak Ada' ASC, a.no_kk ASC LIMIT $awaldata, $jml_DataHalaman");

  if(isset($_POST["tambah"])){
  // var_dump($_POST);die;
  if(tambahDataKk($_POST)>0){
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
  if(hapusDataKk($_POST)>0){
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
  if(editDataKk($_POST)>0){
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

 if(isset($_POST["tambah_pmks"])){
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
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data NO Kartu Keluarga</h1>

          <!-- isi content -->
              <div class="card shadow mb-2">
                <div class="card-header py-3">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                    Tambah No KK
                  </button>
                  <a class="btn btn-info " href="kk_detail.php?id=21" role="button">Tambah PMKS Tanpa Data KK </a>

                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kecamatan</th>
                      <th class="text-center">Kelurahan/Desa</th>
                      <th class="text-center">No KK</th>
                      <th class="text-center">Nama Kepala Keluarga</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                   <?php $i=$awaldata+1; ?>
                  <?php foreach ($kk as $row):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><?=$row['nm_kec'];?></td>
                        <td class="text-left"><?=$row['nm_desa'];?></td>
                        <td class="text-left"><a class="text-dark2" 
                                href="kk_detail.php?id=<?=$row['id_kk'] ?>">
                                <?=$row['no_kk']; ?></a></td>
                        <td class="text-left"><?=$row['nm_kpl'];?></td>
                        <td class="text-center">
                          <form method="POST">
                            <?php if ($row['nm_kec'] != 'Tidak Ada') : ?>
                              <button type="button" id="edit" name="edit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_kk']; ?>">
                              <i class="fas fa-edit"></i> Edit</button>
                            
                            <input type="hidden" name="id_kk" value="<?=$row['id_kk'];?>">
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row['nm_kpl'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>
                            <?php endif; ?>

                            <button type="button" id="pmks" name="pmks" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalPmks<?= $row['id_kk']; ?>">
                            <i class="fas fa-edit"></i> Tambah PMKS</button>
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
                        <h5 class="modal-title modal-text" id="modalTambahTitle">Tambah Data Kartu Keluarga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form>

                            <div class="form-group">
                              <label for="no_kk" class="col-form-label">No KK:</label>
                              <input type="text" class="form-control mt-1" id="no_kk" name="no_kk"  required>
                            </div>

                            <div class="form-group">
                              <label for="nik_kpl" class="col-form-label">NIK Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="nik_kpl" name="nik_kpl"  required>
                            </div>

                            <div class="form-group">
                              <label for="nm_kpl" class="col-form-label">Nama Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="nm_kpl" name="nm_kpl"  required>
                            </div>

                            <div class="form-group">
                              <label for="tgl_lhr_kpl" class="col-form-label">Tanggal Lahir Kepala Keluarga:</label>
                              <input type="date" class="form-control mt-1" id="tgl_lhr_kpl" name="tgl_lhr_kpl"  required>
                            </div>

                            <div class="form-group">
                              <label for="wilayah">Kecamatan - Kelurahan/Desa:</label>
                              <select class="form-control" id="wilayah" name="wilayah">
                                <?php 
                                $kec = query("SELECT a.*,b.* FROM kecamatan a INNER JOIN desa b USING (id_kec)
                                              WHERE a.is_delete=1 AND b.is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY a.nm_kec ASC");
                                foreach ($kec as $key) :?>
                                  <option value="<?=$key['id_kec'].'|'.$key['id_desa']?>"><?=$key['nm_kec'].' - '.$key['nm_desa'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="alamat_kpl">Alamat Lengkap:</label>
                              <textarea class="form-control" id="alamat_kpl" name="alamat_kpl" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                              <label for="pekerjaan_kpl" class="col-form-label">Pekerjaan Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="pekerjaan_kpl" name="pekerjaan_kpl"  required>
                            </div>

                            <div class="form-group">
                              <label for="pendidikan_kpl">Pendidikan Kepala Keluarga</label>
                              <select class="form-control" id="pendidikan_kpl" name="pendidikan_kpl">
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="S1">S1</option>
                              </select>
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
              <?php foreach ($kk as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$row['id_kk'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalEditDataTitle">Edit Data Kartu Keluarga</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>

                            <input type="hidden" name="id_kk" class="form-control" value="<?=$row['id_kk'] ?>">
                            <!-- Data lama -->
                            <input type="hidden" name="no_kk2" class="form-control" value="<?=$row['no_kk']?>">
                            <input type="hidden" name="nik_kpl2" class="form-control" value="<?=$row['nik_kpl']?>">
                            <input type="hidden" name="nm_kpl2" class="form-control" value="<?=$row['nm_kpl']?>">
                            <input type="hidden" name="tgl_lhr_kpl2" class="form-control" value="<?=$row['tgl_lhr_kpl']?>">
                            <input type="hidden" name="id_kec2" class="form-control" value="<?=$row['id_kec']?>">
                            <input type="hidden" name="id_desa2" class="form-control" value="<?=$row['id_desa']?>">
                            <input type="hidden" name="alamat_kpl2" class="form-control" value="<?=$row['alamat_kpl']?>">
                            <input type="hidden" name="pekerjaan_kpl2" class="form-control" value="<?=$row['pekerjaan_kpl']?>">
                            <input type="hidden" name="pendidikan_kpl2" class="form-control" value="<?=$row['pendidikan_kpl']?>">
                            <input type="hidden" name="is_delete2" class="form-control" value="0">
                            <input type="hidden" name="row_edit2" class="form-control" value="<?=$row['id_kk']?>">
                            <input type="hidden" name="id_pegawai2" class="form-control" value="<?=$row['creator']?>">
                            <input type="hidden" name="time_input2" class="form-control" value="<?=date("Y-m-d H:i:s") ?>">
                            <!-- Data Baru -->
                            <input type="hidden" name="is_delete" class="form-control" value="1">
                            <input type="hidden" name="row_edit" class="form-control" value="<?=$row['row_edit']?>">
                            <input type="hidden" name="id_pegawai" class="form-control" value="<?= $pegawai['id_pegawai'] ?>">
                            <input type="hidden" name="time_input" class="form-control" value="<?=$row['time_input']?>">

                           
                           <div class="form-group">
                              <label for="no_kk" class="col-form-label">No KK:</label>
                              <input type="text" class="form-control mt-1" id="no_kk" name="no_kk" value="<?=$row['no_kk']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="nik_kpl" class="col-form-label">NIK Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="nik_kpl" name="nik_kpl" value="<?=$row['nik_kpl']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="nm_kpl" class="col-form-label">Nama Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="nm_kpl" name="nm_kpl" value="<?=$row['nm_kpl']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="tgl_lhr_kpl" class="col-form-label">Tanggal Lahir Kepala Keluarga:</label>
                              <input type="date" class="form-control mt-1" id="tgl_lhr_kpl" name="tgl_lhr_kpl" value="<?=$row['tgl_lhr_kpl']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="wilayah">Kecamatan - Kelurahan/Desa:</label>
                              <select class="form-control" id="wilayah" name="wilayah">
                                <?php 
                                $kec = query("SELECT a.*,b.* FROM kecamatan a INNER JOIN desa b USING (id_kec)
                                              WHERE a.is_delete=1 AND b.is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY a.nm_kec ASC");
                                foreach ($kec as $key) :?>
                                  <option value="<?=$key['id_kec'].'|'.$key['id_desa']?>"
                                           <?php  
                                              $kect=$row['nm_kec'];
                                              $des =$row['nm_desa'];
                                              $wil =$kect." - ".$des;
                                              if ($wil==$key['nm_kec'].' - '.$key['nm_desa']) {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                           ><?=$key['nm_kec'].' - '.$key['nm_desa'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="alamat_kpl">Alamat Lengkap:</label>
                              <textarea class="form-control" id="alamat_kpl" name="alamat_kpl" rows="3" ><?=$row['alamat_kpl']?></textarea>
                            </div>

                            <div class="form-group">
                              <label for="pekerjaan_kpl" class="col-form-label">Pekerjaan Kepala Keluarga:</label>
                              <input type="text" class="form-control mt-1" id="pekerjaan_kpl" name="pekerjaan_kpl" 
                                     value="<?=$row['pekerjaan_kpl']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="pendidikan_kpl">Pendidikan Kepala Keluarga</label>
                              <select class="form-control" id="pendidikan_kpl" name="pendidikan_kpl">
                                <option value="Tidak Sekolah" 
                                              <?php  if ($row['pendidikan_kpl']=='Tidak Sekolah') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >Tidak Sekolah</option>
                                <option value="SD" 
                                              <?php  if ($row['pendidikan_kpl']=='SD') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SD</option>
                                <option value="SMP"
                                              <?php  if ($row['pendidikan_kpl']=='SMP') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SMP</option>
                                <option value="SMA/SMK"
                                              <?php  if ($row['pendidikan_kpl']=='SMA/SMK') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SMA/SMK</option>
                                <option value="S1"
                                              <?php  if ($row['pendidikan_kpl']=='S1') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >S1</option>
                              </select>
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

              <!-- Modal Tambah PMKS-->
              <?php foreach ($kk as $row)  : ?>
              <div class="modal fade" id="modalPmks<?=$row['id_kk'] ?>" tabindex="-2" role="dialog" aria-labelledby="modalPmksDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalPmksDataTitle">Tambah Data PMKS</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>

                            <div class="form-group">
                              <label for="nik_pmks" class="col-form-label">NIK PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nik_pmks" name="nik_pmks" value="Tidak Ada" required>
                            </div>

                            <div class="form-group">
                              <label for="nm_pmks" class="col-form-label">Nama PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nm_pmks" name="nm_pmks" required>
                            </div>

                            <div class="form-group">
                              <label for="tgl_lhr_pmks" class="col-form-label">Tanggal Lahir PMKS:</label>
                              <input type="date" class="form-control mt-1" id="tgl_lhr_pmks" name="tgl_lhr_pmks" required>
                            </div> 

                            <?php if ($row['no_kk'] != 'Tidak Ada') : ?>

                              <div class="form-group">
                                <label for="wilayah" class="col-form-label">Kecamatan - Kelurahan/Desa:</label>
                                <input type="hidden" id="wilayah" name="wilayah" value="<?=$row['id_kec'].' | '.$row['id_desa'];?>">
                                <input type="text" class="form-control mt-1" value="<?=$row['nm_kec'].' - '.$row['nm_desa'];?>" readonly>
                              </div> 

                            <?php else : ?>
                              
                            <div class="form-group">
                              <label for="wilayah">Kecamatan - Kelurahan/Desa:</label>
                              <select class="form-control" id="wilayah" name="wilayah">
                                <?php 
                                $kec = query("SELECT a.*,b.* FROM kecamatan a INNER JOIN desa b USING (id_kec)
                                              WHERE a.is_delete=1 AND b.is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY a.nm_kec ASC");
                                foreach ($kec as $key) :?>
                                  <option value="<?=$key['id_kec'].'|'.$key['id_desa']?>"><?=$key['nm_kec'].' - '.$key['nm_desa'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                          <?php endif; ?>

                           <?php if ($row['no_kk'] != 'Tidak Ada') : ?>

                            <div class="form-group">
                              <label for="hubungan">Hubungan Kepala Keluarga Dengan PMKS:</label>
                              <select class="form-control" id="hubungan" name="hubungan">
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="Lainnya">Lainnya</option>
                              </select>
                            </div>

                            <?php else : ?>

                             <div class="form-group">
                              <label for="hubungan" class="col-form-label">Hubungan Kepala Keluarga Dengan PMKS:</label>
                              <input type="text" class="form-control mt-1" id="hubungan" name="hubungan" value="Tidak Ada" readonly>
                             </div> 

                            <?php endif; ?>

                             <div class="form-group">
                              <label for="jns_klm_pmks">Jenis Kelamin PMKS:</label>
                              <select class="form-control" id="jns_klm_pmks" name="jns_klm_pmks">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="nm_ibu_pmks" class="col-form-label">Nama Ibu PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nm_ibu_pmks" name="nm_ibu_pmks" required>
                            </div>

                            <div class="form-group">
                              <label for="pendidikan_pmks">Pendidikan PMKS</label>
                              <select class="form-control" id="pendidikan_pmks" name="pendidikan_pmks">
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="S1">S1</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="id_kat_pmks">Kategori PMKS:</label>
                              <select class="form-control" id="id_kat_pmks" name="id_kat_pmks">
                                <?php 
                                $kat = query("SELECT * FROM kat_pmks WHERE is_delete=1 ORDER BY nm_kat ASC");
                                foreach ($kat as $key) :?>
                                  <option value="<?=$key['id_kat_pmks'];?>"><?=$key['nm_kat'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                             <div class="form-group">
                              <label for="id_program">Program Bantuan PMKS:</label>
                              <select class="form-control" id="id_program" name="id_program">
                                <?php 
                                $kat = query("SELECT * FROM program_bantuan WHERE is_delete=1 ORDER BY nm_program ASC");
                                foreach ($kat as $key) :?>
                                  <option value="<?=$key['id_program'];?>"><?=$key['nm_program'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <input type="hidden" name="id_kk" class="form-control" value="<?=$row['id_kk']?>">
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
                           <button type="submit" name="tambah_pmks" class="btn btn-primary">Insert</button>
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


