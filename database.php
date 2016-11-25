<?php
	function connectDatabase(){
		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=guelupa";
		$conn = pg_connect($conn_string);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . pg_last_error());
		}

		$sql = "SET search_path TO sisidang";
		$result = pg_query($conn, $sql);
		if (!$result) {
			die("Error in SQL query: " . pg_last_error());
		}   
		
		return $conn;
	}
?>
