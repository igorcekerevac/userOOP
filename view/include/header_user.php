
<!DOCTYPE html>
<html>
<head>
	
	<title>php test site</title>
	<link rel="stylesheet" type="text/css" href="/view/style.css">
	
</head>
<body>

	<div id="nav">

		<a id="user_tasks" class="nav_link" href="/employee?id=<?php echo $_SESSION['user_id']; ?>">user tasks</a>
		<a id="user_update" class="nav_link" href="/user/update/?id=<?php echo $_SESSION['user_id']; ?>">update</a>
		<a id="user_update" class="nav_link" href="/user/profile/?id=<?php echo $_SESSION['user_id']; ?>">profile</a>
		<a id="logout" class="nav_link" href="/employee/logout">LOGOUT</a>
		<h1 id="user_welcome">Employee/ <?php  echo $_SESSION['name']; ?></h1>
		
	</div>