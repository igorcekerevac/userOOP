<?php 

	include $_SERVER['DOCUMENT_ROOT'].'/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'].'/db/initial.php';
	include $_SERVER['DOCUMENT_ROOT'].'/model/user.php';

	$delete_id = $_GET["id"];
		
	$user = new User($db);
	$user->delete($delete_id);

	header("Location: users.php");