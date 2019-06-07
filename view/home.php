<?php

	session_start();

	if (!isset($_SESSION['admin_name'])) {
		header("Location: /employee/login");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#login{
			float: right;
		}
		#logout{
			float: right;
		}
	</style>
</head>
<body>
	<button id="logout" onclick="location.href = '/employee/logout'">logout</button>
	<button onclick="location.href = '/users'">users</button>
	<button onclick="location.href = '/clients'">clients</button>
	<button onclick="location.href = '/projects'">all projects</button>
	
</body>
</html>