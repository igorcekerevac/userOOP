<?php

namespace Controller;

use Model\PrivilegedUser;
use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;


class UserController extends Controller
{
    public function addUserPost()
    {
        $user = new User();

        $name = $user->name = htmlspecialchars(trim($this->request->post('name')));
        $job = $user->job = htmlspecialchars(trim($this->request->post('job')));
        $email = $user->email = htmlspecialchars(trim($this->request->post('email')));
        $password = $user->password =htmlspecialchars(trim($this->request->post('password')));

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
                    $addedUser = User::where('email', $email);
                    $addedUser->addRole();
                    $addedUser->addPermissions();
                    $this->redirectToPage('/?message=User added!');
                } else {
                    $status = 'User has not been saved.';
                }
            }
        }

        $data['status'] = $status;

        $this->view('user/add_user',$data);
    }


    public function addUserGet()
    {
        if (!empty($this->get)) {
            $status = $this->request->get('message');
            $data['status'] = $status;
            $this->view('user/add_user',$data);
        } else {
            $this->view('user/add_user');
        }
    }


    public function loginPost()
    {
        $email = htmlspecialchars(trim($this->request->post('email')));
        $password = htmlspecialchars(trim($this->request->post('password')));

        if ($user = User::where('email', $email)) {

            if ($user->email === $email && $user->email !== 'admin@gmail.com' &&
                password_verify($password, $user->password)) {

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['name'] = $user->name;

                $this->redirectToPage("/employee?id=$user->user_id");

            } elseif ($email === 'admin@gmail.com' && password_verify($password, $user->password)) {

                $_SESSION['admin_id'] = $user->user_id;
                $_SESSION['admin_name'] = $user->name;

                $privUser = new PrivilegedUser();

                $new = $privUser->getByEmail($email);
                var_dump($new);


     #           $this->redirectToPage('/admin');
            }
        }

        $status = 'Entered email or password is not in database.';

        $data['status'] = $status;
        $this->view('user/login',$data);
    }


    public function loginGet()
    {
        $this->view('user/login');
    }


    public function allTasks()
    {
        $this->checkCredentials('name');

        $user = User::getById($this->request->session('user_id'));

        $data['allTasks'] = $user->getTasks();
        $this->view('user/user_tasks',$data);
    }


    public function taskCommentsPost()
    {
        $this->checkCredentials('name');

        $post = new Post();

        $post->task_id = htmlspecialchars($this->request->post('task_id'));
        $post->title = $this->request->session('name');
        $post->body = htmlspecialchars($this->request->post('body'));
        date_default_timezone_set("Europe/Belgrade");
        $post->date = date("Y-m-d H:i:s");
        $post->users_id = $this->request->session('user_id');

        $post->save();
        $this->redirectToPreviousPage();
    }


    public function taskCommentsGet()
    {
        $this->checkCredentials('name');

        $task = Task::getById(htmlspecialchars($this->request->get('id')));

        $data['allPosts'] = $task->getPosts();
        $data['project'] = Project::getById($task->project_id);
        $data['task'] = $task;

        $this->view('user/user_posts',$data);
    }


    public function showAll()
    {
        $this->checkCredentials('admin_name');

        $resultsPerPage = 4;

        $numberOfPages = Functions::numberOfPagesPagination($resultsPerPage, User::countAll());


        if (empty($this->request->get)) {

            $page = 1;

        } else {

            $page = $this->request->get('page');
        }


        $thisPageFirstResult = Functions::thisPageFirstResult($page, $resultsPerPage);

        $all = User::getAllPagination($thisPageFirstResult, $resultsPerPage);

        $data['allUsers'] = Functions::allEmployees($all);

        $this->view('user/user',$data);

        for ($page = 1; $page <= $numberOfPages; $page++) {

            echo '<a id="page" href="/users/page/?page=' . $page . '">page ' . $page . '</a>';
        }
    }


    public function delete()
    {
        $this->checkCredentials('admin_name');

        $user = User::getById(htmlspecialchars($this->request->get("id")));

        if ($user->delete()) {

            $status = 'User deleted.';

        } else {

            $status = 'Can not delete! User have active tasks.';
        }

        $_SESSION['message'] = $status;

        $this->redirectToPreviousPage();
    }


    public function updatePost()
    {
        $this->checkCredentials('name');

        $user = new User();

        $user_id = $user->user_id = $this->request->session('user_id');
        $name = $user->name = htmlspecialchars(trim($this->request->post('name')));
        $job = $user->job = htmlspecialchars(trim($this->request->post('job')));
        $email = $user->email = htmlspecialchars(trim($this->request->post('email')));
        $password = $user->password = htmlspecialchars(trim($this->request->post('password')));

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
                    foreach ($user->getPosts() as $post) {
                        $post->title = $user->name;
                        $post->update();
                    }
                } else {
                    $message = 'User is not updated.';
                }

                $_SESSION['name'] = $name;

                $this->redirectToPage("/user/update/?message=$message");
            }
        }

        $data['status'] = $status;

        $this->view('user/update_user',$data);
    }


    public function updateGet()
    {
        $this->checkCredentials('name');

        $param = $this->request->get;

        if (isset($param['message'])) {
            $status = $this->request->get('message');
            $data['status'] = $status;
            $this->view('user/update_user',$data);
        } else {
            $this->view('user/update_user');
        }
    }


    public function profile()
    {
        $this->checkCredentials('name');

        $data['user'] = User::getById(htmlspecialchars($this->request->get('id')));
        $this->view('user/profile',$data);
    }


    public function employeeProfile()
    {
        $this->checkCredentials('admin_name');

        $user = User::getById(htmlspecialchars($this->request->get('id')));

        $data['user'] = $user;
        $data['allTasks'] = $user->getTasks();
        $this->view('user/employee_profile',$data);
    }


    public function logout()
    {
        session_destroy();
        $_SESSION = array();

        $this->redirectToPage('/employee/login');
    }


    public function adminHome()
    {
        $this->checkCredentials('admin_name');

        $this->view('user/home');
    }
}
