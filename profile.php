<?php 
	session_start();
	require "database.php";

	$username = $_SESSION['username'];
	$role = $_SESSION["role"];
	
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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<div id="title">
			<h1>Profil <?php echo $nama; ?></h1>
			<?php include "navbar.php"; ?>
		</div>
		<table>
			<tr>
				<td>NPM</td>
				<td><?php echo $npm; ?></td>
			</tr><tr>
				<td>Nama</td>
				<td><?php echo $nama; ?></td>
			</tr><tr>
				<td>Username</td>
				<td><?php echo $username; ?></td>
			</tr><tr>
				<td>Password</td>
				<td><?php echo $password; ?></td>
			</tr><tr>
				<td>E-mail</td>
				<td><?php echo $email; ?></td>
			</tr><tr>
				<td>E-mail Alternatif</td>
				<td><?php echo $emailAlternatif; ?></td>
			</tr><tr>
				<td>Telepon (HP)</td>
				<td><?php echo $telepon; ?></td>
			</tr><tr>
				<td>No. Telepon</td>
				<td><?php echo $notelp; ?></td>
			</tr>
		</table>
	</body>
</html>