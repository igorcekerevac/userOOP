<?php

	$request = $_SERVER['REQUEST_URI'];

	switch ($request) {
	    case '/' :
	        require __DIR__ . '/controller/user/users.php';
	        break;
	    case '' :
	        require __DIR__ . '/controller/user/users.php';
	        break; 
	    case '/create.php' :
	        require __DIR__ . '/controller/user/create.php';
	        break; 
	    case '/create' :
	        require __DIR__ . '/controller/user/create.php';
	        break;
	    default:
	        require __DIR__ . '/controller/user/users.php';
	        break;

	    }


