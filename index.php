<?php

	$request = $_SERVER['REQUEST_URI'];

    $query_string = $_SERVER['QUERY_STRING'];

	switch ($request) {
	    case '/' :
	        require __DIR__ . '/controller/user/create.php';
	        break;
	    case '' :
	        require __DIR__ . '/controller/user/create.php';
	        break; 
        case '/delete.php?'.$query_string :
            require __DIR__ . '/controller/user/delete.php';
            break; 
        case '/user/update/?'.$query_string :
            require __DIR__ . '/controller/user/update.php';
            break; 
        case '/users/page/delete.php?'.$query_string :
            require __DIR__ . '/controller/user/delete.php';
            break; 
        case '/users/page/?'.$query_string :
            require __DIR__ . '/controller/user/users.php';
            break; 
	    case '/user/create' :
	        require __DIR__ . '/controller/user/create.php';
	        break;
        case '/user/profile/?'.$query_string :
            require __DIR__ . '/controller/user/profile.php';
            break;
        case '/users' :
            require __DIR__ . '/controller/user/users.php';
            break;

        case '/clients' :
            require __DIR__ . '/controller/client/clients.php';
            break;
        case '/client/create' :
            require __DIR__ . '/controller/client/create.php';
            break;
        case '/clients/page/?'.$query_string :
            require __DIR__ . '/controller/client/clients.php';
            break; 
        case '/client/project/add/?'.$query_string :
            require __DIR__ . '/controller/project/create.php';
            break;
         case '/client/project/task?'.$query_string :
            require __DIR__ . '/controller/task/create.php';
            break;
       
        case '/client/project/task/?'.$query_string :
            require __DIR__ . '/controller/task/profile.php';
            break;
        case '/client/?'.$query_string :
            require __DIR__ . '/controller/client/profile.php';
            break;
        case '/employee/login' :
            require __DIR__ . '/controller/user/login.php';
            break;
        case '/employee/logout' :
            require __DIR__ . '/controller/user/logout.php';
            break;
        case '/employee/tasks' :
            require __DIR__ . '/controller/user/tasks.php';
            break;   

        case '/employee/task?'.$query_string :
            require __DIR__ . '/controller/user/posts.php';
            break;

        case '/employee/post/submit' :
            require __DIR__ . '/controller/user/posts.php';
            break; 
        case '/user/added' :
            require __DIR__ . '/controller/user/create.php';
            break; 

        case '/admin' :
            require __DIR__ . '/view/home.php';
            break; 
	    default:
	        require __DIR__ . '/view/error.php';
	        break;

	    }

