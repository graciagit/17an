<?php 
	session_start();
	require "database.php";

	$username = $_SESSION['username'];
	$role = $_SESSION["role"];
	
	
?>