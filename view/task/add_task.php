<?php require 'view/include/header_admin.php'; ?>

<div id="content">

	<h1>ADD TASK FOR PROJECT/<?php echo ' '. $name ?></h1><br>

	<form action='/client/project/task?id='". <?php echo $project_id; ?>."' method="post">

		<table>
			<tr>
				<td style="padding: 0px;"><h5>task name</h5></td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td style="padding: 0px;"><h5>employee</h5></td>
				<td>
				<?php
					echo "<select name='user_id'>";
						echo "<option>choose employee</option>";
						foreach($all_users as $user){
						echo "<option value='" . $user['user_id'] . "'>". $user['name'] ."/".$user['job']."</option>";
					}

					echo "</select>";

				?></td>
			</tr>	

		</table>
		
		<input type="hidden" name="project_id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/><br>
		<input id="add_btn" style="float: left; " type="submit" name="submit" value="add task">

	</form>


    <input id="add_btn" style="float: left; width: 115px; margin-left: 15px;" type="submit" value="back to client"
           onclick="location.href = '/client/?id=<?php echo $client_id; ?>';"></input><br><br><br>

	<h2>ALL TASKS</h2>

	<?php


		if (!empty($all_tasks)) {
		
			foreach ($all_tasks as $task) {

				echo '<li><a id="task_names" href="/client/project/task/?id='.$task['task_id'].'"><strong id="font">'.$task['name'].'</strong></a></li><br>';
			}
		} else {

		echo "No active tasks!";
		
		}
	?>	
</div>
</body>
</html>