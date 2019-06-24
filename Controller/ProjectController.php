<?php

namespace Controller;

use Model\Client;
use Model\Project;
use Functions\Functions;
use Model\User;

class ProjectController
{

	public function addProjectGet()
    {
        Functions::checkAdmin();

        $client = Client::getById(htmlspecialchars($_GET['id']));

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';	
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

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';
    }


    public function showAllGet()
	{
		Functions::checkAdmin();

        if (!empty($_GET['message'])) {
            $status = $_GET['message'];
        }

		$allClients = Client::getAll();

		foreach ($allClients as $client) {

            $projects = $client->getProjects();

                foreach ($projects as $project) {

                    if ($project->name !== null) {
                        $tasks = $project->getTasks();

                        if (empty($tasks)) {
                            $allProjects[] = array('client_name' => $client->name,
                                'task_name' => null,
                                'project_name' => $project->name,
                                'project_id' => $project->project_id,
                                'task_id' => null,
                                'user_name' => null);
                        } else {
                            foreach ($tasks as $task) {

                                $user = User::getById($task->user_id);
                                $allProjects[] = array('client_name' => $client->name,
                                    'task_name' => $task->name,
                                    'project_name' => $project->name,
                                    'project_id' => $project->project_id,
                                    'task_id' => $task->task_id,
                                    'user_name' => $user->name);
                            }
                        }
                    }
                }
            }

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';
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

        $allProjects = Project::getAllJoined();

        $allClients = Client::getAll();

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';
    }

}
