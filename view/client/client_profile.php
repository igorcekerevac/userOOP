<?php require 'view/include/header_admin.php'; ?>

<div id="content">
	<h1>CLIENT/ <?php echo $clientName; ?></h1><br>
	<h2>ACTIVE PROJECTS</h2>

	<?php 
        $flag = 0;
		if (!empty($clientProjects)) {
			foreach($clientProjects as $project){
                if ($project->status === 'active') {
                    echo "<strong id='font'>" . $project->name . "</strong><a style='margin-left: 15px;' id='task_names'
                href='/client/project/task?id=" . $project->project_id . "'>tasks</a><br>";
                    $flag = 1;
                }
			}

		} else {

			echo "No added projects!";
		}
		if ($flag === 0) {
		    echo 'No active projects for this client.';
        }
	?>

    <br><h2>FINISHED PROJECTS</h2>

    <?php

    if (!empty($clientProjects)) {
        $flag = 0;
        foreach($clientProjects as $project){
            if ($project->status === 'finished') {
                echo "<strong id='font'>" . $project->name . "</strong><a style='margin-left: 15px;' id='task_names'
                href='/client/project/?id=" . $project->project_id . "'>info</a><br>";
                $flag = 1;
            }
        }
    }
    if ($flag === 0) {
        echo 'No finished projects for this client.';
    }
    ?>

</div>	
</body>
</html>