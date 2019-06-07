<?php

	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/project.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';

	$project = new Project($db);
	$all_projects = $project->get_all_projects_join();


	include $_SERVER['DOCUMENT_ROOT'].'/view/all_projects.php';