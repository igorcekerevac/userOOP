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

        $client = Client::get_by_id(htmlspecialchars($_GET['id']));

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';	
    }


    public function create_project_post()
    {
        Functions::check_admin();

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($_POST['name']));

        $project->client_id = $_POST['id'];


        if (strlen($name) < 5) {

            $status = 'Project name must have 5 characters!';

        } else {

            $project->save();
            header("Location: /clients");
        }

        $_GET['id'] = $project->client_id;

        $client = Client::get_by_id($_GET['id']);

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


    public function all_project_post()
    {
        Functions::check_admin();

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($_POST['name']));

        $project->client_id = $_POST['id'];


        if (strlen($name) < 5 || $project->client_id === 'choose client') {

            $status = 'Please enter project name with minimum 5 characters and client name!';

        } else {

            $project->save();
            header("Location: /projects?message=Project added.");
        }

        $all_projects = Project::get_all_projects_join();

        $all_clients = Client::get_all();

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';
    }

}
