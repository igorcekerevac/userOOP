<?php


    spl_autoload_register(function ($class)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    });


    $user = new controller\UserController();
    $project = new controller\ProjectController();
    $client = new controller\ClientController();
    $task = new controller\TaskController();

    $request = $_SERVER['REQUEST_URI'];
    $query_string = $_SERVER['QUERY_STRING'];


    switch ($request) {

        // user controller


        case '/admin' :
            $user->adminHome();
            break;

        case '/' :
            $user->createUser();
            break;

        case '' :
            $user->createUser();
            break;

        case '/employee/login' :
            $user->loginUser();
            break;

        case '/employee?' . $query_string :
            $user->userTasks();
            break;

        case '/employee/task?' . $query_string :
            $user->userTaskPosts();
            break;

        case '/users' :
            $user->allUsers();
            break;

        case '/delete.php?' . $query_string :
            $user->deleteUser();
            break;

        case '/user/update/?' . $query_string :
            $user->updateUser();
            break;

        case '/user/profile/?' . $query_string :
            $user->userProfile();
            break;

        case '/employee/logout' :
            $user->logoutUser();
            break;

        case '/user/added' :
            $user->createUser();
            break;

        case '/users/page/delete.php?' . $query_string :
            $user->deleteUser();
            break;

        case '/users/page/?' . $query_string :
            $user->allUsers();
            break;

        case '/user/create' :
            $user->createUser();
            break;

        case '/user/add' :
            $user->createUser();
            break;

        case '/employee/post/submit' :
            $user->userTaskPosts();
            break;


        // client controller

        case '/clients' :
            $client->allClients();
            break;

        case '/client/create' :
            $client->createClient();
            break;

        case '/client/?' . $query_string :
            $client->clientProfile();
            break;

        case '/clients/page/?' . $query_string :
            $client->allClients();
            break;


        // project controller

        case '/client/project/add/?' . $query_string :
            $project->createProject();
            break;

        case '/projects' :
            $project->allProjects();
            break;


        // task controller

        case '/client/project/task?' . $query_string :
            $task->createTask();
            break;

        case '/client/project/task/?' . $query_string :
            $task->viewTask();
            break;

        case '/employee/post/sub' :
            $task->viewTask();
            break;


        //  default action on error url

        default:
            require __DIR__ . '/view/error.php';
            break;

    }

