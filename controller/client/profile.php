<?php

	
	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/client.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/project.php';
	
	$client = new Client($db);
	$project = new Project($db);

	$find_id = htmlspecialchars($_GET["id"]);
	
	$client->get_client($find_id);

	$name = $client->name;

	$found_projects = $project->get_project_client($find_id);


	include $_SERVER['DOCUMENT_ROOT'].'/view/client_profile.php';

?>

