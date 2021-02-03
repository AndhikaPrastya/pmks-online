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

  $page = "pmks";
  date_default_timezone_set('Asia/Jakarta');
  include('templetes/sidebar.php');
  include('templetes/topbar.php');
  require_once "../functions.php";

  $id_pegawai=$_SESSION['id_pegawai'];
  $pegawai=query("SELECT id_pegawai FROM pegawai WHERE id_pegawai='$id_pegawai'")[0];

  $id=$_GET['id'];
  $kk=query("SELECT * FROM kk where id_kk='$id'")[0];

  $kk2=query("SELECT a.*, b.*,c.* FROM kk a 
               INNER JOIN kecamatan b USING (id_kec)
               INNER JOIN desa c USING (id_desa)
               WHERE a.id_kk = $id AND a.is_delete = 1 ");
  // var_dump($kriteria);die;

  if(isset($_POST["edit"])){
  // var_dump($_POST);die;
  if(editDataKk($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='kk_detail.php?id=$id';
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
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }
}

  if(isset($_POST["edit_pmks"])){
  // var_dump($_POST);die;
  if(editDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di tambah');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di tambah');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }
}

  if(isset($_POST["hapus_pmks"])){
  // var_dump($_POST);die;
  if(hapusDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di hapus');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di hapus');
       document.location.href='kk_detail.php?id=$id';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data Kartu Keluarga - No KK : <?=$kk['no_kk'] ?></h1>

          <!-- isi content -->
          <div class="card shadow mb-2">
            <div class="card-header py-3">
              <?php if ($kk['no_kk']!="Tidak Ada") : ?>

                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit<?=$kk['id_kk']?>">
                  Edit Data KK
                </button> 
              <?php endif; ?>
              

              <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped">
                  <tbody>
                    <?php foreach ($kk2 as $row):?>
                    <tr>
                      <th scope="row">No KK</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['no_kk'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">No NIK</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nik_kpl'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Nama Kepala Keluarga</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_kpl'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">TTL Kepala Keluarga</th>
                      <td>:</td>
                      <td class="text-left"><?=date('d-M-Y', strtotime($row['tgl_lhr_kpl'])) ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Kecamatan</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_kec'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Kelurahan/Desa</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_desa'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Alamat</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['alamat_kpl'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Pendidikan</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['pendidikan_kpl'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Pekerjaan</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['pekerjaan_kpl'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div> 
      
            </div> 
          </div> 

          <?php 

          $jml_DataHalaman = 5;
          $jml_responden = count(query("SELECT a.*, b.*,c.*,d.*,e.*,f.id_kk,f.no_kk FROM pmks a 
                             INNER JOIN kecamatan b USING (id_kec)
                             INNER JOIN desa c USING (id_desa)
                             INNER JOIN kat_pmks d USING (id_kat_pmks)
                             INNER JOIN program_bantuan e USING (id_program)
                             INNER JOIN kk f USING (id_kk)
                             WHERE a.id_kk = $id AND a.is_delete = 1"));
          $jml_Halaman = ceil($jml_responden / $jml_DataHalaman);

          $pageAktif = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
          $awaldata = ( $jml_DataHalaman * $pageAktif ) - $jml_DataHalaman;

          $pmks=query("SELECT a.*, b.*,c.*,d.*,e.*,f.id_kk,f.no_kk FROM pmks a 
                             INNER JOIN kecamatan b USING (id_kec)
                             INNER JOIN desa c USING (id_desa)
                             INNER JOIN kat_pmks d USING (id_kat_pmks)
                             INNER JOIN program_bantuan e USING (id_program)
                             INNER JOIN kk f USING (id_kk)
                             WHERE a.id_kk = $id AND a.is_delete = 1 "); ?>

          ?>

          <h1 class="h3 mb-4 text-judul">Data PMKS</h1>
          <div class="card shadow mb-2">
            <div class="card-header py-3">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPmks">
                    Tambah Data PMKS
              </button>

              <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">NIK PMKS</th>
                      <th class="text-center">Nama PMKS</th>
                      <th class="text-center">Kategori PMKS</th>
                      <th class="text-center">Program Bantuan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>

                  <?php $i=$awaldata+1; ?>
                  <?php foreach ($pmks as $row1):?>

                    <tbody>
                      <tr>
                        <td class="text-center"><?=$i;?></td>
                        <td class="text-left"><a class="text-dark2" 
                                href="pmks_detail.php?id=<?=$row1['id_pmks'] ?>">
                                <?=$row1['nik_pmks']; ?></a></td>
                        <td class="text-left"><?=$row1['nm_pmks'];?></td>
                        <td class="text-left"><?=$row1['nm_kat'];?></td>
                        <td class="text-left"><?=$row1['nm_program'];?></td>
                        <td class="text-center">
                          <form method="POST">
                             <button type="button" id="edit_pmks" name="edit_pmks" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditPmks<?= $row1['id_pmks']; ?>">
                            <i class="fas fa-edit"></i> Edit</button>

                            <input type="hidden" name="id_pmks" value="<?=$row1['id_pmks'];?>">
                            <button type="submit" name="hapus_pmks" class="btn btn-danger btn-sm" onclick="return confirm('yakin hapus <?=$row1['nm_pmks'] ?>?');">
                            <i class="fas fa-trash-alt"></i> Delete</button>
                          </form>
                        </td>
                      </tr>
                      <?php $i++;?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                <!--   <ul class="pagination float-right">
                    <?php if ($pageAktif > 1) : ?>
                      <li class="page-item"><a class="page-link" href="kk_detail.php?id=<?=$id?>?page=<?=$pageAktif-1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i=1; $i <= $jml_Halaman; $i++) : ?>
                      <?php if ($i == $pageAktif) : ?>
                        <li class="page-item active"><a class="page-link" href="kk_detail.php?id=<?=$id?>?page=<?=$i; ?>"><?=$i; ?></a></li>
                        <?php else : ?>
                          <li class="page-item"><a class="page-link" href="kk_detail.php?id=<?=$id?>?page=<?=$i; ?>"><?=$i; ?></a></li>
                        <?php endif; ?>
                      <?php endfor; ?>
                      <?php if ($pageAktif < $jml_Halaman) : ?>
                        <li class="page-item"><a class="page-link" href="kk_detail.php?id=<?=$id?>?page=<?=$pageAktif+1; ?>">Next</a></li>
                      <?php endif; ?>
                    </ul>
                  </nav> -->
                </div>
              </div>

          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <br>

      <?php include('templetes/footer.php');?>

      <!-- Modal Edit Data -->
              <?php foreach ($kk2 as $row)  : ?>
              <div class="modal fade" id="modalEdit<?=$kk['id_kk']?>" tabindex="-2" role="dialog" aria-labelledby="modalEditDataTitle" aria-hidden="true">
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
              <div class="modal fade" id="modalPmks" tabindex="-2" role="dialog" aria-labelledby="modalPmksDataTitle" aria-hidden="true">
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

              <!-- Modal Edit PMKS-->
              <?php foreach ($pmks as $row1)  : ?>
              <div class="modal fade" id="modalEditPmks<?=$row1['id_pmks'] ?>" tabindex="-2" role="dialog" 
                    aria-labelledby="modalEditPmksDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered " role="document">
                   <div class="modal-content ">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg bg-warning" back>
                         <h5 class="modal-title modal-text" id="modalEditPmksDataTitle">Edit Data PMKS</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                        <form>

                            <input type="hidden" name="id_pmks" class="form-control" value="<?=$row1['id_pmks']?>">
                            <input type="hidden" name="id_kk" class="form-control" value="<?=$row1['id_kk']?>">
                            <!-- Data lama -->
                            <input type="hidden" name="id_kk2" class="form-control" value="<?=$row1['id_kk']?>">
                            <input type="hidden" name="id_kec2" class="form-control" value="<?=$row1['id_kec']?>">
                            <input type="hidden" name="id_desa2" class="form-control" value="<?=$row1['id_desa']?>">
                            <input type="hidden" name="id_kat_pmks2" class="form-control" value="<?=$row1['id_kat_pmks']?>">
                            <input type="hidden" name="id_program2" class="form-control" value="<?=$row1['id_program']?>">
                            <input type="hidden" name="hsl_survei2" class="form-control" value="<?=$row1['hsl_survei']?>">
                            <input type="hidden" name="nik_pmks2" class="form-control" value="<?=$row1['nik_pmks']?>">
                            <input type="hidden" name="nm_pmks2" class="form-control" value="<?=$row1['nm_pmks']?>">
                            <input type="hidden" name="tgl_lhr_pmks2" class="form-control" value="<?=$row1['tgl_lhr_pmks']?>">
                            <input type="hidden" name="hubungan2" class="form-control" value="<?=$row1['hubungan']?>">
                            <input type="hidden" name="jns_klm_pmks2" class="form-control" value="<?=$row1['jns_klm_pmks']?>">
                            <input type="hidden" name="nm_ibu_pmks2" class="form-control" value="<?=$row1['nm_ibu_pmks']?>">
                            <input type="hidden" name="pendidikan_pmks2" class="form-control" value="<?=$row1['pendidikan_pmks']?>">
                            <input type="hidden" name="is_delete2" class="form-control" value="0">
                            <input type="hidden" name="row_edit2" class="form-control" value="<?=$row1['id_kk']?>">
                            <input type="hidden" name="id_pegawai2" class="form-control" value="<?=$row1['creator']?>">
                            <input type="hidden" name="time_input2" class="form-control" value="<?=date("Y-m-d H:i:s") ?>">
                            <!-- Data Baru -->
                            <input type="hidden" name="hsl_survei" class="form-control" value="<?=$row1['hsl_survei']?>">
                            <input type="hidden" name="is_delete" class="form-control" value="1">
                            <input type="hidden" name="row_edit" class="form-control" value="<?=$row1['row_edit']?>">
                            <input type="hidden" name="id_pegawai" class="form-control" value="<?= $pegawai['id_pegawai'] ?>">
                            <input type="hidden" name="time_input" class="form-control" value="<?=$row1['time_input']?>">


                            <div class="form-group">
                              <label for="nik_pmks" class="col-form-label">NIK PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nik_pmks" name="nik_pmks" value="<?=$row1['nik_pmks']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="nm_pmks" class="col-form-label">Nama PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nm_pmks" name="nm_pmks" value="<?=$row1['nm_pmks']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="tgl_lhr_pmks" class="col-form-label">Tanggal Lahir PMKS:</label>
                              <input type="date" class="form-control mt-1" id="tgl_lhr_pmks" name="tgl_lhr_pmks" 
                                     value="<?=$row1['tgl_lhr_pmks']?>" required>
                            </div>

                            <?php if ($row1['no_kk'] != 'Tidak Ada') : ?>

                              <div class="form-group">
                                <label for="wilayah" class="col-form-label">Kecamatan - Kelurahan/Desa:</label>
                                <input type="hidden" id="wilayah" name="wilayah" value="<?=$row1['id_kec'].' | '.$row1['id_desa'];?>">
                                <input type="text" class="form-control mt-1" value="<?=$row1['nm_kec'].' - '.$row1['nm_desa'];?>" readonly>
                              </div> 

                            <?php else : ?>

                            <div class="form-group">
                              <label for="wilayah">Kecamatan - Kelurahan/Desa:</label>
                              <input type="hidden" id="wilayah" name="wilayah" value="<?=$row1['id_kec'].' | '.$row1['id_desa'];?>">
                              <select class="form-control" id="wilayah" name="wilayah">
                                <?php 
                                $kec = query("SELECT a.*,b.* FROM kecamatan a INNER JOIN desa b USING (id_kec)
                                              WHERE a.is_delete=1 AND b.is_delete=1 AND nm_kec!= 'Tidak Ada' ORDER BY a.nm_kec ASC");
                                foreach ($kec as $key) :?>
                                  <option value="<?=$key['id_kec'].'|'.$key['id_desa']?>"
                                           <?php  
                                              $kect=$row1['id_kec'];
                                              $des =$row1['id_desa'];
                                              $wil =$kect." - ".$des;
                                              if ($wil==$key['id_kec'].' - '.$key['id_desa']) {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                           ><?=$key['nm_kec'].' - '.$key['nm_desa'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                          <?php endif; ?>


                          <?php if ($row['no_kk'] != 'Tidak Ada') : ?>

                          <div class="form-group">
                              <label for="hubungan">Hubungan Kepala Keluarga Dengan PMKS:</label>
                              <select class="form-control" id="hubungan" name="hubungan">
                                 <option value="Kepala Keluarga"
                                              <?php  if ($row1['hubungan']=='Kepala Keluarga') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Kepala Keluarga</option>
                                <option value="Suami"
                                              <?php  if ($row1['hubungan']=='Suami') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Suami</option>
                                <option value="Istri"
                                              <?php  if ($row1['hubungan']=='Istri') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Istri</option>
                                <option value="Anak"
                                              <?php  if ($row1['hubungan']=='Anak') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Anak</option>
                                <option value="Orang Tua"
                                              <?php  if ($row1['hubungan']=='Orang Tua') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Orang Tua</option>
                                <option value="Keluarga"
                                              <?php  if ($row1['hubungan']=='Keluarga') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Keluarga</option>
                                <option value="Lainnya"
                                              <?php  if ($row1['hubungan']=='Lainnya') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Lainnya</option>
                               
                              </select>
                            </div>

                            <?php else : ?>

                             <div class="form-group">
                              <label for="hubungan" class="col-form-label">Hubungan Kepala Keluarga Dengan PMKS:</label>
                              <input type="text" class="form-control mt-1" id="hubungan" name="hubungan" value="<?=$row1['hubungan'] ?>" readonly>
                             </div> 

                            <?php endif; ?>

                             <div class="form-group">
                              <label for="jns_klm_pmks">Jenis Kelamin PMKS:</label>
                              <select class="form-control" id="jns_klm_pmks" name="jns_klm_pmks">
                                <option value="Laki-Laki"
                                              <?php  if ($row1['jns_klm_pmks']=='Laki-Laki') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Laki-Laki</option>
                                <option value="Perempuan"
                                              <?php  if ($row1['jns_klm_pmks']=='Perempuan') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                      >Perempuan</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="nm_ibu_pmks" class="col-form-label">Nama Ibu PMKS:</label>
                              <input type="text" class="form-control mt-1" id="nm_ibu_pmks" name="nm_ibu_pmks" value="<?=$row1['nm_ibu_pmks']?>" required>
                            </div>

                            <div class="form-group">
                              <label for="pendidikan_pmks">Pendidikan PMKS</label>
                              <select class="form-control" id="pendidikan_pmks" name="pendidikan_pmks">
                                <option value="Tidak Sekolah" 
                                              <?php  if ($row1['pendidikan_pmks']=='Tidak Sekolah') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >Tidak Sekolah</option>
                                <option value="SD" 
                                              <?php  if ($row1['pendidikan_pmks']=='SD') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SD</option>
                                <option value="SMP"
                                              <?php  if ($row1['pendidikan_pmks']=='SMP') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SMP</option>
                                <option value="SMA/SMK"
                                              <?php  if ($row1['pendidikan_pmks']=='SMA/SMK') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >SMA/SMK</option>
                                <option value="S1"
                                              <?php  if ($row1['pendidikan_pmks']=='S1') {
                                                echo "selected";
                                              }else{
                                                echo "";
                                              }?> 
                                    >S1</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="id_kat_pmks">Kategori PMKS:</label>
                              <select class="form-control" id="id_kat_pmks" name="id_kat_pmks">
                                <?php 
                                $kat = query("SELECT * FROM kat_pmks WHERE is_delete=1");
                                foreach ($kat as $key) :?>
                                  <option value="<?=$key['id_kat_pmks']?>"
                                    <?php  if ($row1['nm_kat']==$key['nm_kat']) {
                                      echo "selected";
                                    }else{
                                      echo "";
                                    }?>
                                    >
                                    <?=$key['nm_kat'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                             <div class="form-group">
                              <label for="id_program">Program Bantuan PMKS:</label>
                              <select class="form-control" id="id_program" name="id_program">
                                <?php 
                                $kat = query("SELECT * FROM program_bantuan WHERE is_delete=1");
                                foreach ($kat as $key) :?>
                                   <option value="<?=$key['id_program']?>"
                                    <?php  if ($row1['nm_program']==$key['nm_program']) {
                                      echo "selected";
                                    }else{
                                      echo "";
                                    }?>
                                    >
                                    <?=$key['nm_program'];?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                           <button type="submit" name="edit_pmks" class="btn btn-primary">Update</button>
                         </div>
                       </form>
                     </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>