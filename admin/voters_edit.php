<?php

use GuzzleHttp\Exception\GuzzleException;

include 'includes/session.php';

	if(isset($_POST['edit'])){
        //generate voters id & password
        $set = '1234567890';
        $set_passwd = '123456789abcdefghijklmnopqrstuvw!@#$%^&*()xyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $student_id = $_POST['student_id'];
        $set_passwd1 = substr(str_shuffle($set_passwd), 0, 8);

        $voter = substr(str_shuffle($set), 0, 8);
        $message = 'Dear '.$firstname.' '.$lastname.', Use the following credentials voter id='.$voter.' and password='.$set_passwd1.' to login to the system http://evoting.net to vote for your favourite candidates';

        $client = new GuzzleHttp\Client();
        try {
            $client->get('https://deywuro.com/api/sms?', [
                'verify' => false,
                'query' => [
                    'username' => 'majestysoft',
                    'password' => '!@Majesty@6611',
                    'destination' => $phone,
                    'source' => 'EVOTING',
                    'message' => $message
                ]
            ]);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

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