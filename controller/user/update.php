<?php 

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$user = new User($db);

		$update_id = $_POST['id'];
		$user->name =trim($_POST['name']);
		$user->age = trim($_POST['age']);
		$user->email = trim($_POST['email']);

		$user->update($update_id);
	}

	include $_SERVER['DOCUMENT_ROOT'].'/view/update_user.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		header("Location: users.php");
	}
