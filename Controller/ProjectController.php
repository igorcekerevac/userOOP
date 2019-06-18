<?php

namespace Controller;

use Model\Client;
use Model\Project;
use Functions\Functions;

class ProjectController
{

	public function create_project_get()
    {
        Functions::check_admin();

        $client_name = Client::get_column_value($_GET['id'], 'name');

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';	
    }


    public function create_project_post()
    {
        Functions::check_admin();

        $project = new Project();

        $name = $project->name = trim($_POST['name']);

        $client_id = $_POST['id'];

        $project->client_id = $client_id;


        if (strlen($name) < 5) {

            $status = 'Project name must have 5 characters!';

        } else {

            $project->create();
            header("Location: /clients");
        }

        $_GET['id'] = $client_id;

        $client_name = Client::get_column_value($_GET['id'], 'name');

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';
    }


    public function all_projects_get()
	{
		Functions::check_admin();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

		$all_projects = Project::get_all_projects_join();

		$all_clients = Client::get_all();

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';

    }


    public function all_project_add_project()
    {
        Functions::check_admin();

        $project = new Project();

        $name = $project->name = trim($_POST['name']);

        $client_id = $_POST['id'];

        $project->client_id = $client_id;


        if (strlen($name) < 5 || $client_id === 'choose client') {

            $status = 'Please enter project name with minimum 5 characters and client name!';

        } else {

            $project->create();
            header("Location: /projects?message=Project added.");
        }

        $all_projects = Project::get_all_projects_join();

        $all_clients = Client::get_all();

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';
    }

}
