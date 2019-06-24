<?php

namespace Controller;

use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;
use Model\UserProject;

class TaskController
{

    public function addTaskGet()
    {
        Functions::checkAdmin();

        $project = Project::getById($_GET['id']);
        $users = User::getAll();

        $data['allUsers'] = Functions::populateUsersArray($users);
        $data['allTasks'] = $project->getTasks();
        $data['project'] = $project;

        Functions::view('task/add_task',$data);
    }


    public function addTaskPost()
    {
        Functions::checkAdmin();

        $task = new Task();

        $task->name = htmlspecialchars($_POST['name']);
        $task->project_id = htmlspecialchars($_POST['project_id']);
        $task->user_id = htmlspecialchars($_POST['user_id']);

        $task->save();

        $userProject = new UserProject();
        $userProject->user_id = htmlspecialchars($_POST['user_id']);
        $userProject->project_id = htmlspecialchars($_POST['project_id']);

        $userProject->save();

        header("Location: /client/project/task?id=$task->project_id");
    }


    public function taskCommentsGet()
    {
        Functions::checkAdmin();

        $task = Task::getById(htmlspecialchars($_GET["id"]));

        $data['allPosts'] = $task->getPosts();
        $data['task'] = $task;

        Functions::view('task/task',$data);
    }


    public function taskCommentsPost()
    {
        Functions::checkAdmin();

        $post = new Post();

        $post->task_id = htmlspecialchars($_POST['task_id']);
        $post->title = $_SESSION['admin_name'];
        $post->body = htmlspecialchars($_POST['body']);
        date_default_timezone_set("Europe/Belgrade");
        $post->date = date("Y-m-d H:i:s");;
        $post->users_id = $_SESSION['admin_id'];

        $post->save();

        header("Location: /client/project/task/?id=$post->task_id");
    }


    public function delete()
    {
        Functions::checkAdmin();

        $task = Task::getById(htmlspecialchars($_GET["id"]));
        $userProject = new UserProject();

        $userProject->project_id = $task->project_id;
        $userProject->user_id = $task->user_id;

        $task->delete();
        $userProject->delete();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
