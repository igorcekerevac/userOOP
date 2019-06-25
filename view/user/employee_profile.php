<?php require 'view/include/header_admin.php'; ?>

<div id="profile_div">

	<h1>EMPLOYEE</h1><br><br>

	<h3>NAME/ <?php echo $user->name ?></h3>
	<h3>JOB/ <?php echo $user->job ?></h3>
	<h3>EMAIL/ <?php echo $user->email ?></h3><br>

    <h3>ACTIVE TASKS</h3><br>

    <?php

    if (empty($allTasks)) {

        echo "You do not have active tasks!";

    } else {

        foreach ($allTasks as $task) {

            echo '<li><a id="task_names" href="/client/project/task/?id='.$task->task_id.'">
                  <strong id="font">'.$task->name.'</strong></a></li><br>';
        }
    }
    ?>
</div>

</body>
</html>