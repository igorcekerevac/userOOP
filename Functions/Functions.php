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


	public static function populateUsersArray(array $allUsers): array
    {
        $users = array();

        foreach ($allUsers as $user) {

            if ($user->name !== 'admin') {

                array_push($users, $user);
            }
        }
        return $users;
    }


    public static function populateProjectUsers(array $allUsers, array $usersOnProject): array
    {
        $users = array();

        foreach ($allUsers as $user) {

            if (!in_array($user, $usersOnProject)) {

                array_push($users, $user);
            }
        }
        return $users;
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