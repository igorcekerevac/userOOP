<?php


    spl_autoload_register(function ($class)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    });


    $user = new Controller\UserController();
    $project = new Controller\ProjectController();
    $client = new Controller\ClientController();
    $task = new Controller\TaskController();

    if (isset($_SERVER['REDIRECT_URL'])) {
        $request = $_SERVER['REDIRECT_URL'];
    } else {
        $request='';
    }


    switch ($request) {

        // user Controller


        case '/admin' :
            $user->admin_home();
            break;

        case '/' :
            $user->create_user_get();
            break;

        case '' :
            $user->create_user_get();
            break;

        case '/employee/login' :
            $user->login_user_get();
            break;

        case '/employee/login/post' :
            $user->login_user_post();
            break;

        case '/employee':
            $user->user_tasks();
            break;

        case '/employee/task':
            $user->user_task_post_get();
            break;

        case '/users' :
            $user->all_users();
            break;

        case '/delete' :
            $user->delete_user();
            break;

        case '/user/update/' :
            $user->update_user_get();
            break;

        case '/user/update/post' :
            $user->update_user_post();
            break;

        case '/user/profile/' :
            $user->user_profile();
            break;

        case '/employee/logout' :
            $user->logout_user();
            break;

        case '/users/page/delete' :
            $user->delete_user();
            break;

        case '/users/page/' :
            $user->all_users();
            break;

        case '/user/add' :
            $user->create_user_post();
            break;

        case '/employee/post/submit' :
            $user->user_task_post_post();
            break;


        // client Controller

        case '/clients' :
            $client->all_clients();
            break;

        case '/client/create' :
            $client->create_client_get();
            break;

        case '/client/create/post' :
            $client->create_client_post();
            break;

        case '/client/' :
            $client->client_profile();
            break;

        case '/clients/page/' :
            $client->all_clients();
            break;


        // project Controller

        case '/client/project/add/' :
            $project->create_project_get();
            break;

        case '/client/project/add/post' :
            $project->create_project_post();
            break;

        case '/projects' :
            $project->all_projects();
            break;


        // task Controller

        case '/client/project/task' :
            $task->create_task_get();
            break;

        case '/client/project/post/' :
            $task->create_task_post();
            break;

        case '/client/project/task/':
            $task->view_task_get();
            break;

        case '/client/project/task/postComment' :
            $task->view_task_post();
            break;

        case '/delete/task' :
            $task->delete_task();
            break;


        //  default action on error url

        default:
            require __DIR__ . '/view/error.php';
            break;

    }

