<?php

namespace Model;

use Db\Db;

class Project extends Model
{

	public $name;
	public $client_id;
	public $project_id;

    protected static $tableName = 'project';


    public function save(): bool
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "INSERT INTO project SET name = ?, client_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->client_id);

        return $stmt->execute();
    }

    public function getTasks(): array
    {
        $instance = Db::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT * FROM task where project_id= :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $this->project_id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Model\Task');

        $stmt->execute();

        return ($array = $stmt->fetchAll()) ? $array : array();
    }


    public static function getProjectsJoined(): array
    {
        foreach ($allClients = Client::getAll() as $client) {
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

        if (empty($allProjects)) {
            return array();
        } else {
            return $allProjects;
        }
    }
}

