<?php 
	
	session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$user = new User($db);

		$email = trim($_POST['email']);

		$users = $user->get_AllUsers();

		$mail_check = 0;

		foreach ($users as $user) {
					
			if ($user['email'] === $email && $user['email'] !== 'admin@gmail.com') {
				$mail_check = 1;

				$user_id = $user['user_id'];
				$user_name = $user['name'];

				$_SESSION['user_id'] = $user_id;
				$_SESSION['name'] = $user_name;

				header("Location: /employee?id=$user_id");

			}elseif($user['email'] === 'admin@gmail.com' && $user['email'] === $email){
				
				$admin_name = $user['name'];
				$admin_id = $user['user_id'];

				$_SESSION['admin_id'] = $admin_id;
				$_SESSION['admin_name'] = $admin_name;

				header("Location: /admin");
			}		
		}
		if ($mail_check == 0) {
				$status ='Entered email address is not in database. Enter new mail!';
			}
	}

	include $_SERVER['DOCUMENT_ROOT'].'/view/login.php';


	