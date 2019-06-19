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
            $user->adminHome();
            break;

        case '/' :
        case '':
            $user = new Controller\UserController();
            $user->addUserGet();
            break;

        case '/employee/login' :
            $user = new Controller\UserController();
            $user->loginGet();
            break;

        case '/employee/login/post' :
            $user = new Controller\UserController();
            $user->loginPost();
            break;

        case '/employee':
            $user = new Controller\UserController();
            $user->allTasks();
            break;

        case '/employee/task':
            $user = new Controller\UserController();
            $user->taskCommentsGet();
            break;

        case '/users' :
            $user = new Controller\UserController();
            $user->showAll();
            break;

        case '/delete' :
            $user = new Controller\UserController();
            $user->delete();
            break;

        case '/user/update/' :
            $user = new Controller\UserController();
            $user->updateGet();
            break;

        case '/user/update/post' :
            $user = new Controller\UserController();
            $user->updatePost();
            break;

        case '/user/profile/' :
            $user = new Controller\UserController();
            $user->profile();
            break;

        case '/employee/logout' :
            $user = new Controller\UserController();
            $user->logout();
            break;

        case '/users/page/delete' :
            $user = new Controller\UserController();
            $user->delete();
            break;

        case '/users/page/' :
            $user = new Controller\UserController();
            $user->showAll();
            break;

        case '/user/add' :
            $user = new Controller\UserController();
            $user->addUserPost();
            break;

        case '/employee/post/submit' :
            $user = new Controller\UserController();
            $user->taskCommentsPost();
            break;


        // client Controller

        case '/clients' :
        case '/clients/page/' :
            $client = new Controller\ClientController();
            $client->showAll();
            break;

        case '/client/create' :
            $client = new Controller\ClientController();
            $client->addClientGet();
            break;

        case '/client/create/post' :
            $client = new Controller\ClientController();
            $client->addClientPost();
            break;

        case '/client/' :
            $client = new Controller\ClientController();
            $client->clientPage();
            break;


        // project Controller

        case '/client/project/add/' :
            $project = new Controller\ProjectController();
            $project->addProjectGet();
            break;

        case '/client/project/add/post' :
            $project = new Controller\ProjectController();
            $project->addProjectPost();
            break;

        case '/projects' :
            $project = new Controller\ProjectController();
            $project->showAllGet();
            break;

        case '/project/add/' :
            $project = new Controller\ProjectController();
            $project->showAllPost();
            break;


        // task Controller

        case '/client/project/task' :
            $task = new Controller\TaskController();
            $task->addTaskGet();
            break;

        case '/client/project/post/' :
            $task = new Controller\TaskController();
            $task->addTaskPost();
            break;

        case '/client/project/task/':
            $task = new Controller\TaskController();
            $task->taskCommentsGet();
            break;

        case '/client/project/task/postComment' :
            $task = new Controller\TaskController();
            $task->taskCommentsPost();
            break;

        case '/delete/task' :
            $task = new Controller\TaskController();
            $task->delete();
            break;


        //  default action on error url

        default:
            require __DIR__ . '/view/error.php';
            break;

    }

