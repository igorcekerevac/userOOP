<?php

namespace Model;

class Project extends Model
{
    public $dbConn;

	public $name;
	public $client_id;
	public $project_id;
    public $status = 'active';
    public $date_created;
    public $date_finished;

    protected static $tableName = 'project';


    public function __construct()
    {
        parent::__construct();
    }


    public function save(): bool
    {
        $sql = "INSERT INTO project SET name = ?, client_id = ?, status = ?, date_created = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->client_id);
        $stmt->bindParam(3, $this->status);
        $stmt->bindParam(4, $this->date_created);

        return $stmt->execute();
    }

    public function getTasks(): array
    {
        $sql = "SELECT * FROM task where project_id= :id";

        $stmt = $this->dbConn->prepare($sql);
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
                                                    'user_name' => null,
                                                    'status' =>$project->status);
                        } else {

                            foreach ($tasks as $task) {
                                $user = $task->getUser();
                                $allProjects[] = array('client_name' => $client->name,
                                                        'task_name' => $task->name,
                                                        'project_name' => $project->name,
                                                        'project_id' => $project->project_id,
                                                        'task_id' => $task->task_id,
                                                        'user_name' => $user->name,
                                                        'status' =>$project->status);

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

    public function update(): bool
    {
        $sql = "UPDATE project SET date_finished = :date_finished, status = :status WHERE project_id = :id";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':date_finished', $this->date_finished);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->project_id);

        return $stmt->execute();
    }

    public function saveUserProject(int $user_id): bool
    {
        $sql = "INSERT INTO user_project SET project_id = :project_id, user_id = :user_id";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bindParam(':project_id', $this->project_id);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }

    public function deleteUserProject(int $user_id): bool
    {
        $sql = "DELETE FROM user_project WHERE user_id = :user_id and project_id = :project_id ";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':project_id', $this->project_id);

        return $stmt->execute();
    }


    public function getUsers(): array
    {
        $sql = "SELECT user_id FROM user_project WHERE project_id = :project_id";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':project_id', $this->project_id);

        $stmt->execute();

        $allUsers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];
        foreach ($allUsers as $user) {
            $users[] = User::getById($user['user_id']);
        }
        return (!empty($users)) ? $users : array();
    }
}

