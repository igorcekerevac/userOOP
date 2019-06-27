<?php

namespace Controller;

use Model\Client;
use Model\Task;
use Model\Project;
use Model\Post;

class TaskController extends Controller
{

    public function addTaskGet()
    {
        $this->checkCredentials('admin_name');

        $project = Project::getById($this->request->get('id'));

        $usersProject = $project->getUsers();

        $data['allUsers'] = $usersProject;
        $data['allTasks'] = $project->getTasks();
        $data['project'] = $project;

        $this->view('task/add_task',$data);
    }


    public function addTaskPost()
    {
        $this->checkCredentials('admin_name');

        $task = new Task();

        $task->name = htmlspecialchars($this->request->post('name'));
        $task->project_id = htmlspecialchars($this->request->post('project_id'));
        $task->user_id = htmlspecialchars($this->request->post('user_id'));

        $task->save();

        $this->redirectToPreviousPage();
    }


    public function taskCommentsGet()
    {
        $this->checkCredentials('admin_name');

        $task = Task::getById(htmlspecialchars($this->request->get('id')));
        $project = Project::getById($task->project_id);

        $data['allPosts'] = $task->getPosts();
        $data['task'] = $task;
        $data['client'] = Client::getById($project->client_id);
        $data['project'] = $project;

        $this->view('task/task',$data);
    }


    public function taskCommentsPost()
    {
        $this->checkCredentials('admin_name');

        $post = new Post();

        $post->task_id = htmlspecialchars($this->request->post('task_id'));
        $post->title = $this->request->session('admin_name');
        $post->body = htmlspecialchars($this->request->post('body'));
        date_default_timezone_set("Europe/Belgrade");
        $post->date = date("Y-m-d H:i:s");;
        $post->users_id = $this->request->session('admin_id');

        $post->save();

        $this->redirectToPreviousPage();
    }


    public function delete()
    {
        $this->checkCredentials('admin_name');

        $task = Task::getById(htmlspecialchars($this->request->get('id')));

        $task->delete();

        $this->redirectToPreviousPage();
    }
}
