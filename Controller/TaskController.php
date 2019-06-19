<?php

namespace Controller;

use Model\Client;
use Model\Task;
use Model\Project;
use Model\User;
use Model\Post;
use Functions\Functions;

class TaskController
{

    public function create_task_get()
    {
        Functions::check_admin();

        $project = Project::get_by_id($_GET['id']);

        $users = User::get_all();

        $all_users = Functions::populate_users_array_no_admin($users);

        $all_tasks = $project->get_all_tasks();

        $client_id = Client::get_client_id($project->project_id);


        include $_SERVER['DOCUMENT_ROOT'].'/view/task/add_task.php';
    }


    public function create_task_post()
    {
        Functions::check_admin();

        $task = new Task();

        $task->name = htmlspecialchars($_POST['name']);
        $task->project_id = htmlspecialchars($_POST['project_id']);
        $task->user_id = htmlspecialchars($_POST['user_id']);

        $task->save();
        header("Location: /client/project/task?id=$task->project_id");
    }


    public function view_task_get()
    {
        Functions::check_admin();

        $task = Task::get_by_id(htmlspecialchars($_GET["id"]));

        $all_posts = $task->get_all_posts();

        include $_SERVER['DOCUMENT_ROOT'].'/view/task/task.php';
    }


    public function view_task_post()
    {
        Functions::check_admin();

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


    public function delete_task()
    {
        Functions::check_admin();

        $task = Task::get_by_id(htmlspecialchars($_GET["id"]));

        $task->delete();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
