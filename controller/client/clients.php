<?php
	

	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/client.php';
	
	$client = new Client($db);

	$results_per_page = 3;

    $numer_of_results = $client->countAll();


	$number_of_pages = ceil($numer_of_results/$results_per_page);

	if (!isset($_GET['page'])) {
    	$page = 1;

    }else{
    	$page = $_GET['page'];
    }


    $this_page_first_result = ($page-1)*$results_per_page;

	$all_clients = $client->getAllClients($this_page_first_result,$results_per_page);

	include $_SERVER['DOCUMENT_ROOT'].'/view/client.php';

	for ($page=1; $page<=$number_of_pages ; $page++) { 
    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    }

	



  
