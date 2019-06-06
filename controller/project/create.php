<?php
	

	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/project.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$project = new Project($db);

		$name = $project->name = trim($_POST['name']);

		$names = $project->get_project_name();

		$db_name_validate = 0;

		$client_id = $_POST['id'];

		foreach ($names as $project_name) {
					
			if ($project_name['name'] === $name) {
	
				$status ='Project allready in the database.';
				$db_name_validate = 1;
				break;
			}
		}

		if ($db_name_validate==0) {

			if(empty($name)){
				$status = 'Please enter project name!';
			}else{
				$project->create($client_id);
				header("Location: /clients");
			}
	}	

		

	}	
	include $_SERVER['DOCUMENT_ROOT'].'/view/add_project.php';

	

	

	
