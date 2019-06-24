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

        $numberOfPages = Functions::numberOfPagesPagination($resultsPerPage, Client::countAll());


        if (!isset($_GET['page'])) {
	    	$page = 1;
	    } else {
	    	$page = $_GET['page'];
	    }

        $thisPageFirstResult = Functions::thisPageFirstResult($page, $resultsPerPage);

        $data['clients'] = Client::getAllPagination($thisPageFirstResult, $resultsPerPage);;
        Functions::view('client/client',$data);

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

        $data['status'] = $status;
        Functions::view('client/add_client',$data);

    }


    public function addClientGet()
    {
        Functions::checkAdmin();

        Functions::view('client/add_client');
    }



    public function clientPage()
    {
		Functions::checkAdmin();

		$client = Client::getById(htmlspecialchars($_GET["id"]));

        $data['clientProjects'] = $client->getProjects();
        $data['clientName'] = $client->name;

        Functions::view('client/client_profile',$data);
    }

}
