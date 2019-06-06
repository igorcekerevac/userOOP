<?php
	
	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
	
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/task.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/post.php';
	

	$task_id = htmlspecialchars($_GET["id"]);

	$task = new Task($db);

	$task->get_task($task_id);

	$name = $task->name;
	$user_id = $task->user_id;


	$post = new Post($db);
	$all_posts = $post->get_all_posts($task_id);



	include $_SERVER['DOCUMENT_ROOT'].'/view/task.php';

?>

