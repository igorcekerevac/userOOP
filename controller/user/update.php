<?php 

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$user = new User($db);

		$update_id = $_POST['id'];
		$name = $user->name =trim($_POST['name']);
		$age = $user->age = trim($_POST['age']);
		$email = $user->email = trim($_POST['email']);

		if(!Functions::email_validation($email)){
			$email = '';
		}

		if(empty($name) || empty($age) || empty($email)){
			$status = 'Please enter valid data!';
		}else{
			$user->update($update_id);
			header("Location: /users");
		}
	}

	include $_SERVER['DOCUMENT_ROOT'].'/view/update_user.php';

