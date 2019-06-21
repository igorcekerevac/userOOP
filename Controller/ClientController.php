<?php

namespace Controller;

use Model\Client;
use Functions\Functions;

class ClientController
{

	public function showAll()
	{
		Functions::checkAdmin();

		$resultsPerPage = 5;

	    $numberOfResults = Client::countAll();

		$numberOfPages = ceil($numberOfResults/$resultsPerPage);


		if (!isset($_GET['page'])) {
	    	$page = 1;
	    } else {
	    	$page = $_GET['page'];
	    }


	    $thisPageFirstResult = ($page-1)*$resultsPerPage;

		$clients = Client::getAllPagination($thisPageFirstResult, $resultsPerPage);

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client.php';

		for ($page=1; $page<=$numberOfPages ; $page++) {
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function addClientPost()
    {
		Functions::checkAdmin();

		$client = new Client();
		$name = $client->name = htmlspecialchars(trim($_POST['name']));

		$nameValidationFlag = 0;


        if (Client::where('name', $name)) {

            $status = 'Client already in the database.';
            $nameValidationFlag = 1;
        }


		if ($nameValidationFlag==0) {

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

		$clientProjects = $client->getProjects();

		include $_SERVER['DOCUMENT_ROOT'].'/view/client/client_profile.php';		
    }

}
