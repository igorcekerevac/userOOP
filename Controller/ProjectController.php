<?php

namespace Controller;

use Functions\Functions;
use Model\Client;
use Model\Project;
use Model\User;

class ProjectController extends Controller
{

	public function addProjectGet()
    {
        $this->checkCredentials('admin_name');

        $client = Client::getById(htmlspecialchars($this->request->get('id')));

        $data['clientName'] = $client->name;

        $this->view('project/add_project', $data);
    }


    public function addProjectPost()
    {
        $this->checkCredentials('admin_name');

        $project = new Project();

        $name = $project->name = htmlspecialchars(trim($this->request->post('name')));

        $project->client_id = htmlspecialchars($this->request->post('id'));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_created = date("Y-m-d H:i:s");


        if (strlen($name) < 5) {

            $status = 'Project name must have 5 characters!';

        } else {

            $project->save();
            $this->redirectToPage('/client');
        }

        $_GET['id'] = $project->client_id;

        $client = Client::getById($this->request->get('id'));

        $data['clientName'] = $client->name;
        $data['status'] = $status;

        $this->view('project/add_project',$data);
    }


    public function showAllGet()
	{
        $this->checkCredentials('admin_name');

        if (!empty($this->request->get)) {
            $status = $this->request->get('message');
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

        $name = $project->name = htmlspecialchars(trim($this->request->post('name')));

        $project->client_id = htmlspecialchars($this->request->post('id'));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_created = date("Y-m-d H:i:s");


        if (strlen($name) < 5 || $project->client_id === 'choose client') {

            $status = 'Please enter project name with minimum 5 characters and client name!';

        } else {

            $project->save();
            $this->redirectToPage('/projects?message=Project added.');
        }

        $data['allClients'] = Client::getAll();
        $data['allProjects'] = Project::getProjectsJoined();
        $data['status'] = $status;

        $this->view('project/all_projects',$data);
    }

    public function finishProjectPost()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->request->get('id')));

        date_default_timezone_set("Europe/Belgrade");
        $project->date_finished = date("Y-m-d H:i:s");
        $project->status = 'finished';

        $project->update();

        $this->redirectToPage('/projects');
    }

    public function finishedProjectPage()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->request->get('id')));

        $data['project'] = $project;

        $this->view('project/finished_project',$data);
    }

    public function projectPageGet()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->request->get('id')));

        $allEmployees = Functions::allEmployees(User::getAll());
        $employeesOnProject = $project->getUsers();

        $availableEmployees = Functions::availableEmployees($allEmployees, $employeesOnProject);

        $data['employeesOnProject'] = $employeesOnProject;
        $data['project'] = $project;
        $data['availableEmployees'] = $availableEmployees;
        $data['allTasks'] = $project->getTasks();
        $data['client'] = Client::getById($project->client_id);

        $this->view('project/project',$data);
    }

    public function projectPageAddUserPost()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById(htmlspecialchars($this->request->post('project_id')));;

        if ($this->request->post('id') !== 'choose user') {
            $project->saveUserProject(htmlspecialchars($this->request->post('id')));
        }

        $this->redirectToPreviousPage();
    }

}
