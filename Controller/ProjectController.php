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

        $db_name_validate = 0;

        $client_id = $_POST['id'];

        $project->client_id = $client_id;


        if (Project::check_column_value_exist('name')) {

            $status = 'Project already in the database.';
            $db_name_validate = 1;
        }


        if ($db_name_validate==0) {

            if (empty($name)) {

                $status = 'Please enter project name!';

            } else {

                $project->create();
                header("Location: /clients");
            }
        }

        $_GET['id'] = $client_id;

        include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';
    }


    public function all_projects()
	{
		Functions::check_admin();

		$all_projects = Project::get_all_projects_join();

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';

    }

}
