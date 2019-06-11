<?php

namespace Controller;
use Model;
use Functions;


class UserController
{


	public function create_user()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {


			$user = new model\User();

			$name = $user->name = trim($_POST['name']);
			$job = $user->job = trim($_POST['job']);
			$email = $user->email = trim($_POST['email']);
            $password = $user->password = trim($_POST['password']);
            $emails = $user->get_user_mail();

			$db_mail_validate = 0;

			foreach ($emails as $user_email) {
						
				if ($user_email['email'] === $email) {
		
					$status ='Entered email address alredy occupied!';
					$db_mail_validate = 1;
					break;
				}
			}

			if ($db_mail_validate==0) {
				
				if (!Functions\Functions::email_validation($email)) {

					$email = '';
				}

				if (empty($name) || empty($job) || empty($email) || empty($password)) {

					$status = 'Please enter data in all fields!';

				} else {

					$user->create();
					header("Location:/");
				}
			}	
		}	
	
		include $_SERVER['DOCUMENT_ROOT'].'/view/user/add_user.php';
    }


    public function login_user()
	{
		session_start();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$user = new model\User();

			$email = trim($_POST['email']);
            $password = trim($_POST['password']);


            $users = $user->get_all_users();

			$mail_check = 0;

			foreach ($users as $user) {
						
				if ($user['email'] === $email && $user['email'] !== 'admin@gmail.com' &&
                    password_verify($password, $user['password'])) {

				    $mail_check = 1;

					$user_id = $user['user_id'];
					$user_name = $user['name'];

					$_SESSION['user_id'] = $user_id;
					$_SESSION['name'] = $user_name;
                    $_SESSION['message'] = "message";


					header("Location: /employee?id=$user_id");

				} elseif ($email === 'admin@gmail.com' && password_verify($password, $user['password'])) {
					
					$admin_name = $user['name'];
					$admin_id = $user['user_id'];

					$_SESSION['admin_id'] = $admin_id;
					$_SESSION['admin_name'] = $admin_name;

					header("Location: /admin");
				}		
			} 

			if ($mail_check == 0) {

					$status ='Entered email or password is not in database.';
			}
		}

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/login.php';
    }


    public function user_tasks()
	{
		Functions\Functions::check_user();

		$user = new model\User();
		$task = new model\Task();

		$user_id = $_SESSION['user_id'];
		$user_name = $_SESSION['name'];


		$all_tasks = $task->get_user_tasks($user_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_tasks.php';
    }


    public function user_task_post()
	{
		Functions\Functions::check_user();

		$post = new model\Post();


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
			$post->users_id = $user_id;

			$post->create_post();
			header("Location: /employee/task?id=$task_id");
		}

		$task_id = htmlspecialchars($_GET['id']);
		
		$project = new model\Project();

		$task = new model\Task();
		
		$task->get_task($task_id);

		$task_name = $task->name;
		$project_id = $task->project_id;

		$project->get_project($project_id);
		$project_name = $project->name;

		$all_posts = $post->get_all_posts($task_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_posts.php';
    }


    public function all_users()
	{
		Functions\Functions::check_admin();
		
		$user = new model\User();

		$results_per_page = 4;

	    $numer_of_results = $user->count_all_users();

		$number_of_pages = ceil($numer_of_results/$results_per_page);


		if (!isset($_GET['page'])) {
	    	
	    	$page = 1;

	    } else {

	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all = $user->get_all_users_pagination($this_page_first_result,$results_per_page);

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


    public function delete_user()
	{
		Functions\Functions::check_admin();

		$delete_id = htmlspecialchars($_GET["id"]);
			
		$user = new model\User();

		if ($user->delete($delete_id)) {
		    $status = 'User deleted.';
        } else {
            $status = 'Can not delete! User have active tasks.';
        }

		$_SESSION['message'] = $status;

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }


    public function update_user()
	{
		
		Functions\Functions::check_user();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$user = new model\User();

			$update_id = $_SESSION['user_id'];
			$name = $user->name =trim($_POST['name']);
			$job = $user->job = trim($_POST['job']);
			$email = $user->email = trim($_POST['email']);
            $password = $user->password = trim($_POST['password']);

			$all = $user->get_all_users();

			$db_mail_validate = 0;
			foreach ($all as $users) {
						
				if ($users['email'] === $email && $update_id !== $users['user_id']) {
		
					$status ='Entered email address alredy occupied!';
					$db_mail_validate = 1;
					break;
				}
			}

			if ($db_mail_validate==0) {
				
				if (!Functions\Functions::email_validation($email)) {

					$email = '';
				}

				if (empty($name) || empty($job) || empty($email) || empty($password)) {

					$status = 'Please enter data in all fields!';

				} else {

                    $user->password = password_hash($password, PASSWORD_DEFAULT);

                    if ($user->user_update($update_id)) {
                        $_SESSION['message'] = 'User updated.';
                    } else {
                        $_SESSION['message'] = 'User is not updated.';
                    }

					$_SESSION['name'] = $name;

					header("Location: /user/update/?id=$update_id");
				}
			}	
		}	

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/update_user.php';
    }


    public function user_profile()
	{
		Functions\Functions::check_user();

		$user = new model\User();

		$find_id = htmlspecialchars($_GET["id"]);
		
		$user->get_user($find_id);

		$name = $user->name;
		$job = $user->job;
		$email = $user->email;

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/profile.php';
    }


    public function logout_user()
	{
		session_start();
		session_destroy();
		$_SESSION = array();

		header("Location: /employee/login");
    }


    public function admin_home()
	{
		Functions\Functions::check_admin();

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/home.php';
    }

    
}
