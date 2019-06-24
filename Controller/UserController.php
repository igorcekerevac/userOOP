<?php

namespace Controller;

use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;

class UserController
{


    public function addUserPost()
    {
        $user = new User();

        $name = $user->name = htmlspecialchars(trim($_POST['name']));
        $job = $user->job = htmlspecialchars(trim($_POST['job']));
        $email = $user->email = htmlspecialchars(trim($_POST['email']));
        $password = $user->password =htmlspecialchars(trim($_POST['password']));

        $mailValidateFlag = 0;

        if (User::where('email', $email)) {

            $status = 'Entered email address already occupied!';
            $mailValidateFlag = 1;
        }


        if ($mailValidateFlag == 0) {

            if (!Functions::emailValidation($email)) {

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

        $data['status'] = $status;

        Functions::view('user/add_user',$data);
    }


    public function addUserGet()
    {
        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
            $data['status'] = $status;
            Functions::view('user/add_user',$data);
        } else {
            Functions::view('user/add_user');
        }
    }


    public function loginPost()
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

        $data['status'] = $status;
        Functions::view('user/login',$data);
    }


    public function loginGet()
    {
        session_start();

        Functions::view('user/login');
    }


    public function allTasks()
    {
        Functions::checkUser();

        $user = User::getById($_SESSION['user_id']);

        $data['allTasks'] = $user->getTasks();
        Functions::view('user/user_tasks',$data);
    }


    public function taskCommentsPost()
    {
        Functions::checkUser();

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


    public function taskCommentsGet()
    {
        Functions::checkUser();

        $task = Task::getById(htmlspecialchars($_GET['id']));

        $data['allPosts'] = $task->getPosts();
        $data['project'] = Project::getById($task->project_id);
        $data['task'] = $task;

        Functions::view('user/user_posts',$data);
    }


    public function showAll()
    {
        Functions::checkAdmin();

        $resultsPerPage = 4;

        $numberOfPages = Functions::numberOfPagesPagination($resultsPerPage, User::countAll());


        if (!isset($_GET['page'])) {

            $page = 1;

        } else {

            $page = $_GET['page'];
        }


        $thisPageFirstResult = Functions::thisPageFirstResult($page, $resultsPerPage);

        $all = User::getAllPagination($thisPageFirstResult, $resultsPerPage);

        $data['allUsers'] = Functions::populateUsersArray($all);

        Functions::view('user/user',$data);

        for ($page = 1; $page <= $numberOfPages; $page++) {

            echo '<a id="page" href="/users/page/?page=' . $page . '">page ' . $page . '</a>';
        }
    }


    public function delete()
    {
        Functions::checkAdmin();

        $user = User::getById(htmlspecialchars($_GET["id"]));

        if ($user->delete()) {

            $status = 'User deleted.';

        } else {

            $status = 'Can not delete! User have active tasks.';
        }

        $_SESSION['message'] = $status;

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }


    public function updatePost()
    {
        Functions::checkUser();

        $user = new User();

        $user_id = $user->user_id = $_SESSION['user_id'];
        $name = $user->name = htmlspecialchars(trim($_POST['name']));
        $job = $user->job = htmlspecialchars(trim($_POST['job']));
        $email = $user->email = htmlspecialchars(trim($_POST['email']));
        $password = $user->password = htmlspecialchars(trim($_POST['password']));

        $mailValidateFlag = 0;

        if ($user_found = User::where('email', $email)) {

            if ($user_found->email === $email && $user_id !== $user_found->user_id) {

                $status = 'Entered email address already occupied!';
                $mailValidateFlag = 1;
            }
        }

        if ($mailValidateFlag == 0) {

            if (!Functions::emailValidation($email)) {

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

        $data['status'] = $status;

        Functions::view('user/update_user',$data);
    }


    public function updateGet()
    {
        Functions::checkUser();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
            $data['status'] = $status;
            Functions::view('user/update_user',$data);
        } else {
            Functions::view('user/update_user');
        }
    }


    public function profile()
    {
        Functions::checkUser();

        $data['user'] = User::getById(htmlspecialchars($_GET["id"]));
        Functions::view('user/profile',$data);
    }


    public function employeeProfile()
    {
        Functions::checkAdmin();

        $user = User::getById(htmlspecialchars($_GET["id"]));

        $data['user'] = $user;
        $data['allTasks'] = $user->getTasks();
        Functions::view('user/employee_profile',$data);
    }


    public function logout()
    {
        session_start();
        session_destroy();
        $_SESSION = array();

        header("Location: /employee/login");
    }


    public function adminHome()
    {
        Functions::checkAdmin();

        Functions::view('user/home');
    }
}
