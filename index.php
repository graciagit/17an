<?php
	session_start();
	
	// Setup db connection
	require "database.php";
	
	// Simpan session ketika login valid
	$resp = "";
	if(isset($_POST["username"])){
		if(login($_POST["username"], $_POST["password"])){
			$resp = "login success";	
			$_SESSION["userlogin"] = $_POST["username"];
		} else {
			$resp = "invalid login";
		}
	}
	
	// Redirect page masing2 ketika session masih ada
	if (isset($_SESSION["userlogin"])) {
		if($_SESSION["role"]=="MHS")
			header("Location: jadwalSidang.php");
		elseif($_SESSION["role"]=="DOSEN")
			header("Location: jadwalSidang.php");
		elseif($_SESSION["role"]=="ADMIN")
			header("Location: jadwalSidang.php");
	}
	
	// Fungsi login
	function login($user, $pass){		
		$success = false;
		if($user == "admin" && $pass == "admin"){
			$_SESSION["username"] = $user;
			$_SESSION['role'] = "ADMIN";
			$_SESSION["nama"] = "Admin";
			$success = true;
			return $success;
		}

		$conn = connectDatabase();
		// query the database to return username and password existence
		$sqlMhs = "SELECT username, password, npm, nama FROM MAHASISWA WHERE username='$user' and password='$pass'";
		$sqlDosen = "SELECT username, password, nip, nama FROM DOSEN WHERE username='$user' and password='$pass'";
		$resultMhs = pg_query($conn, $sqlMhs);
		$resultDosen = pg_query($conn, $sqlDosen);
		if (!$resultMhs OR !$resultDosen) {
			die("Error in SQL query: " . pg_last_error());
		}
		
		if (pg_num_rows($resultMhs) != 0) {
			$field = pg_fetch_array($resultMhs);
			$_SESSION["username"] = $user;
			$_SESSION["role"] = "MHS";
			$_SESSION["npm"] = $field[2];
			$_SESSION["nama"] = $field[3];
			$success = true;
		}
		
		if (pg_num_rows($resultDosen) != 0) {
			$field = pg_fetch_array($resultDosen);
			$_SESSION["username"] = $user;
			$_SESSION["role"] = "DOSEN";
			$_SESSION["nip"] = $field[2];
			$_SESSION["nama"] = $field[3];
			$success = true;
		}
		
		pg_close($conn);
		return $success;		
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div id="log-in">
			<form method="POST" action="index.php">
				<label>Username: </label><input type="text" name="username" size="50"><br><br>
				<label>Password : </label><input type="password" name="password" size="50"><br><br>
				<input id="submission" type="submit" value="submit">
			</form>
			<?php echo $resp; ?>
		</div>
	</body>
</html>