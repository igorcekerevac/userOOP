<?php

namespace Controller;

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


        $project_id = $_GET['id'];


        $all = User::get_all('user');

        $all_users = Functions::populate_users_array_no_admin($all);


        $name = Project::get_column_value($project_id, 'name', 'project');

        $all_tasks = Task::get_all_with_specific_id('task', $project_id, 'project');


        $client = Task::get_client_id($project_id);

        $client_id = $client['client_id'];


        include $_SERVER['DOCUMENT_ROOT'].'/view/task/add_task.php';
    }


    public function create_task_post()
    {
        Functions::check_admin();

        $task = new Task();

        $user_id = $_POST['user_id'];
        $task_name = $_POST['name'];
        $project_id = $_POST['project_id'];

        $task->name = $task_name;
        $task->project_id = $project_id;
        $task->user_id = $user_id;

        $task->create_task();
        header("Location: /client/project/task?id=$project_id");
    }


    public function view_task_get()
    {
        Functions::check_admin();

        $task_id = htmlspecialchars($_GET["id"]);

        $task = Task::get($task_id, 'task');

        $name = $task['name'];
        $user_id = $task['user_id'];

        $all_posts = Post::get_all_posts($task_id);

        include $_SERVER['DOCUMENT_ROOT'].'/view/task/task.php';
    }


    public function view_task_post()
    {
        Functions::check_admin();

        $post = new Post();

        $task_id = $_POST['task_id'];
        $body = $_POST['body'];
        $user_id = $_SESSION['admin_id'];
        $date = date("Y-m-d H:i:s");

        $post->task_id = $task_id;
        $post->title = $_SESSION['admin_name'];
        $post->body = $body;
        $post->date = $date;
        $post->users_id = $user_id;

        $post->create_post();

        header("Location: /client/project/task/?id=$task_id");
    }


    public function delete_task()
    {
        Functions::check_admin();

        $task_id = htmlspecialchars($_GET["id"]);

        Task::delete($task_id, 'task');


        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }


}
