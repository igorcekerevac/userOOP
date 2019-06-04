<?php
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$user = new User($db);

		$name = $user->name = trim($_POST['name']);
		$age = $user->age = trim($_POST['age']);
		$email = $user->email = trim($_POST['email']);

		$emails = $user->get_users_mail();

		$db_mail_validate = 0;

		foreach ($emails as $user_email) {
					
			if ($user_email['email'] === $email) {
	
				$status ='Entered email address alredy occupied! Enter new email address.';
				$db_mail_validate = 1;
				break;
			}
		}

		if ($db_mail_validate==0) {
			
			if(!Functions::email_validation($email)){
			$email = '';
			}

			if(empty($name) || empty($age) || empty($email)){
				$status = 'Please enter valid data!';
			}else{
				$user->create();
				header("Location: /users");
			}
	}	

		

	}	
	include $_SERVER['DOCUMENT_ROOT'].'/view/add_user.php';

	

	
