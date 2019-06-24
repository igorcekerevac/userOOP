<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>CLIENT/ <?php echo $clientName; ?></h1><br>
	<h2>PROJECTS</h2>

	<?php 

		if (!empty($clientProjects)) {

			foreach($clientProjects as $project){

				echo "<strong id='font'>".$project->name ."</strong><a style='margin-left: 15px;' id='task_names'
                href='/client/project/task?id=".$project->project_id."'>tasks</a><br>";
			}

		} else {

			echo "No added projects!";
		}	
	?>

</div>	
</body>
</html>