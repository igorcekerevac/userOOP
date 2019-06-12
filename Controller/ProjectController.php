<?php

namespace Controller;

use Model\Project;
use Functions\Functions;


class ProjectController
{

	public function create_project_get()
    {
        Functions::check_admin();

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';	
    }


    public function create_project_post()
    {
        Functions::check_admin();

        $project = new Project();

        $name = $project->name = trim($_POST['name']);

        $names = Project::get_projects_names();

        $db_name_validate = 0;

        $client_id = $_POST['id'];

        foreach ($names as $project_name) {

            if ($project_name['name'] === $name) {

                $status ='Project allready in the database.';
                $db_name_validate = 1;
                break;
            }
        }

        if ($db_name_validate==0) {

            if (empty($name)) {

                $status = 'Please enter project name!';

            } else {

                $project->create($client_id);
                header("Location: /clients");
            }
        }
    }


    public function all_projects()
	{
		Functions::check_admin();

		$all_projects = Project::get_all_projects_join();

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';

    }

}
