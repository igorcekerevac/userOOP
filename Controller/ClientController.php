<?php

namespace Controller;

use Model\Client;
use Functions\Functions;

class ClientController
{

	public function showAll()
	{
		Functions::checkAdmin();

		$results_per_page = 5;

	    $numer_of_results = Client::countAll();

		$number_of_pages = ceil($numer_of_results/$results_per_page);


		if (!isset($_GET['page'])) {
	    	$page = 1;
	    } else {
	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all_clients = Client::getAllPagination($this_page_first_result, $results_per_page);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client.php';

		for ($page=1; $page<=$number_of_pages ; $page++) {
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function addClientPost()
    {
		Functions::checkAdmin();

		$client = new Client();
		$name = $client->name = htmlspecialchars(trim($_POST['name']));

		$db_name_validate = 0;


        if (Client::where('name', $name)) {

            $status = 'Client already in the database.';
            $db_name_validate = 1;
        }


		if ($db_name_validate==0) {

		    if (empty($name)) {

		        $status = 'Please enter client name!';

		    } else {

		        $client->save();
		        header("Location: /clients");
		    }
		}
        include $_SERVER['DOCUMENT_ROOT'].'/view/client/add_client.php';
    }


    public function addClientGet()
    {
        Functions::checkAdmin();

        include $_SERVER['DOCUMENT_ROOT'].'/view/client/add_client.php';
    }



    public function clientPage()
    {
		Functions::checkAdmin();

		$client = Client::getById(htmlspecialchars($_GET["id"]));

		$client_projects = $client->getAllProjects();

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client_profile.php';		
    }

}
