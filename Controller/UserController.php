<?php

namespace Controller;

use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;


class UserController
{


	public function create_user_post()
	{
        $user = new User();

        $name = $user->name = trim($_POST['name']);
        $job = $user->job = trim($_POST['job']);
        $email = $user->email = trim($_POST['email']);
        $password = $user->password = trim($_POST['password']);


        $db_mail_validate = 0;

        if (User::check_row_exists_where_column_value('email', $email)) {

            $status = 'Entered email address already occupied!';
            $db_mail_validate = 1;
        }


        if ($db_mail_validate == 0) {

            if (!Functions::email_validation($email)) {

                $email = '';
            }

            if (empty($name) || empty($job) || empty($email) || empty($password)) {

                $status = 'Please enter data in all fields!';

            } else {

                $user->create();

                header("Location:/?message=User added!");
            }
        }
        include $_SERVER['DOCUMENT_ROOT'].'/view/user/add_user.php';
    }


    public function create_user_get()
    {
        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/add_user.php';
    }



    public function login_user_post()
	{
		session_start();

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if ($user = User::check_row_exists_where_column_value('email', $email)) {

            if ($user->email === $email && $user->email !== 'admin@gmail.com' &&
                password_verify($password, $user->password)) {

                $user_id = $user->user_id;
                $user_name = $user->name;

                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $user_name;

                header("Location: /employee?id=$user_id");

            } elseif ($email === 'admin@gmail.com' && password_verify($password, $user->password)) {

                $admin_name = $user->name;
                $admin_id = $user->user_id;

                $_SESSION['admin_id'] = $admin_id;
                $_SESSION['admin_name'] = $admin_name;

                header("Location: /admin");
            }
        }

        $status = 'Entered email or password is not in database.';

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/login.php';
    }


    public function login_user_get()
    {
        session_start();

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/login.php';
    }



    public function user_tasks()
	{
		Functions::check_user();

        $all_tasks = Task::get_all_with_specific_id($_SESSION['user_id'], 'user');

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_tasks.php';
    }


    public function user_task_post_post()
	{
		Functions::check_user();

        $post = new Post();

        $task_id = $_POST['task_id'];
        $body = $_POST['body'];
        $user_id = $_SESSION['user_id'];
        $date = date("Y-m-d H:i:s");

        $post->task_id = $task_id;
        $post->title = $_SESSION['name'];
        $post->body = $body;
        $post->date = $date;
        $post->users_id = $user_id;

        $post->create_post();
        header("Location: /employee/task?id=$task_id");

    }


    public function user_task_post_get()
    {
        Functions::check_user();

        $task_id = htmlspecialchars($_GET['id']);

        $task = Task::get($task_id);

        $task_name = $task->name;
        $project_id = $task->project_id;

        $project_name = Project::get_column_value($project_id, 'name');

        $all_posts = Post::get_all_posts($task_id);

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/user_posts.php';
    }


    public function all_users()
	{
		Functions::check_admin();

		$results_per_page = 4;

	    $numer_of_results = User::count_all();

		$number_of_pages = ceil($numer_of_results/$results_per_page);


		if (!isset($_GET['page'])) {
	    	
	    	$page = 1;

	    } else {

	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all = User::get_all_pagination($this_page_first_result, $results_per_page);

		$all_users = Functions::populate_users_array_no_admin($all);


		include $_SERVER['DOCUMENT_ROOT'].'/view/user/user.php';


		for ($page=1; $page<=$number_of_pages ; $page++) {

	    	echo '<a id="page" href="/users/page/?page=' .$page. '">page ' . $page . '</a>';
	    }
    }


    public function delete_user()
	{
		Functions::check_admin();

		$delete_id = htmlspecialchars($_GET["id"]);

        $user = User::get($delete_id);


		if ($user->delete()) {

		    $status = 'User deleted.';

        } else {

            $status = 'Can not delete! User have active tasks.';
        }

		$_SESSION['message'] = $status;

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }


    public function update_user_post()
	{
		
		Functions::check_user();

        $user = new User();

        $update_id = $_SESSION['user_id'];
        $name = $user->name = trim($_POST['name']);
        $job = $user->job = trim($_POST['job']);
        $email = $user->email = trim($_POST['email']);
        $password = $user->password = trim($_POST['password']);

        $db_mail_validate = 0;

        if ($result = User::check_row_exists_where_column_value('email', $email)) {

            if ($result->email === $email && $update_id !== $result->user_id) {

                $status = 'Entered email address already occupied!';
                $db_mail_validate = 1;
            }
        }

        if ($db_mail_validate == 0) {

            if (!Functions::email_validation($email)) {

                $email = '';
            }

            if (empty($name) || empty($job) || empty($email) || empty($password)) {

                $status = 'Please enter data in all fields!';

            } else {

                $user->password = password_hash($password, PASSWORD_DEFAULT);

                if ($user->user_update($update_id)) {
                    $message = 'User updated.';
                } else {
                    $message = 'User is not updated.';
                }

                $_SESSION['name'] = $name;

                header("Location: /user/update/?message=$message");
            }
        }

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/update_user.php';
    }



    public function update_user_get()
    {
        Functions::check_user();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

        include $_SERVER['DOCUMENT_ROOT'].'/view/user/update_user.php';
    }



    public function user_profile()
	{
		Functions::check_user();

		$find_id = htmlspecialchars($_GET["id"]);
		
		$user = User::get($find_id);

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
		Functions::check_admin();

		include $_SERVER['DOCUMENT_ROOT'].'/view/user/home.php';
    }

    
}
