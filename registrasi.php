<?php
date_default_timezone_set('Asia/Jakarta');
require 'config.php';
require 'functions.php';

if (isset($_POST["register"])) {

  if (register($_POST) > 0) {
    echo "<script>
        alert('Pengguna berhasil ditambahkan!');
        document.location.href='index.php';
        </script>";
  } else {
    echo mysqli_error($koneksi);
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>PMKS Online - Registrasi</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" type="image/png" href="assets/img/pmks.png" />
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient" style="background-color:#003E51">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-5 col-lg-5 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="assets/img/pmks.png" style="width: 100px; height: 120px;">
                    <hr>
                    <h1 class="h4 text-gray-900 mb-4">Registrasi Akun</h1>
                  </div>

                  <form class="user" action="" method="post">


                    <div class="form-group">
                      <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="form-control form-control-user">
                    </div>

                    <div class="form-group">
                      <input type="text" name="nip" id="nip" placeholder="NIP" class="form-control form-control-user">
                    </div>

                    <div class="form-group">
                      <input type="text" name="no_tlp" id="no_tlp" placeholder="No Telepon" class="form-control form-control-user">
                    </div>

                    <div class="form-group">
                      <input type="text" name="alamat" id="alamat" placeholder="Alamat" class="form-control form-control-user">
                    </div>

                    <div class="form-group">
                      <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-user">
                    </div>

                    <div class="form-group">
                      <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-user" placeholder="Password">
                    </div>

                    <div class="form-group">
                      <input type="password" name="password2" id="password2" placeholder="Konfirmasi Password" class="form-control form-control-user">
                    </div>

                    <input class="input100" type="hidden" name="role" id="role" value="Pegawai">
                    <input class="input100" type="hidden" name="time_input" id="time_input" 
                                                        value="<?=date("Y-m-d H:i:s"); ?>">

                    <div class="form-group">
                      <button class="btn btn-primary btn-user btn-block" type="submit" name="register">
                        Daftar
                      </button>
                    </div>

                    <hr>
                    <div class="text-center">
                      <a class="small" href="index.php">Login</a>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>