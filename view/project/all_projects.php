<?php require 'view/include/header_admin.php'; ?>

<div id="content">

	<h1>ALL PROJECTS</h1><br>

	<?php $id = array(); ?>
	
	<?php foreach ($all_projects as $project) : ?>

		<?php

			if (!in_array($project['project_id'], $id)) 
			{ 
			  	array_push($id, $project['project_id']);
			  	echo '<h3>'.$project['project_id'].'. '.$project['client_name'].' / '.$project['project_name'].'</h3>';
			}

			echo '<h5><li id="task">'.'Task: '.'<a id="task_names" href="/client/project/task/?id='.$project['task_id'].'">'.$project['task_name'].'</a>'.' &nbsp&nbsp/&nbsp Employee: '.$project['user_name'].'</li></h5>';
		?>

	<?php endforeach; ?>

</div>

</body>
</html>