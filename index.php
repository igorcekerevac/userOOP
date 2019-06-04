<?php

	$request = $_SERVER['REQUEST_URI'];

    $query_string = $_SERVER['QUERY_STRING'];

	switch ($request) {
	    case '/' :
	        require __DIR__ . '/view/home.php';
	        break;
	    case '' :
	        require __DIR__ . '/view/home.php';
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
	    default:
	        require __DIR__ . '/controller/user/users.php';
	        break;

	    }


