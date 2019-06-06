<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#logout{
			float: right;
		}
	</style>
</head>
<body>
	<button id="logout" onclick="location.href = '/employee/logout'">logout</button>
	<h1>Welcome <?php  echo $user_name?>!</h1><br>
	<h2>Your tasks:</h2>

	<?php

	if (empty($all_tasks)) {
		echo "You do not have active tasks!";
	}else{

		foreach ($all_tasks as $task) {
			
			echo '<li><a href="/employee/task?id='.$task['task_id'].'"><strong id="font">'.$task['name'].'</strong></a></li><br>';
		}
	}
	?>

</body>
</html>