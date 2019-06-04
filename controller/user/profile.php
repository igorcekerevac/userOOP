<?php

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';
	
	$user = new User($db);

	$find_id = htmlspecialchars($_GET["id"]);
	
	$user->getUser($find_id);

	$name = $user->name;
	$age = $user->age;
	$email = $user->email;

	include $_SERVER['DOCUMENT_ROOT'].'/view/profile.php';

?>

