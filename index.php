<?php
session_start();

if (isset($_SESSION["pegawai"])) {
  header("location:pegawai/index.php");
  exit;
}
if (isset($_SESSION["admin"])) {
  header("location:admin/index.php");
  exit;
}
if (isset($_SESSION["pimpinan"])) {
  header("location:pimpinan/index.php");
  exit;
}

require 'config.php';
require 'functions.php';

if (isset($_POST["login"])) {
  // var_dump($_POST);die;

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE username = '$username'");
  // cek username
  if (mysqli_num_rows($result) == 1) {

    // cek password
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
      if ($row['role'] == Admin) {
        $_SESSION["admin"] = true;
        $_SESSION["id_pegawai"] = $row['id_pegawai'];
        $_SESSION["nama"] = $row['nm_pegawai'];
        $_SESSION["nama_role"] = $row['role'];
        header("Location: admin/index.php");
        exit;
      } elseif ($row['role'] == Pegawai) {
        $_SESSION["Pegawai"] = true;
        $_SESSION["id_pegawai"] = $row['id_pegawai'];
        $_SESSION["nama"] = $row['nm_pegawai'];
        $_SESSION["nama_role"] = $row['role'];
        header("Location: pegawai/index.php");
        exit;
      } else {
        $_SESSION["Pimpinan"] = true;
        $_SESSION["id_pegawai"] = $row['id_pegawai'];
        $_SESSION["nama"] = $row['nm_pegawai'];
        $_SESSION["nama_role"] = $row['role'];
        header("Location: pimpinan/index.php");
        exit;
      }
    }
  }
  $error = true;
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

  <title>PMKS ONLINE</title>

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
                    <h1 class="h4 text-gray-900 mb-4">PANDATAAN ONLINE PMKS</h1>
                  </div>

                  <?php
                  if (isset($error)) : ?>
                    <div class="wrap-input100 validate-input m-b-10 alert alert-danger text-center" role="alert">
                      Pasword Salah <p>Coba Lagi!</p>
                    </div>
                  <?php endif; ?>

                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Enter Username...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-user" placeholder="Password">
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary btn-user btn-block" type="submit" name="login">
                        Login
                      </button>
                    </div>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="registrasi.php">Daftar Akun!</a>
                  </div>
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