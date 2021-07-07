<?php
	include 'includes/session.php';

	$return = 'home.php';
	if(isset($_GET['return'])){
		$return = $_GET['return'];
	}

	if(isset($_POST['save'])){
		$title = $_POST['title'];
		$date = $_POST['date'];
		$desc = $_POST['desc'];

		$file = 'config.ini';
//		$content = 'election_title = '.$title;
//		$content = 'election_date = '.$date;
//		$content = 'election_desc = '.$desc;

		$content = [
		    'election_title' => $title,
		    'election_date' => $date,
		    'election_desc' => $desc,
        ];

		file_put_contents($file, $content);

		$_SESSION['success'] = 'Election title updated successfully';
		
	}
	else{
		$_SESSION['error'] = "Fill up config form first";
	}

	header('location: '.$return);

?>