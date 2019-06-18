<?php


    spl_autoload_register(function ($class)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    });


    if (isset($_SERVER['REDIRECT_URL'])) {
        $request = $_SERVER['REDIRECT_URL'];
    } else {
        $request='';
    }


    switch ($request) {

        // user Controller


        case '/admin' :
            $user = new Controller\UserController();
            $user->admin_home();
            break;

        case '/' :
        case '':
            $user = new Controller\UserController();
            $user->create_user_get();
            break;

        case '/employee/login' :
            $user = new Controller\UserController();
            $user->login_user_get();
            break;

        case '/employee/login/post' :
            $user = new Controller\UserController();
            $user->login_user_post();
            break;

        case '/employee':
            $user = new Controller\UserController();
            $user->user_tasks();
            break;

        case '/employee/task':
            $user = new Controller\UserController();
            $user->user_task_post_get();
            break;

        case '/users' :
            $user = new Controller\UserController();
            $user->all_users();
            break;

        case '/delete' :
            $user = new Controller\UserController();
            $user->delete_user();
            break;

        case '/user/update/' :
            $user = new Controller\UserController();
            $user->update_user_get();
            break;

        case '/user/update/post' :
            $user = new Controller\UserController();
            $user->update_user_post();
            break;

        case '/user/profile/' :
            $user = new Controller\UserController();
            $user->user_profile();
            break;

        case '/employee/logout' :
            $user = new Controller\UserController();
            $user->logout_user();
            break;

        case '/users/page/delete' :
            $user = new Controller\UserController();
            $user->delete_user();
            break;

        case '/users/page/' :
            $user = new Controller\UserController();
            $user->all_users();
            break;

        case '/user/add' :
            $user = new Controller\UserController();
            $user->create_user_post();
            break;

        case '/employee/post/submit' :
            $user = new Controller\UserController();
            $user->user_task_post_post();
            break;


        // client Controller

        case '/clients' :
        case '/clients/page/' :
            $client = new Controller\ClientController();
            $client->all_clients();
            break;

        case '/client/create' :
            $client = new Controller\ClientController();
            $client->create_client_get();
            break;

        case '/client/create/post' :
            $client = new Controller\ClientController();
            $client->create_client_post();
            break;

        case '/client/' :
            $client = new Controller\ClientController();
            $client->client_profile();
            break;


        // project Controller

        case '/client/project/add/' :
            $project = new Controller\ProjectController();
            $project->create_project_get();
            break;

        case '/client/project/add/post' :
            $project = new Controller\ProjectController();
            $project->create_project_post();
            break;

        case '/projects' :
            $project = new Controller\ProjectController();
            $project->all_projects_get();
            break;

        case '/project/add/' :
            $project = new Controller\ProjectController();
            $project->all_project_add_project();
            break;


        // task Controller

        case '/client/project/task' :
            $task = new Controller\TaskController();
            $task->create_task_get();
            break;

        case '/client/project/post/' :
            $task = new Controller\TaskController();
            $task->create_task_post();
            break;

        case '/client/project/task/':
            $task = new Controller\TaskController();
            $task->view_task_get();
            break;

        case '/client/project/task/postComment' :
            $task = new Controller\TaskController();
            $task->view_task_post();
            break;

        case '/delete/task' :
            $task = new Controller\TaskController();
            $task->delete_task();
            break;


        //  default action on error url

        default:
            require __DIR__ . '/view/error.php';
            break;

    }

