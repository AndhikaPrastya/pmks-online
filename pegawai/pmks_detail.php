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
  $pmks=query("SELECT * FROM pmks where id_pmks='$id'")[0];

  $pmks2=query("SELECT a.*, b.*,c.*,d.*,e.*,f.id_kk,f.no_kk FROM pmks a 
               INNER JOIN kecamatan b USING (id_kec)
               INNER JOIN desa c USING (id_desa)
               INNER JOIN kat_pmks d USING (id_kat_pmks)
               INNER JOIN program_bantuan e USING (id_program)
               INNER JOIN kk f USING (id_kk)
               WHERE a.id_pmks = $id AND a.is_delete = 1 ");

  // var_dump($kriteria);die;


  if(isset($_POST["edit_pmks"])){
  // var_dump($_POST);die;
  if(editDataPmks($_POST)>0){
    echo"
       <script>
       alert('data berhasil di ubah');
       document.location.href='pmks_detail.php?id=$id';
       </script>
       ";
      }else{
        echo"
       <script>
       alert('data gagal di ubah');
       document.location.href='pmks_detail.php?id=$id';
       </script>
       ";
      }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-judul">Data PMKS - NIK : <?=$pmks['nik_pmks'] ?></h1>

          <!-- isi content -->
          <div class="card shadow mb-2">
            <div class="card-header py-3">
               <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEditPmks">
                    Edit Data PMKS
              </button>

              <div class="card-body">
                <div class="table-responsive">

                 <table class="table table-striped">
                  <tbody>
                    <?php foreach ($pmks2 as $row):?>
                    <tr>
                      <th scope="row">NIK PMKS</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nik_pmks'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Hasil Survei</th>
                      <td>:</td>
                      <td class="text-left"><b><?=$row['hsl_survei'] ?></b></td>
                    </tr>
                    <tr>
                      <th scope="row">Nama PMKS</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_pmks'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Tanggal Lahir PMKS</th>
                      <td>:</td>
                      <td class="text-left"><?=date('d-M-Y', strtotime($row['tgl_lhr_pmks'])) ?></td>
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
                      <th scope="row">Jenis Kelamin</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['jns_klm_pmks'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Ibu Kandung</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_ibu_pmks'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Pendidikan</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['pendidikan_pmks'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Hubungan KK dengan PMKS</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['hubungan'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Kategori PMKS</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_kat'] ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Program Bantuan</th>
                      <td>:</td>
                      <td class="text-left"><?=$row['nm_program'] ?></td>
                    </tr>
                    <?php endforeach; ?>
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


<!-- Modal Edit PMKS-->
              <?php foreach ($pmks2 as $row1)  : ?>
              <div class="modal fade" id="modalEditPmks" tabindex="-2" role="dialog" 
                    aria-labelledby="modalEditPmksDataTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <form method="post" enctype="multipart/form-data">
                       <div class="modal-header modal-bg" back>
                         <h5 class="modal-title modal-text" id="modalEditPmksDataTitle">Tambah Data PMKS</h5>
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