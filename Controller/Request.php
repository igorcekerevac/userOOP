<?php


namespace Controller;


abstract class Request
{
  #  protected $session;
  #  protected $user;


    public function redirectToPreviousPage()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function redirectToPage(string $path): string
    {
        header("Location: $path");
    }

}