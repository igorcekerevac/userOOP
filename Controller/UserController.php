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

        $name = $user->name = htmlspecialchars(trim($_POST['name']));
        $job = $user->job = htmlspecialchars(trim($_POST['job']));
        $email = $user->email = htmlspecialchars(trim($_POST['email']));
        $password = $user->password =htmlspecialchars(trim($_POST['password']));

        $db_mail_validate = 0;

        if (User::where('email', $email)) {

            $status = 'Entered email address already occupied!';
            $db_mail_validate = 1;
        }


        if ($db_mail_validate == 0) {

            if (!Functions::email_validation($email)) {

                $email = '';
            }

            if (strlen($name) < 3 || empty($job) || empty($email) || empty($password)) {

                $status = 'Please enter data in all fields! Name must have more then two characters.';

            } else {

                if ($user->save()) {
                    header("Location:/?message=User added!");
                } else {
                    $status = 'User has not been saved.';
                }


            }
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/add_user.php';
    }


    public function create_user_get()
    {
        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/add_user.php';
    }


    public function login_user_post()
    {
        session_start();

        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        if ($user = User::where('email', $email)) {

            if ($user->email === $email && $user->email !== 'admin@gmail.com' &&
                password_verify($password, $user->password)) {

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['name'] = $user->name;

                header("Location: /employee?id=$user->user_id");

            } elseif ($email === 'admin@gmail.com' && password_verify($password, $user->password)) {

                $_SESSION['admin_id'] = $user->user_id;
                $_SESSION['admin_name'] = $user->name;

                header("Location: /admin");
            }
        }

        $status = 'Entered email or password is not in database.';

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/login.php';
    }


    public function login_user_get()
    {
        session_start();

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/login.php';
    }


    public function user_tasks()
    {
        Functions::check_user();

        $user = User::get_by_id($_SESSION['user_id']);

        $all_tasks = $user->get_all_tasks();

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/user_tasks.php';
    }


    public function user_task_comment_post()
    {
        Functions::check_user();

        $post = new Post();

        $post->task_id = htmlspecialchars($_POST['task_id']);
        $post->title = $_SESSION['name'];
        $post->body = htmlspecialchars($_POST['body']);
        date_default_timezone_set("Europe/Belgrade");
        $post->date = date("Y-m-d H:i:s");
        $post->users_id = $_SESSION['user_id'];

        $post->save();
        header("Location: /employee/task?id=$post->task_id");
    }


    public function user_task_comment_get()
    {
        Functions::check_user();

        $task = Task::get_by_id(htmlspecialchars($_GET['id']));

        $project = Project::get_by_id($task->project_id);

        $all_posts = $task->get_all_posts();

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/user_posts.php';
    }


    public function all_users()
    {
        Functions::check_admin();

        $results_per_page = 4;

        $numer_of_results = User::count_all();

        $number_of_pages = ceil($numer_of_results / $results_per_page);


        if (!isset($_GET['page'])) {

            $page = 1;

        } else {

            $page = $_GET['page'];
        }


        $this_page_first_result = ($page - 1) * $results_per_page;

        $all = User::get_all_pagination($this_page_first_result, $results_per_page);

        $all_users = Functions::populate_users_array_no_admin($all);


        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/user.php';


        for ($page = 1; $page <= $number_of_pages; $page++) {

            echo '<a id="page" href="/users/page/?page=' . $page . '">page ' . $page . '</a>';
        }
    }


    public function delete_user()
    {
        Functions::check_admin();

        $user = User::get_by_id(htmlspecialchars($_GET["id"]));

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

        $user_id = $user->user_id = $_SESSION['user_id'];
        $name = $user->name = htmlspecialchars(trim($_POST['name']));
        $job = $user->job = htmlspecialchars(trim($_POST['job']));
        $email = $user->email = htmlspecialchars(trim($_POST['email']));
        $password = $user->password = htmlspecialchars(trim($_POST['password']));

        $db_mail_validate = 0;

        if ($user_found = User::where('email', $email)) {

            if ($user_found->email === $email && $user_id !== $user_found->user_id) {

                $status = 'Entered email address already occupied!';
                $db_mail_validate = 1;
            }
        }

        if ($db_mail_validate == 0) {

            if (!Functions::email_validation($email)) {

                $email = '';
            }

            if (strlen($name) < 3 || empty($job) || empty($email) || empty($password)) {

                $status = 'Please enter data in all fields! Name must have more then two characters.';

            } else {

                $user->password = password_hash($password, PASSWORD_DEFAULT);

                if ($user->update()) {
                    $message = 'User updated.';
                } else {
                    $message = 'User is not updated.';
                }

                $_SESSION['name'] = $name;

                header("Location: /user/update/?message=$message");
            }
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/update_user.php';
    }


    public function update_user_get()
    {
        Functions::check_user();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/update_user.php';
    }


    public function user_profile()
    {
        Functions::check_user();

        $user = User::get_by_id(htmlspecialchars($_GET["id"]));

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/profile.php';
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

        include $_SERVER['DOCUMENT_ROOT'] . '/view/user/home.php';
    }


}
