<?php

namespace Controller;
use Model;
use Functions;


class TaskController
{

	public function createTask()
	{
		Functions\Functions::check_admin();

		$task = new model\Task();

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
		
		$user = new model\User();

		$all = $user->getUsers();

		$all_users = array();


		foreach ($all as $user) {
			
			if ($user['name'] !== 'admin') {
				
				array_push($all_users, $user);
			}
		}

		$project = new model\Project();

		$project->get_project($project_id);
		$name = $project->name;

		$all_tasks = $task->get_all_tasks($project_id);

        $client = $task->get_client_id($project_id);
        $client_id = $client['client_id'];


		include $_SERVER['DOCUMENT_ROOT'].'/view/task/add_task.php';

    }


    public function viewTask()
	{
		Functions\Functions::check_admin();

		$post = new model\Post();

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
			$post->users_id = $user_id;

			$post->create_post();

			header("Location: /client/project/task/?id=$task_id");
		}
		

		$task_id = htmlspecialchars($_GET["id"]);

		$task = new model\Task();

		$task->get_task($task_id);

		$name = $task->name;
		$user_id = $task->user_id;


		$post = new model\Post();
		$all_posts = $post->get_all_posts($task_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/task/task.php';

    }


}
