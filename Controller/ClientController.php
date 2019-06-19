<?php

namespace Controller;

use Model\Client;
use Functions\Functions;

class ClientController
{

	public function all_clients()
	{
		Functions::check_admin();

		$results_per_page = 5;

	    $numer_of_results = Client::count_all();

		$number_of_pages = ceil($numer_of_results/$results_per_page);


		if (!isset($_GET['page'])) {
	    	$page = 1;
	    } else {
	    	$page = $_GET['page'];
	    }


	    $this_page_first_result = ($page-1)*$results_per_page;

		$all_clients = Client::get_all_pagination($this_page_first_result, $results_per_page);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client.php';

		for ($page=1; $page<=$number_of_pages ; $page++) {
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function create_client_post()
    {
		Functions::check_admin();

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


    public function create_client_get()
    {
        Functions::check_admin();

        include $_SERVER['DOCUMENT_ROOT'].'/view/client/add_client.php';
    }



    public function client_profile()
    {
		Functions::check_admin();

		$client = Client::get_by_id(htmlspecialchars($_GET["id"]));

		$client_projects = $client->get_all_projects();

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client_profile.php';		
    }

}
