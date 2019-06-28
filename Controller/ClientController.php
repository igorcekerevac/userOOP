<?php

namespace Controller;

use Model\Client;
use Functions\Functions;
use Model\User;

class ClientController extends Controller
{

	public function showAll()
	{
        $this->checkCredentials('admin_name');

		$resultsPerPage = 5;

        $numberOfPages = Functions::numberOfPagesPagination($resultsPerPage, Client::countAll());


        if (empty($this->request->get)) {
	    	$page = 1;
	    } else {
	    	$page = $this->request->get('page');
	    }

        $thisPageFirstResult = Functions::thisPageFirstResult($page, $resultsPerPage);

        $data['clients'] = Client::getAllPagination($thisPageFirstResult, $resultsPerPage);;
        $this->view('client/client',$data);

		for ($page=1; $page<=$numberOfPages ; $page++) {
	    	echo '<a id="page" href="/clients/page/?page=' .$page. '">page ' . $page . '</a>';
    	}
    }


    public function addClientPost()
    {
        $this->checkCredentials('admin_name');

		$client = new Client();
		$user = new User();

		$name = $user->name = htmlspecialchars(trim($this->request->post('name')));
        $email = $user->email = htmlspecialchars(trim($this->request->post('email')));
        $user->password = htmlspecialchars(trim($this->request->post('password')));

		$nameValidationFlag = 0;


        if (Client::where('name', $name)) {

            $status = 'Client already in the database.';
            $nameValidationFlag = 1;
        }

		if ($nameValidationFlag==0) {

		    if (empty($name)) {

		        $status = 'Please enter client name!';

		    } else {

		        $user->save();
		        $obj = User::where('email',$email);
		        $client->name = $name;
		        $client->user_id = $obj->user_id;
		        $client->save();
		        $client->addRole();
		        $client->addPermissions();
		        $this->redirectToPage('/clients');
		    }
		}

        $data['status'] = $status;
        $this->view('client/add_client',$data);

    }


    public function addClientGet()
    {
        $this->checkCredentials('admin_name');

        $this->view('client/add_client');
    }



    public function clientPage()
    {
        $this->checkCredentials('admin_name');

		$client = Client::getById(htmlspecialchars($this->request->get('id')));

        $data['clientProjects'] = $client->getProjects();
        $data['clientName'] = $client->name;

        $this->view('client/client_profile',$data);
    }

}
