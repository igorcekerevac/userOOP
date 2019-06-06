<!DOCTYPE html>
<html>
<head>
	<title>OOP</title>
</head>
<body>
	<h1>Add task for project<?php echo ' '. $name ?>!</h1>

	<form action='/client/project/task?id='". <?php echo $project_id; ?>."' method="post">

		Task name: <input type="text" name="name"><br>
		Employee:
		<?php
			echo "<select name='user_id'>";
				echo "<option>choose employee</option>";
				foreach($all_users as $user){
				echo "<option value='" . $user['user_id'] . "'>". $user['name'] ."</option>";
			}

			echo "</select>";

		?>
		<input type="hidden" name="project_id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>
		<br>
		<input type="submit" name="submit" value="add task">

	</form><br>

	<button onclick="location.href = '/clients'">back to clients</button><br><br>

	<h1>All tasks:</h1>


	<?php

		if(!empty($all_tasks)){
		
			foreach ($all_tasks as $task) {

				echo '<li><a href="/client/project/task/?id='.$task['task_id'].'"><strong id="font">'.$task['name'].'</strong></a></li><br>';
			}
		}else{
		echo "No active tasks!";
		}
	?>	

</body>
</html>