<?php

	session_start();

	if (!isset($_SESSION['name'])) {
		header("Location: /employee/login");
	}

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/task.php';
	
	
	$user = new User($db);
	$task = new Task($db);

	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['name'];


	$all_tasks = $task->get_user_tasks($user_id);

	include $_SERVER['DOCUMENT_ROOT'].'/view/user_tasks.php';

?>

