<?php

namespace Controller;

use Model\Client;
use Model\Project;

class ProjectController extends Controller
{

	public function addProjectGet()
    {
        $this->checkCredentials('admin_name');

        $client = Client::getById(htmlspecialchars($this->get('id')));

        $data['clientName'] = $client->name;

        $this->view('project/add_project', $data);
    }


    public function addProjectPost()
    {
        $this->checkCredentials('admin_name');

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($this->post('name')));

        $project->client_id = htmlspecialchars($this->post('id'));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_created = date("Y-m-d H:i:s");


        if (strlen($name) < 5) {

            $status = 'Project name must have 5 characters!';

        } else {

            $project->save();
            $this->redirectToPage('/client');
        }

        $_GET['id'] = $project->client_id;

        $client = Client::getById($this->get('id'));

        $data['clientName'] = $client->name;
        $data['status'] = $status;

        $this->view('project/add_project',$data);
    }


    public function showAllGet()
	{
        $this->checkCredentials('admin_name');

        if (!empty($this->get)) {
            $status = $this->get('message');
            $data['status'] = $status;
        }

        $data['allProjects'] = Project::getProjectsJoined();
		$data['allClients'] = Client::getAll();

		$this->view('project/all_projects',$data);
    }


    public function showAllPost()
    {
        $this->checkCredentials('admin_name');

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($this->post('name')));

        $project->client_id = htmlspecialchars($this->post('id'));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_created = date("Y-m-d H:i:s");


        if (strlen($name) < 5 || $project->client_id === 'choose client') {

            $status = 'Please enter project name with minimum 5 characters and client name!';

        } else {

            $project->save();
            header("Location: /projects?message=Project added.");
        }

        $data['allClients'] = Client::getAll();
        $data['allProjects'] = Project::getProjectsJoined();
        $data['status'] = $status;

        $this->view('project/all_projects',$data);
    }

    public function finishProjectPost()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->get('id')));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_finished = date("Y-m-d H:i:s");
        $project->status = 'finished';

        $project->update();

        $this->redirectToPreviousPage();
    }

    public function finishedProjectPage()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->get('id')));

        $data['project'] = $project;

        $this->view('project/finished_project',$data);
    }

}
