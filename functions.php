<?php

class Functions{
	
	public static function email_validation($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function data_typed($key){

		if (!empty($_REQUEST[$key])) {
			return htmlspecialchars($_REQUEST[$key]);
		}
		return '';
	}
}