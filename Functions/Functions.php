<?php

namespace Functions;


class Functions
{
	
	public static function email_validation($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}


	public static function data_typed($key)
	{

		if (!empty($_REQUEST[$key])) {
			return htmlspecialchars($_REQUEST[$key]);
		}
		return '';
	}


	public static function check_admin()
	{
		session_start();

		if (!isset($_SESSION['admin_name'])) {
			
			header("Location: /employee/login");
		}
	}


	public static function check_user()
	{
		session_start();

		if (!isset($_SESSION['name'])) {
			
			header("Location: /employee/login");
		}
	}


	public static function populate_users_array_no_admin($all_users)
    {
        $users = array();

        foreach ($all_users as $user) {

            if ($user->name !== 'admin') {

                array_push($users, $user);
            }
        }

        return $users;
    }
}