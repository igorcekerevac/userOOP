<?php
	

	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/client.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$client = new Client($db);

		$name = $client->name = trim($_POST['name']);

		$names = $client->get_client_name();

		$db_name_validate = 0;

		foreach ($names as $client_name) {
					
			if ($client_name['name'] === $name) {
	
				$status ='Client allready in the database.';
				$db_name_validate = 1;
				break;
			}
		}

		if ($db_name_validate==0) {

			if(empty($name)){
				$status = 'Please enter client name!';
			}else{
				$client->create();
				header("Location: /clients");
			}
	}	

		

	}	
	include $_SERVER['DOCUMENT_ROOT'].'/view/add_client.php';

	

	
