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


	public static function allEmployees(array $allUsers): array
    {
        $employees = array();

        foreach ($allUsers as $user) {

            if ($user->name !== 'admin') {

                array_push($employees, $user);
            }
        }
        return $employees;
    }


    public static function availableEmployees(array $allEmployees, array $employeesOnProject): array
    {
        $availableEmployees = array();

        foreach ($allEmployees as $employee) {

            if (!in_array($employee, $employeesOnProject)) {

                array_push($availableEmployees, $employee);
            }
        }
        return $availableEmployees;
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