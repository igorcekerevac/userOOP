<?php


namespace Controller;


abstract class Controller extends Request
{
    protected $get = [];
    protected $post = [];
    protected $request;

    public function __construct()
    {
        if (isset($_POST)) {
            $this->post = $_POST;
        }
        if (isset($_GET)) {
            $this->get = $_GET;
        }
   #     $this->request =  new Request();
    }

    public function get(string $param): string
    {
        return $this->get[$param];
    }

    public function post(string $param): string
    {
        return $this->post[$param];
    }


    public function view(string $path, array $data = null)
    {
        if ($data) {
            extract($data);
        }
        include $_SERVER['DOCUMENT_ROOT'].'/view/'.$path.'.php';
    }

    public function checkCredentials(string $name)
    {
        session_start();

        if (!isset($_SESSION[$name])) {
            header("Location: /employee/login");
        }
    }
}