<?php

namespace Functions;


class Functions
{
	
	public static function emailValidation($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}


	public static function dataTyped($key)
	{

		if (!empty($_REQUEST[$key])) {
			return htmlspecialchars($_REQUEST[$key]);
		}
		return '';
	}


	public static function checkAdmin()
	{
		session_start();

		if (!isset($_SESSION['admin_name'])) {
			
			header("Location: /employee/login");
		}
	}


	public static function checkUser()
	{
		session_start();

		if (!isset($_SESSION['name'])) {
			
			header("Location: /employee/login");
		}
	}


	public static function populateUsersArray($allUsers)
    {
        $users = array();

        foreach ($allUsers as $user) {

            if ($user->name !== 'admin') {

                array_push($users, $user);
            }
        }
        return $users;
    }

    public static function view($path, $data = null)
    {
        if ($data) {
            extract($data);
        }
        include $_SERVER['DOCUMENT_ROOT'].'/view/'.$path.'.php';
    }

    public static function numberOfPagesPagination(int $resultsPerPage, int $numberOfResults): int
    {
        return $numberOfPages = ceil($numberOfResults / $resultsPerPage);
    }

    public static function thisPageFirstResult (int $page, int $resultsPerPage): int
    {
        return $thisPageFirstResult = ($page-1)*$resultsPerPage;
    }
}