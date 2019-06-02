<?php
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	
	$user = new User($db);

	$results_per_page = 3;

    $numer_of_results = $user->countAll();


	$number_of_pages = ceil($numer_of_results/$results_per_page);

	if (!isset($_GET['page'])) {
    	$page = 1;

    }else{
    	$page = $_GET['page'];
    }


    $this_page_first_result = ($page-1)*$results_per_page;

	$all_users = $user->getAllUsers($this_page_first_result,$results_per_page);

	include $_SERVER['DOCUMENT_ROOT'].'/view/user.php';

	for ($page=1; $page<=$number_of_pages ; $page++) { 
    	echo '<a id="page" href="users.php?page=' .$page. '">page ' . $page . '</a>';
    }

	



  
