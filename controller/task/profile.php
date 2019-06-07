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
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';


	$post = new Post($db);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$task_id = $_POST['task_id'];
		$title = $_POST['title'];
		$body = $_POST['body'];
		$user_id = $_SESSION['admin_id'];
		$date = date("Y-m-d H:i:s");

		$post->task_id = $task_id;
		$post->title = $title;
		$post->body = $body;
		$post->date = $date;
		$post->user_id = $user_id;

		$post->create_post();

		header("Location: /client/project/task/?id=$task_id");
	}
	

	$task_id = htmlspecialchars($_GET["id"]);

	$task = new Task($db);

	$task->get_task($task_id);

	$name = $task->name;
	$user_id = $task->user_id;


	$post = new Post($db);
	$all_posts = $post->get_all_posts($task_id);



	include $_SERVER['DOCUMENT_ROOT'].'/view/task.php';

?>

