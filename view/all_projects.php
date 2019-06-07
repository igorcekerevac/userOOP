<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#task{
			margin-left: 25px;
		}
	</style>
</head>
<body>
	
	<button id = "home" onclick="location.href = '/admin'">home</button>

	<h1>All projects!</h1>

	<?php $id = array(); ?>
	
	<?php foreach ($all_projects as $project) : ?>

		<?php

			if (!in_array($project['project_id'], $id)) 
			{ 
			  	array_push($id, $project['project_id']);
			  	echo '<br><strong>'.$project['project_id'].'. '.$project['client_name'].' - '.$project['project_name'].'</strong><br><br>';
			}
			echo '<li id="task">'.'Task: '.'<a href="/client/project/task/?id='.$project['task_id'].'">'.$project['task_name'].'</a>'.' Employee: '.$project['user_name'].'</li>';
		?>

	<?php endforeach; ?>

</body>
</html>