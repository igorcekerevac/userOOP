<?php
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/project.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/task.php';

	$task = new Task($db);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$user_id = $_POST['user_id'];
		$task_name = $_POST['name'];
		$project_id = $_POST['project_id'];

		$task->name = $task_name;
		$task->project_id = $project_id;
		$task->user_id = $user_id;

		$task->create_task();
		header("Location: /client/project/task?id=$project_id");

	}

	$project_id = $_GET['id'];
	
	$user = new User($db);

	$all_users = $user->get_AllUsers();

	$project = new Project($db);

	$project->get_project($project_id);
	$name = $project->name;

	$all_tasks = $task->get_all_tasks($project_id);
	


	include $_SERVER['DOCUMENT_ROOT'].'/view/add_task.php';

?>

