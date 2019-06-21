<?php require 'view/include/header_user.php'; ?>

<div id="task_div">

	<h1 id="header_h1">USER TASKS</h1><br><br>

	<?php

		if (empty($allTasks)) {

			echo "You do not have active tasks!";

		} else {

			foreach ($allTasks as $task) {
				
				echo '<li><a id="task_names" href="/employee/task?id='.$task->task_id.'"><strong id="font">'.$task->name.'</strong></a></li><br>';
			}
		}
	?>
</div>

</body>
</html>