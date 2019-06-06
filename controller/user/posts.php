<?php

	session_start();

	if (!isset($_SESSION['name'])) {
		header("Location: /employee/login");
	}

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/task.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/post.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/project.php';


	$post = new Post($db);


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$task_id = $_POST['task_id'];
		$title = $_POST['title'];
		$body = $_POST['body'];
		$user_id = $_SESSION['user_id'];
		$date = date("Y-m-d H:i:s");

		$post->task_id = $task_id;
		$post->title = $title;
		$post->body = $body;
		$post->date = $date;
		$post->user_id = $user_id;

		$post->create_post();
		header("Location: /employee/task?id=$task_id");
	}


	$task_id = htmlspecialchars($_GET['id']);
	
	$project = new Project($db);

	$task = new Task($db);
	
	$task->get_task($task_id);

	$task_name = $task->name;
	$project_id = $task->project_id;

	$project->get_project($project_id);
	$project_name = $project->name;

	$all_posts = $post->get_all_posts($task_id);

	if(!empty($_POST)){
	unset($_POST);}

	include $_SERVER['DOCUMENT_ROOT'].'/view/user_posts.php';

?>

