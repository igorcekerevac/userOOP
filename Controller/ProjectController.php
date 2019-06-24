<?php

namespace Controller;

use Model\Client;
use Model\Project;
use Functions\Functions;

class ProjectController
{

	public function addProjectGet()
    {
        Functions::checkAdmin();

        $client = Client::getById(htmlspecialchars($_GET['id']));

        $data['clientName'] = $client->name;

        Functions::view('project/add_project',$data);
    }


    public function addProjectPost()
    {
        Functions::checkAdmin();

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

        $client = Client::getById($_GET['id']);

        $data['clientName'] = $client->name;
        $data['status'] = $status;

        Functions::view('project/add_project',$data);
    }


    public function showAllGet()
	{
		Functions::checkAdmin();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
            $data['status'] = $status;
        }

        $data['allProjects'] = Project::getProjectsJoined();
		$data['allClients'] = Client::getAll();

		Functions::view('project/all_projects',$data);
    }


    public function showAllPost()
    {
        Functions::checkAdmin();

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($_POST['name']));

        $project->client_id = $_POST['id'];


        if (strlen($name) < 5 || $project->client_id === 'choose client') {

            $status = 'Please enter project name with minimum 5 characters and client name!';

        } else {

            $project->save();
            header("Location: /projects?message=Project added.");
        }

        $data['allClients'] = Client::getAll();
        $data['allProjects'] = Project::getProjectsJoined();
        $data['status'] = $status;

        Functions::view('project/all_projects',$data);
    }

}
