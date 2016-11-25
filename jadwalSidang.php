<?php 
	session_start();
	require "database.php";

	$username = $_SESSION['username'];
	$role = $_SESSION["role"];
	$nama = $_SESSION["nama"];
	$roleData = "";
	
	if($role == "MHS"){
		$npm = $_SESSION["npm"];
		$conn = connectDatabase();
		$sql = "SELECT mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan FROM MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN R, MAHASISWA m WHERE MKS.idmks=js.idmks AND m.npm=mks.npm AND r.idruangan=js.idruangan AND m.npm='" . $npm ."'";
		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}
		if (pg_num_rows($result) != 0) {
			$data = pg_fetch_array($result);
			$judul = $data[0];
			$tanggal = $data[1];
			$waktu = $data[2] ." - ". $data[3] ." @ ". $data[4];
		}

		$sql = "SELECT d.nama, CASE mks.izinmajusidang when 't' then 'Izin maju sidang' else 'Tidak Diizinkan' END AS izinsidang, CASE mks.pengumpulanhardcopy when 't' then 'Kumpul Hard Copy' else 'Belum Kumpul Hard Copy' END AS hardcopy FROM DOSEN d, DOSEN_PEMBIMBING dp, MATA_KULIAH_SPESIAL mks WHERE d.NIP=dp.nip_dosenpembimbing AND mks.idmks=dp.idmks AND mks.npm='" . $npm . "'";
		$result = pg_query($conn, $sql);
		$b = "";
		while($row = pg_fetch_assoc($result)){
			$b = $b .
			$row['nama'] .", Status: ". $row['izinsidang'] .", ". $row['hardcopy'] . "<br>";
		}

		$sql = "SELECT d.nama FROM DOSEN d, DOSEN_PENGUJI dpj, MATA_KULIAH_SPESIAL mks WHERE d.NIP=dpj.nip_dosenpenguji AND mks.idmks=dpj.idmks AND mks.npm='" . $npm . "'";
		$result = pg_query($conn, $sql);
		$c = "";
		while($row = pg_fetch_assoc($result)){
			$c = $c .
			$row['nama'] ."<br>";
		}

		$roleData = $roleData . 
			"<tr><td>Judul Tugas Akhir</td><td>" . $judul . "</td></tr>
			<tr><td>Jadwal Sidang</td><td>" . $tanggal . "</td></tr>
			<tr><td>WaktuSidang</td><td>" . $waktu . "</td></tr>
			<tr><td>Dosen Pembimbing</td><td>" . $b . "</td></tr>
			<tr><td>Dosen Penguji</td><td>" . $c . "</td></tr>";
	}


	if($role == "DOSEN"){
		$nip = $_SESSION["nip"];
		$conn = connectDatabase();
		$sql = "SELECT mks.judul, js.tanggal, js.jammulai, js.jamselesai, r.namaruangan FROM MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN R, MAHASISWA m WHERE MKS.idmks=js.idmks AND m.npm=mks.npm AND r.idruangan=js.idruangan AND m.npm='" . $npm ."'";
		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}
		if (pg_num_rows($result) != 0) {
			$data = pg_fetch_array($result);
			$judul = $data[0];
			$tanggal = $data[1];
			$waktu = $data[2] ." - ". $data[3] ." @ ". $data[4];
		}
		$roleData = $roleData . 
			"<tr><td>Mahasiswa</td><td>" . $ . "</td></tr>
			<tr><td>Jenis Sidang</td><td>" . $ . "</td></tr>
			<tr><td>Judul</td><td>" . $ . "</td></tr>
			<tr><td>Waktu dan Lokasi</td><td>" . $ . "</td></tr>
			<tr><td>Pembimbing Lain</td><td>" . $ . "</td></tr>
			<tr><td>Status</td><td>" . $ . "</td></tr>";
	}

/*	if($role == "ADMIN"){
		$sql = "SELECT m.nama, jmks.nama, mks.judul, js.jammulai, js.jamselesai, r.nama, dp.nama, dpj. nama 
		FROM MAHASISWA m, JENIS_MKS jmks, MATA_KULIAH_SPESIAL mks, JADWAL_SIDANG js, RUANGAN r, DOSEN_PEMBIMBING dp, DOSEN_PENGUJI dpj 
		WHERE m.NPM=mks.NPM AND mks.idjenismks=jmks.id AND mks.idmks=js.idmks AND dp.idmks=mks.idmks AND dpj.idmks=mks.idmks AND js.idruangan=r.idruangan AND ";
		$roleData = $roleData . 
			"<tr><td>Mahasiswa</td><td>" . $ . "</td></tr>
			<tr><td>Jenis Sidang</td><td>" . $ . "</td></tr>
			<tr><td>Judul</td><td>" . $ . "</td></tr>
			<tr><td>Waktu dan Lokasi</td><td>" . $ . "</td></tr>
			<tr><td>Dosen Pembimbing</td><td>" . $ . "</td></tr>
			<tr><td>Dosen Penguji</td><td>" . $ . "</td></tr>";
	}
	
	$conn = connectDatabase();
	$sql = "SELECT * FROM MAHASISWA WHERE username='" . $username . "'";
	$result = pg_query($conn, $sql);
	if (!$result) {
		die("Error in SQL query: " . pg_last_error());
	}
	if (pg_num_rows($result) != 0) {
		$data = pg_fetch_array($result);
		$npm = $data[0];
		$nama = $data[1];
		$password = $data[3];
		$email = $data[4];
		$emailAlternatif = $data[5];
		$telepon = $data[6];
		$notelp = $data[7];
	}
	*/
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<div id="title">
			<h1>Jadwal Sidang Mahasiswa <?php echo $nama; ?></h1>
			<?php include "navbar.php"; ?>
		</div>
		<table>
			<?php echo $roleData; ?>
		</table>
	</body>
</html>