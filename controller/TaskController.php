<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

Functions::autoload_model();


class TaskController
{

	public function createTask()
	{
		Functions::check_admin();

		global $db;
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

		$all = $user->getUsers();

		$all_users = array();


		foreach ($all as $user) {
			
			if ($user['name'] !== 'admin') {
				
				array_push($all_users, $user);
			}
		}

		$project = new Project($db);

		$project->get_project($project_id);
		$name = $project->name;

		$all_tasks = $task->get_all_tasks($project_id);


		include $_SERVER['DOCUMENT_ROOT'].'/view/task/add_task.php';

    }


    public function viewTask()
	{
		Functions::check_admin();

		global $db;
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

		include $_SERVER['DOCUMENT_ROOT'].'/view/task/task.php';

    }


}
