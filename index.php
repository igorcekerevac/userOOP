<?php


    spl_autoload_register(function ($class)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', $class) . '.php';
    });


    $user = new Controller\UserController();
    $project = new Controller\ProjectController();
    $client = new Controller\ClientController();
    $task = new Controller\TaskController();

    if(isset($_SERVER['REDIRECT_URL']))
        $request = $_SERVER['REDIRECT_URL'];
    else $request='';



    switch ($request) {

        // user Controller


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

        case '/employee':
            $user->userTasks();
            break;

        case '/employee/task':
            $user->userTaskPosts();
            break;

        case '/users' :
            $user->allUsers();
            break;

        case '/delete' :
            $user->deleteUser();
            break;

        case '/user/update/' :
            $user->updateUser();
            break;

        case '/user/profile/' :
            $user->userProfile();
            break;

        case '/employee/logout' :
            $user->logoutUser();
            break;

        case '/user/added' :
            $user->createUser();
            break;

        case '/users/page/delete' :
            $user->deleteUser();
            break;

        case '/users/page/' :
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


        // client Controller

        case '/clients' :
            $client->allClients();
            break;

        case '/client/create' :
            $client->createClient();
            break;

        case '/client/' :
            $client->clientProfile();
            break;

        case '/clients/page/' :
            $client->allClients();
            break;


        // project Controller

        case '/client/project/add/' :
            $project->createProject();
            break;

        case '/projects' :
            $project->allProjects();
            break;


        // task Controller

        case '/client/project/task' :
            $task->createTask();
            break;

        case '/client/project/task/':
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

