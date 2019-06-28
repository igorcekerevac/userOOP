<?php

namespace Controller;

use lib\Request;

abstract class Controller
{
    protected $request;


    public function __construct()
    {
        $this->request = new Request();
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
        $session_param = $this->request->session($name);

        if (!isset($session_param)) {
            header("Location: /employee/login");
        }
    }


    public function redirectToPreviousPage()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }


    public function redirectToPage(string $path): string
    {
        header("Location: $path");
    }
}