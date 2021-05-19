<?php
	$conn = new mysqli('localhost', 'root', '', 'evoting');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>