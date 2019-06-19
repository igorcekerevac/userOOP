<?php

namespace Controller;

use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;

class TaskController
{

    public function addTaskGet()
    {
        Functions::checkAdmin();

        $project = Project::getById($_GET['id']);

        $users = User::getAll();

        $all_users = Functions::populateUsersArray($users);

        $all_tasks = $project->getTasks();

        include $_SERVER['DOCUMENT_ROOT'].'/view/task/add_task.php';
    }


    public function addTaskPost()
    {
        Functions::checkAdmin();

        $task = new Task();

        $task->name = htmlspecialchars($_POST['name']);
        $task->project_id = htmlspecialchars($_POST['project_id']);
        $task->user_id = htmlspecialchars($_POST['user_id']);

        $task->save();
        header("Location: /client/project/task?id=$task->project_id");
    }


    public function taskCommentsGet()
    {
        Functions::checkAdmin();

        $task = Task::getById(htmlspecialchars($_GET["id"]));

        $all_posts = $task->getPosts();

        include $_SERVER['DOCUMENT_ROOT'].'/view/task/task.php';
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

        $task->delete();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
