<?php

function query($query)
{
	include('config.php');

	$result = mysqli_query($koneksi, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function register($data)
{
	include('config.php');

	$nama 		= htmlspecialchars($data["nama"]);
	$nip 		= htmlspecialchars($data["nip"]);
	$no_tlp 	= htmlspecialchars($data["no_tlp"]);
	$alamat 	= htmlspecialchars($data["alamat"]);
	$username 	= strtolower(stripcslashes($data["username"]));
	$role 		= htmlspecialchars($data["role"]);
	$password 	= mysqli_real_escape_string($koneksi, $data["password"]);
	$password2 	= mysqli_real_escape_string($koneksi, $data["password2"]);
	$time_input = $data["time_input"];


	//cek nip ada atau belum
	$result = mysqli_query($koneksi, "SELECT nip FROM pegawai WHERE nip = '$nip'");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('NIP sudah terdaftar!')
 			  </script>";
		return false;
	}

	// cek password
	if ($password !== $password2) {
		echo "<script>
 			   alert('Konfirmasi password tidak sesuai!');
 			  </script>";
		return false;
	}
	//enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "INSERT INTO pegawai VAlUES ('','$nama','$nip','$no_tlp','$alamat','$username','$password','$role',1,0,'$time_input')";

	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}


function tambahDataKecamatan($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$nm_kec 	= htmlspecialchars($data["nm_kec"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator	= $data["id_pegawai"];
	$time_input = $data["time_input"];

	//cek kecamatan sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_kec FROM kecamatan WHERE nm_kec = '$nm_kec' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kecamatan sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO kecamatan VAlUES ('','$nm_kec','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataKecamatan($data)
{
	include('config.php');

	$id_kec = $data["id_kec"];

	$query 	= "UPDATE kecamatan SET is_delete = 0 WHERE id_kec='$id_kec'";
	mysqli_query($koneksi, $query);

	$query1 	= "UPDATE desa SET is_delete = 0 WHERE id_kec='$id_kec'";
	mysqli_query($koneksi, $query1);

	$query2 	= "UPDATE kk SET is_delete = 0 WHERE id_kec='$id_kec'";
	mysqli_query($koneksi, $query2);

	$query3 	= "UPDATE pmks SET is_delete = 0 WHERE id_kec='$id_kec'";
	mysqli_query($koneksi, $query3);

	return mysqli_affected_rows($koneksi);
}

function editDataKecamatan($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_kec  = $data["id_kec"];

	$nm_kec2 	 = $data["nm_kec2"];
	$is_delete2	 = $data["is_delete2"];
	$row_edit2 	 = $data["row_edit2"];
	$creator2    = $data["id_pegawai2"];
	$time_input2 = $data["time_input2"];

	$nm_kec 	= htmlspecialchars($data["nm_kec"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator    = $data["id_pegawai"];
	$time_input = $data["time_input"];


	// echo $id_kec."<br>".$nm_kec."<br>".$is_delete."<br>".$row_edit."<br>".$creator."<br>".$time_input."<br>"; 
	// echo $id_kec."<br>".$nm_kec2."<br>".$is_delete2."<br>".$row_edit2."<br>".$creator2."<br>".$time_input2."<br>";die;

	// cek kecamatan sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_kec FROM kecamatan WHERE nm_kec = '$nm_kec' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kecamatan sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "UPDATE kecamatan SET 
 				   	 nm_kec='$nm_kec', is_delete='$is_delete', 
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_kec='$id_kec'";

	mysqli_query($koneksi, $query);

	$query2 = "INSERT INTO kecamatan VAlUES ('','$nm_kec2','$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function tambahDataDesa($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$nm_desa 	= htmlspecialchars($data["nm_desa"]);
	$id_kec		= $data["id_kec"];
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator	= $data["id_pegawai"];
	$time_input = $data["time_input"];

	//cek desa sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_desa FROM desa WHERE nm_desa = '$nm_desa' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kelurahan/Desa sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO desa VAlUES ('','$nm_desa','$id_kec','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataDesa($data)
{
	include('config.php');

	$id_desa = $data["id_desa"];

	$query 	= "UPDATE desa SET is_delete = 0 WHERE id_desa='$id_desa'";
	mysqli_query($koneksi, $query);

	$query1 = "UPDATE kk SET is_delete = 0 WHERE id_desa='$id_desa'";
	mysqli_query($koneksi, $query1);

	$query2 = "UPDATE pmks SET is_delete = 0 WHERE id_desa='$id_desa'";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function editDataDesa($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_desa  = $data["id_desa"];

	$id_kec2 	= $data["id_kec2"];
	$nm_desa2 	 = $data["nm_desa2"];
	$is_delete2	 = $data["is_delete2"];
	$row_edit2 	 = $data["row_edit2"];
	$creator2    = $data["id_pegawai2"];
	$time_input2 = $data["time_input2"];

	$id_kec 	= $data["id_kec"];
	$nm_desa 	= htmlspecialchars($data["nm_desa"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator    = $data["id_pegawai"];
	$time_input = $data["time_input"];


	// cek desa sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_desa FROM desa WHERE nm_desa = '$nm_desa' AND id_kec = '$id_kec' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kelurahan/Desa sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "UPDATE desa SET 
 				   	 nm_desa='$nm_desa',id_kec='$id_kec',is_delete='$is_delete', 
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_desa='$id_desa'";

	mysqli_query($koneksi, $query);

	$query2 = "INSERT INTO desa VAlUES ('','$nm_desa2','$id_kec2','$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function tambahDataProgram($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$program 	= htmlspecialchars($data["program"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator	= $data["id_pegawai"];
	$time_input = $data["time_input"];

	//cek program bantuan sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_program FROM program_bantuan WHERE nm_program = '$program' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Program Bantuan sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO program_bantuan VAlUES ('','$program','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataProgram($data)
{
	include('config.php');

	$id_program = $data["id_program"];

	$query 	= "UPDATE program_bantuan SET is_delete = 0 WHERE id_program='$id_program'";
	mysqli_query($koneksi, $query);

	$query1 	= "UPDATE pmks SET is_delete = 0 WHERE id_program='$id_program'";
	mysqli_query($koneksi, $query1);

	return mysqli_affected_rows($koneksi);
}

function editDataProgram($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_program  = $data["id_program"];

	$program2 	 = $data["program2"];
	$is_delete2	 = $data["is_delete2"];
	$row_edit2 	 = $data["row_edit2"];
	$creator2    = $data["id_pegawai2"];
	$time_input2 = $data["time_input2"];

	$program 	= htmlspecialchars($data["program"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator    = $data["id_pegawai"];
	$time_input = $data["time_input"];


	// cek program_bantuan sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_program FROM program_bantuan WHERE nm_program = '$program' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Program Bantuan sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "UPDATE program_bantuan SET 
 				   	 nm_program='$program', is_delete='$is_delete', 
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_program='$id_program'";

	mysqli_query($koneksi, $query);
	$query2 = "INSERT INTO program_bantuan VAlUES ('','$program2','$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function tambahDataKategori($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$nm_kat 	= htmlspecialchars($data["nm_kat"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator	= $data["id_pegawai"];
	$time_input = $data["time_input"];

	//cek kategori PMKS sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_kat FROM kat_pmks WHERE nm_kat = '$nm_kat' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kategori PMKS sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO kat_pmks VAlUES ('','$nm_kat','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataKategori($data)
{
	include('config.php');

	$id_kat_pmks = $data["id_kat_pmks"];

	$query 	= "UPDATE kat_pmks SET is_delete = 0 WHERE id_kat_pmks='$id_kat_pmks'";
	mysqli_query($koneksi, $query);

	$query1 	= "UPDATE pmks SET is_delete = 0 WHERE id_kat_pmks='$id_kat_pmks'";
	mysqli_query($koneksi, $query1);

	return mysqli_affected_rows($koneksi);
}

function editDataKategori($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_kat_pmks  = $data["id_kat_pmks"];

	$nm_kat2 	 = $data["nm_kat2"];
	$is_delete2	 = $data["is_delete2"];
	$row_edit2 	 = $data["row_edit2"];
	$creator2    = $data["id_pegawai2"];
	$time_input2 = $data["time_input2"];

	$nm_kat 	= htmlspecialchars($data["nm_kat"]);
	$is_delete	= $data["is_delete"];
	$row_edit 	= $data["row_edit"];
	$creator    = $data["id_pegawai"];
	$time_input = $data["time_input"];


	// cek kategori PMKS sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nm_kat FROM kat_pmks WHERE nm_kat = '$nm_kat' AND is_delete=1");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('Kategori PMKS sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "UPDATE kat_pmks SET 
 				   	 nm_kat='$nm_kat', is_delete='$is_delete', 
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_kat_pmks='$id_kat_pmks'";

	mysqli_query($koneksi, $query);
	$query2 = "INSERT INTO kat_pmks VAlUES ('','$nm_kat2','$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function tambahDataKk($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$no_kk 			= htmlspecialchars($data["no_kk"]);
	$nik_kpl 		= htmlspecialchars($data["nik_kpl"]);
	$nm_kpl 		= htmlspecialchars($data["nm_kpl"]);
	$tgl_lhr_kpl 	= htmlspecialchars($data["tgl_lhr_kpl"]);
	$wilayah 		= $data['wilayah'];
	$explode 		= explode('|', $wilayah);
	$id_kec 		= $explode[0];
	$id_desa 		= $explode[1];
	$alamat_kpl 		= htmlspecialchars($data["alamat_kpl"]);
	$pekerjaan_kpl 	= htmlspecialchars($data["pekerjaan_kpl"]);
	$pendidikan_kpl = $data["pendidikan_kpl"];
	$is_delete		= $data["is_delete"];
	$row_edit 		= $data["row_edit"];
	$creator		= $data["id_pegawai"];
	$time_input 	= $data["time_input"];

	//cek no kk sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT no_kk FROM kk WHERE no_kk = '$no_kk' AND is_delete=1 ");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('No KK sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO kk VAlUES ('','$id_kec','$id_desa','$no_kk','$nik_kpl',
 									 '$nm_kpl','$tgl_lhr_kpl','$alamat_kpl','$pekerjaan_kpl',
 									 '$pendidikan_kpl','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataKk($data)
{
	include('config.php');

	$id_kk = $data["id_kk"];

	$query 	= "UPDATE kk SET is_delete = 0 WHERE id_kk='$id_kk'";
	mysqli_query($koneksi, $query);

	$query1 	= "UPDATE pmks SET is_delete = 0 WHERE id_kk='$id_kk'";
	mysqli_query($koneksi, $query1);

	return mysqli_affected_rows($koneksi);
}

function editDataKk($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_kk  			= $data["id_kk"];

	$no_kk2 			= $data["no_kk2"];
	$nik_kpl2 			= $data["nik_kpl2"];
	$nm_kpl2 			= $data["nm_kpl2"];
	$tgl_lhr_kpl2 		= $data["tgl_lhr_kpl2"];
	$id_kec2 			= $data["id_kec2"];
	$id_desa2 			= $data["id_desa2"];
	$alamat_kpl2 		= $data["alamat_kpl2"];
	$pekerjaan_kpl2 	= $data["pekerjaan_kpl2"];
	$pendidikan_kpl2 	= $data["pendidikan_kpl2"];
	$is_delete2			= $data["is_delete2"];
	$row_edit2 			= $data["row_edit2"];
	$creator2			= $data["id_pegawai2"];
	$time_input2 		= $data["time_input2"];

	$no_kk 				= htmlspecialchars($data["no_kk"]);
	$nik_kpl 			= htmlspecialchars($data["nik_kpl"]);
	$nm_kpl 			= htmlspecialchars($data["nm_kpl"]);
	$tgl_lhr_kpl 		= htmlspecialchars($data["tgl_lhr_kpl"]);
	$wilayah 			= $data['wilayah'];
	$explode 			= explode('|', $wilayah);
	$id_kec 			= $explode[0];
	$id_desa 			= $explode[1];
	$alamat_kpl 		= htmlspecialchars($data["alamat_kpl"]);
	$pekerjaan_kpl 		= htmlspecialchars($data["pekerjaan_kpl"]);
	$pendidikan_kpl 	= $data["pendidikan_kpl"];
	$is_delete			= $data["is_delete"];
	$row_edit 			= $data["row_edit"];
	$creator			= $data["id_pegawai"];
	$time_input 		= $data["time_input"];


	// cek KKS sudah ada atau belum
	$result =mysqli_query($koneksi, "SELECT no_kk FROM kk WHERE no_kk = '$no_kk' AND is_delete=1 ");

	if ( mysqli_fetch_assoc($result)) {
		echo "<script>
				alert('No KK sudah Ada!')
			  </script>";
	return false;
	}

	$query = "UPDATE kk SET 
 				   	 no_kk='$no_kk', nik_kpl='$nik_kpl', 
 				   	 nm_kpl='$nm_kpl', tgl_lhr_kpl='$tgl_lhr_kpl',
 				   	 id_kec='$id_kec', id_desa='$id_desa', alamat_kpl='$alamat_kpl',
 				   	 pekerjaan_kpl='$pekerjaan_kpl', pendidikan_kpl='$pendidikan_kpl',
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_kk='$id_kk'";
	mysqli_query($koneksi, $query);

	$query1 = "UPDATE pmks SET 
 				   	 id_kec='$id_kec', id_desa='$id_desa' WHERE id_kk='$id_kk'";
	mysqli_query($koneksi, $query1);

	$query2 = "INSERT INTO kk VAlUES ('','$id_kec2','$id_desa2','$no_kk2','$nik_kpl2','$nm_kpl2',
 									  '$tgl_lhr_kpl2','$alamat_kpl2','$pekerjaan_kpl2','$pendidikan_kpl2',
 									  '$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}


function tambahDataPmks($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_kk 			 = $data["id_kk"];
	$id_kat_pmks 	 = $data["id_kat_pmks"];
	$id_program 	 = $data["id_program"];
	$hsl_survei 	 = "Menunggu";
	$nik_pmks 		 = htmlspecialchars($data["nik_pmks"]);
	$nm_pmks	 	 = htmlspecialchars($data["nm_pmks"]);
	$tgl_lhr_pmks 	 = $data['tgl_lhr_pmks'];
	$wilayah 		 = $data['wilayah'];
	$explode 		 = explode('|', $wilayah);
	$id_kec 		 = $explode[0];
	$id_desa 		 = $explode[1];
	$hubungan 		 = $data["hubungan"];
	$jns_klm_pmks 	 = $data["jns_klm_pmks"];
	$nm_ibu_pmks 	 = htmlspecialchars($data["nm_ibu_pmks"]);
	$pendidikan_pmks = $data["pendidikan_pmks"];
	$is_delete		 = $data["is_delete"];
	$row_edit 		 = $data["row_edit"];
	$creator		 = $data["id_pegawai"];
	$time_input 	 = $data["time_input"];


	//cek pmks sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT nik_pmks FROM pmks WHERE nik_pmks = '$nik_pmks' AND is_delete=1 AND no_kk!='Tidak Ada'");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
 				alert('NIK PMKS sudah Ada!')
 			  </script>";
		return false;
	}

	$query = "INSERT INTO pmks VAlUES ('','$id_kk','$id_kec','$id_desa','$id_kat_pmks','$id_program','$hsl_survei','$nik_pmks',
 									 '$nm_pmks','$tgl_lhr_pmks','$hubungan','$jns_klm_pmks',
 									 '$nm_ibu_pmks','$pendidikan_pmks','$is_delete','$row_edit','$creator','$time_input')";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusDataPmks($data)
{
	include('config.php');

	$id_pmks = $data["id_pmks"];

	$query 	= "UPDATE pmks SET is_delete = 0 WHERE id_pmks='$id_pmks'";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function editDataPmks($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_pmks  		 = $data["id_pmks"];

	$id_kk2 		 = $data["id_kk2"];
	$id_kec2 		 = $data["id_kec2"];
	$id_desa2 		 = $data["id_desa2"];
	$id_kat_pmks2 	 = $data["id_kat_pmks2"];
	$id_program2 	 = $data["id_program2"];
	$hsl_survei2 	 = $data["hsl_survei2"];
	$nik_pmks2 		 = $data["nik_pmks2"];
	$nm_pmks2	 	 = $data["nm_pmks2"];
	$tgl_lhr_pmks2 	 = $data['tgl_lhr_pmks2'];
	$hubungan2 		 = $data["hubungan2"];
	$jns_klm_pmks2 	 = $data["jns_klm_pmks2"];
	$nm_ibu_pmks2 	 = $data["nm_ibu_pmks2"];
	$pendidikan_pmks2 = $data["pendidikan_pmks2"];
	$is_delete2		 = $data["is_delete2"];
	$row_edit2 		 = $data["row_edit2"];
	$creator2		 = $data["id_pegawai2"];
	$time_input2 	 = $data["time_input2"];

	$id_kk 			 = $data["id_kk"];
	$wilayah 		 = $data['wilayah'];
	$explode 		 = explode('|', $wilayah);
	$id_kec 		 = $explode[0];
	$id_desa 		 = $explode[1];
	$id_kat_pmks 	 = $data["id_kat_pmks"];
	$id_program 	 = $data["id_program"];
	$hsl_survei 	 = $data["hsl_survei"];
	$nik_pmks 		 = htmlspecialchars($data["nik_pmks"]);
	$nm_pmks	 	 = htmlspecialchars($data["nm_pmks"]);
	$tgl_lhr_pmks 	 = $data['tgl_lhr_pmks'];
	$hubungan 		 = $data["hubungan"];
	$jns_klm_pmks 	 = $data["jns_klm_pmks"];
	$nm_ibu_pmks 	 = htmlspecialchars($data["nm_ibu_pmks"]);
	$pendidikan_pmks = $data["pendidikan_pmks"];
	$is_delete		 = $data["is_delete"];
	$row_edit 		 = $data["row_edit"];
	$creator		 = $data["id_pegawai"];
	$time_input 	 = $data["time_input"];

	// cek pmks sudah ada atau belum
	// $result =mysqli_query($koneksi, "SELECT nik_pmks FROM pmks WHERE nik_pmks = '$nik_pmks' AND is_delete=1");

	// if ( mysqli_fetch_assoc($result)) {
	// 	echo "<script>
	// 			alert('Data PMKS sudah Ada!')
	// 		  </script>";
	// return false;
	// }

	$query = "UPDATE pmks SET 
 				   	 id_kk='$id_kk',id_kec='$id_kec', id_desa='$id_desa', id_kat_pmks='$id_kat_pmks', 
 				   	 id_program='$id_program', hsl_survei='$hsl_survei',
 				   	 nik_pmks='$nik_pmks', nm_pmks='$nm_pmks', tgl_lhr_pmks='$tgl_lhr_pmks',
 				   	 hubungan='$hubungan', jns_klm_pmks='$jns_klm_pmks', nm_ibu_pmks='$nm_ibu_pmks',
 				   	 pendidikan_pmks='$pendidikan_pmks',
 				   	 row_edit='$row_edit', creator='$creator',
 				   	 time_input='$time_input' WHERE id_pmks='$id_pmks'";
	mysqli_query($koneksi, $query);

	$query2 = "INSERT INTO pmks VAlUES ('','$id_kk2','$id_kec2','$id_desa2','$id_kat_pmks2','$id_program2','$hsl_survei2','$nik_pmks2',
 									 '$nm_pmks2','$tgl_lhr_pmks2','$hubungan2','$jns_klm_pmks2',
 									 '$nm_ibu_pmks2','$pendidikan_pmks2','$is_delete2','$row_edit2','$creator2','$time_input2')";
	mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function editDataRole($data)
{
	include('config.php');

	$id_pegawai = $data["id_pegawai"];
	$role = $data["role"];

	$query = "UPDATE pegawai SET role='$role' WHERE id_pegawai='$id_pegawai'";

	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function editDataPegawai($data)
{
	include('config.php');
	// var_dump($_POST);die;

	$id_pegawai  = $data["id_pegawai"];

	$nm_pegawai2 = $data["nm_pegawai2"];
	$nip2 	     = $data["nip2"];
	$no_telepon2 = $data["no_telepon2"];
	$alamat2 	 = $data["alamat2"];
	$username2 	 = $data["username2"];
	$password2 	 = $data["password2"];
	$role2 	     = $data["role2"];
	$is_delete2	 = $data["is_delete2"];
	$row_edit2 	 = $data["row_edit2"];
	$time_input2 = $data["time_input2"];

	$nm_pegawai  = htmlspecialchars($data["nm_pegawai"]);
	$nip 	     = htmlspecialchars($data["nip"]);
	$no_telepon  = htmlspecialchars($data["no_telepon"]);
	$alamat	     = htmlspecialchars($data["alamat"]);
	$username	 = htmlspecialchars($data["username"]);


	// echo $id_kec."<br>".$nm_kec."<br>".$is_delete."<br>".$row_edit."<br>".$creator."<br>".$time_input."<br>"; 
	// echo $id_kec."<br>".$nm_kec2."<br>".$is_delete2."<br>".$row_edit2."<br>".$creator2."<br>".$time_input2."<br>";die;

	// cek kecamatan sudah ada atau belum
	// $result = mysqli_query($koneksi, "SELECT nip FROM pegawai WHERE nip = '$nip' AND is_delete=1");

	// if (mysqli_fetch_assoc($result)) {
	// 	echo "<script>
 // 				alert('NIP sudah Ada!')
 // 			  </script>";
	// 	return false;
	// }

	$query = "UPDATE pegawai SET 
 				   	 nm_pegawai='$nm_pegawai', nip='$nip',
 				   	 no_telepon='$no_telepon', alamat='$alamat',
 				   	 username='$username' WHERE id_pegawai='$id_pegawai'";

	mysqli_query($koneksi, $query);

	// $query2 = "INSERT INTO pegawai VAlUES ('','$nm_pegawai2','$nip2','$no_telepon2',
	// 									  '$alamat2', '$username2', '$password2', '$role2',
	// 									  '$is_delete2','$row_edit2','$time_input2')";
	// mysqli_query($koneksi, $query2);

	return mysqli_affected_rows($koneksi);
}

function hapusDataPegawai($data)
{
	include('config.php');

	$id_pegawai = $data["id_pegawai"];
	$query = "UPDATE pegawai SET is_delete = 0 WHERE id_pegawai='$id_pegawai'";

	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}


function ubahpass($data)
{
	include('config.php');

	$id_pegawai         = $data["id_pegawai"];
	$password1       = htmlspecialchars($data["password1"]);
	$password2       = htmlspecialchars($data["password2"]);
	
	$result = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id_pegawai = '$id_pegawai'");

	if( mysqli_num_rows($result) == 1 ) {
	    	// cek kesamaan password
	    	if ($password1 !== $password2) {
	    		echo "<script>
		    		  alert('Konfirmasi password tidak sesuai!');
		    		  </script>";
	    		return false;
	    	}

	    	$password = password_hash($password1, PASSWORD_DEFAULT);
	    	mysqli_query($koneksi, "UPDATE pegawai SET password ='$password' WHERE id_pegawai = $id_pegawai");
	    	return mysqli_affected_rows($koneksi);

	}
}
