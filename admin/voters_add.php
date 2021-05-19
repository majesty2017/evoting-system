<?php

use GuzzleHttp\Exception\GuzzleException;

include 'includes/session.php';
	include '../vendor/autoload.php';

	if(isset($_POST['add'])){
        //generate voters id & password
        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $set_passwd = '123456789abcdefghijklmnopqrstuvw!@#$%^&*()xyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$student_id = $_POST['student_id'];
		$set_passwd1 = substr(str_shuffle($set_passwd), 0, 8);
		$password = password_hash($set_passwd1, PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
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

        $sql = "INSERT INTO voters (voters_id, password, firstname, lastname, phone, student_id, photo) 
        VALUES ('$voter', '$password', '$firstname', '$lastname', '$phone', '$student_id', '$filename')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: voters.php');
