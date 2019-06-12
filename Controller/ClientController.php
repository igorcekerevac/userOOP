<?php

namespace Controller;

use Model\Client;
use Model\Project;
use Functions\Functions;



class ClientController
{

	public function all_clients()
	{
		Functions::check_admin();

		$results_per_page = 3;

	    $numer_of_results = Client::count_all();

		$number_of_pages = ceil($numer_of_results/$results_per_page);

		if (!isset($_GET['page'])) {
	    	$page = 1;

	    }else{
	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all_clients = Client::get_all_clients_pagination($this_page_first_result,$results_per_page);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client.php';

		for ($page=1; $page<=$number_of_pages ; $page++) { 
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function create_client_post()
    {
		Functions::check_admin();


		$client = new Client();
		$name = $client->name = trim($_POST['name']);
		$names = $client->get_client_name();
		$db_name_validate = 0;

		foreach ($names as $client_name) {
					
		    if ($client_name['name'] === $name) {
	
		        $status ='Client allready in the database.';
		        $db_name_validate = 1;
		        break;
		    }
		}

		if ($db_name_validate==0) {

		    if (empty($name)) {

		        $status = 'Please enter client name!';

		    } else {

		        $client->create();
		        header("Location: /clients");
		    }
		}
    }


    public function create_client_get()
    {
        Functions::check_admin();

        include $_SERVER['DOCUMENT_ROOT'].'/view/client/add_client.php';
    }


    public function client_profile()
    {
		Functions::check_admin();

		$find_id = htmlspecialchars($_GET["id"]);
		
		$name = Client::get_client($find_id);

		$found_projects = Project::get_project_client($find_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client_profile.php';		
    }

}
