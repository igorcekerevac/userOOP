<?php


namespace lib;


class Request
{
    public $session = [];
    public $get = [];
    public $post = [];


    public function __construct()
    {
        if (isset($_POST)) {
            $this->post = $_POST;
        }
        if (isset($_GET)) {
            $this->get = $_GET;
        }
        if (isset($_SESSION)) {
            $this->session = $_SESSION;
        }
    }

    public function get(string $param): string
    {
        return $this->get[$param];
    }

    public function post(string $param): string
    {
        return $this->post[$param];
    }

    public function session(string $param): string
    {
        return $this->session[$param];
    }

}