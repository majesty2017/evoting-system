<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $student_id = $_POST['student_id'];
        $set_passwd1 = substr(str_shuffle($set_passwd), 0, 8);

		$sql = "SELECT * FROM voters WHERE id = $id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		if($password == $row['password']) {
			$password = $row['password'];
		}
		else{
			$password = password_hash($set_passwd1, PASSWORD_DEFAULT);
		}

		$sql = "UPDATE voters 
                SET firstname = '$firstname', lastname = '$lastname', phone = '$phone', student_id = '$student_id', password = '$password' 
                WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location: voters.php');

?>