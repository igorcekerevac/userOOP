<?php

namespace Controller;
use Model;
use Functions;


class ProjectController
{

	public function createProject()
    {
        Functions\Functions::check_admin();


		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$project = new model\Project();

			$name = $project->name = trim($_POST['name']);

			$names = $project->get_project_name();

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
		
		include $_SERVER['DOCUMENT_ROOT'].'/view/project/add_project.php';	
    }

    public function allProjects()
	{
		Functions\Functions::check_admin();


		$project = new model\Project();
		$all_projects = $project->get_all_projects_join();

		include $_SERVER['DOCUMENT_ROOT'].'/view/project/all_projects.php';

    }

}