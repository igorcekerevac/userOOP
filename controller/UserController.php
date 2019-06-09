<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

Functions::autoload_model();


class UserController
{


	public function createUser()
	{
		global $db;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$user = new User($db);

			$name = $user->name = trim($_POST['name']);
			$age = $user->age = trim($_POST['age']);
			$email = $user->email = trim($_POST['email']);

			$emails = $user->getUserMail();

			$db_mail_validate = 0;

			foreach ($emails as $user_email) {
						
				if ($user_email['email'] === $email) {
		
					$status ='Entered email address alredy occupied!';
					$db_mail_validate = 1;
					break;
				}
			}

			if ($db_mail_validate==0) {
				
				if (!Functions::email_validation($email)) {

					$email = '';
				}

				if (empty($name) || empty($age) || empty($email)) {

					$status = 'Please enter data in all fields!';

				} else {

					$user->create();
					header("Location:/");
					$status = 'User added!';
				}
			}	
		}	
	
		include $_SERVER['DOCUMENT_ROOT'].'/view/user/add_user.php';
    }


    public function loginUser()
	{
		session_start();

		global $db;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$user = new User($db);

			$email = trim($_POST['email']);

			$users = $user->getUsers();

			$mail_check = 0;

			foreach ($users as $user) {
						
				if ($user['email'] === $email && $user['email'] !== 'admin@gmail.com') {
					$mail_check = 1;

					$user_id = $user['user_id'];
					$user_name = $user['name'];

					$_SESSION['user_id'] = $user_id;
					$_SESSION['name'] = $user_name;

					header("Location: /employee?id=$user_id");

				} elseif ($user['email'] === 'admin@gmail.com' && $user['email'] === $email) {
					
					$admin_name = $user['name'];
					$admin_id = $user['user_id'];

					$_SESSION['admin_id'] = $admin_id;
					$_SESSION['admin_name'] = $admin_name;

					header("Location: /admin");
				}		
			} 

			if ($mail_check == 0) {

					$status ='Entered email address is not in database.';
			}
		}

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/login.php';
    }


    public function userTasks()
	{
		Functions::check_user();

		global $db;

		$user = new User($db);
		$task = new Task($db);

		$user_id = $_SESSION['user_id'];
		$user_name = $_SESSION['name'];


		$all_tasks = $task->get_user_tasks($user_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_tasks.php';
    }


    public function userTaskPosts()
	{
		Functions::check_user();

		global $db;

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

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_posts.php';
    }


    public function allUsers()
	{
		Functions::check_admin();

		global $db;
		
		$user = new User($db);

		$results_per_page = 3;

	    $numer_of_results = $user->countAll();

		$number_of_pages = ceil($numer_of_results/$results_per_page);


		if (!isset($_GET['page'])) {
	    	
	    	$page = 1;

	    } else {

	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all = $user->getAllUsers($this_page_first_result,$results_per_page);

		$all_users = array();


		foreach ($all as $user) {
			
			if ($user['name'] !== 'admin') {
				
				array_push($all_users, $user);
			}
		}


		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user.php';


		for ($page=1; $page<=$number_of_pages ; $page++) {

	    	echo '<a id="page" href="/users/page/?page=' .$page. '">page ' . $page . '</a>';
	    }
    }


    public function deleteUser()
	{
		Functions::check_admin();

		global $db;

		$delete_id = htmlspecialchars($_GET["id"]);
			
		$user = new User($db);
		$user->delete($delete_id);

		header("Location: /users");
    }


    public function updateUser()
	{
		
		Functions::check_user();
		global $db;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$user = new User($db);

			$update_id = $_SESSION['user_id'];
			$name = $user->name =trim($_POST['name']);
			$age = $user->age = trim($_POST['age']);
			$email = $user->email = trim($_POST['email']);

			$emails = $user->getUserMail();

			$db_mail_validate = 0;

			foreach ($emails as $user_email) {
						
				if ($user_email['email'] === $email) {
		
					$status ='Entered email address alredy occupied!';
					$db_mail_validate = 1;
					break;
				}
			}

			if ($db_mail_validate==0) {
				
				if (!Functions::email_validation($email)) {

					$email = '';
				}

				if (empty($name) || empty($age) || empty($email)) {

					$status = 'Please enter data in all fields!';

				} else {

					$user->update($update_id);
					$_SESSION['name'] = $name;
					
					header("Location: /user/update/?id=$update_id");
				}
			}	
		}	

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/update_user.php';
    }


    public function userProfile()
	{
		Functions::check_user();
		global $db;

		$user = new User($db);

		$find_id = htmlspecialchars($_GET["id"]);
		
		$user->getUser($find_id);

		$name = $user->name;
		$age = $user->age;
		$email = $user->email;

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/profile.php';
    }


    public function logoutUser()
	{
		session_start();
		session_destroy();
		$_SESSION = array();

		header("Location: /employee/login");
    }


    public function adminHome()
	{
		Functions::check_admin();

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/home.php';
    }

    
}
