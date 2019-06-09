<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

Functions::autoload_model();


class ClientController
{

	public function allClients()
	{
		Functions::check_admin();

		global $db;
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

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client.php';

		for ($page=1; $page<=$number_of_pages ; $page++) { 
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function createClient()
    {
		Functions::check_admin();

		global $db;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$client = new Client($db);
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
		include $_SERVER['DOCUMENT_ROOT'].'/view/client/add_client.php';	
    }


    public function clientProfile()
    {
		Functions::check_admin();

		global $db;
		$client = new Client($db);
		$project = new Project($db);

		$find_id = htmlspecialchars($_GET["id"]);
		
		$client->get_client($find_id);

		$name = $client->name;

		$found_projects = $project->get_project_client($find_id);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client_profile.php';		
    }

}
