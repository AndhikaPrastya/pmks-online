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
  <link rel="icon" type="image/png" href="../assets/img/pmks.png"/>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../assets/css/mycss.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper" id="menu">

    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#003e51">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon">
          <i class="fas fa-laptop-code"></i>
        </div> -->
        <style type="text/css">
          .size {
            width: 45px;
          }
        </style>

        <div>
          <img class="size" src="../assets/img/pmks.png">
        </div>
        <div class="sidebar-brand-text mx-3">PMKS ONLINE <h6>Kab.Indramayu</h6></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li <?php if($page == "index") { 
                echo "class='nav-item active' "; 
            } else {
                echo "class='nav-item' ";
            } ?> >
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        PMKS Online
      </div>


      <!-- Nav Item - menu pmks -->
      <li <?php if($page == "pmks") { 
                echo "class='nav-item active' "; 
            } else {
                echo "class='nav-item' ";
            } ?> >
        <a class="nav-link" href="pmks.php" >
          <i class="fas fa-book"></i>
          <span>Data PMKS</span>
        </a>
      </li>


       <!-- Nav Item - user -->
<!--       <li <?php if($page == "pegawai") { 
                echo "class='nav-item active' "; 
            } else {
                echo "class='nav-item' ";
            } ?> >
        <a class="nav-link" href="pegawai.php" >
         <i class="fas fa-users"></i>
          <span>Data PMKS Survei</span>
        </a>
      </li> -->

     <li <?php if($page == "laporan") { 
                echo "class='nav-item active' "; 
            } else {
                echo "class='nav-item' ";
            } ?> >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          <i class="fas fa-chart-pie"></i>
          <span>Laporan</span>
        </a>
        <div id="collapseThree" <?php if($page == "laporan") { 
                echo "class='collapse show' "; 
            } else {
                echo "class='collapse' ";
            } ?>
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu Laporan :</h6>
            <a <?php if($page == "laporan" AND $page1 == "all") { 
              echo "class='collapse-item active' "; 
            } else {
              echo "class='collapse-item' ";
            } ?> 
            href="laporan.php">Laporan PMKS</a>

            <a <?php if($page == "laporan" AND $page1 == "wil") { 
              echo "class='collapse-item active' "; 
            } else {
              echo "class='collapse-item' ";
            } ?>   
            href="laporan_wil.php">Laporan Wilayah</a>

            <a <?php if($page == "laporan" AND $page1 == "prog") { 
              echo "class='collapse-item active' "; 
            } else {
              echo "class='collapse-item' ";
            } ?>   
            href="laporan_prog.php">Laporan Program Bantuan</a>

            <a <?php if($page == "laporan" AND $page1 == "krt") { 
              echo "class='collapse-item active' "; 
            } else {
              echo "class='collapse-item' ";
            } ?>   
            href="laporan_krt.php">Laporan Kriteria PMKS</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - User -->
      <li class="nav-item">
        <a class="nav-link" href="../logout.php" data-toggle="modal" data-target="#logoutModal" >
          <i class="fas fa-door-open"></i>
          <span>Logout</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <style type="text/css">
      .latar-belakang {
        background-image: url('../assets/img/gambar2.jpg');
        background-repeat: no-repeat;
        background-size: cover;
      }
      .text-judul {
        color: #ffffff;
      }
    </style>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column bg-secondary" >

      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

         

        
          