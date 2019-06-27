<?php require 'view/include/header_admin.php'; ?>

	<div id="task_info">
		<h1>TASK NAME/ <?php echo $task->name ?></h1>
        <h4 style="font-style: italic; margin-top: -10px;">
            CLIENT <?php echo $client->name?> / PROJECT <?php echo $project->name?></h4>
	</div>

        <input id="add_btn" style="float: left; width: 115px; margin-left: 50px;" type="submit" value="go to project"
        onclick="location.href = '/project/?id=<?php echo $project->project_id; ?>';"></input><br><br><br>

	<div id="form">
	<h3>Add new post:</h3><br>
	<form action="/client/project/task/postComment" method="post">

		<h5 style="font-style: italic; color: beige;"><?php echo $_SESSION['admin_name'] ?> commenting... </h5><br>
		<textarea name="body" style="height: 150px; width: 198px;"></textarea><br>

		<input id="sub_post" type="submit" name="submit" value="submit post">
		<input type="hidden" name="task_id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>

	</form><br>
	</div>

	<div id="posts">

		<h3>Comments:</h3><br>
	<?php

		if(!empty($allPosts)){

			foreach($allPosts as $post){
			    echo '<h5 style="color: orangered">'.$post->title.'</h5>';
				echo '<div id="comment">';
				echo '<h5>'.$post->date.'</h5><br>';
				echo $post->body.'</div><br>';
			}
		}else{
			echo "No comments for this task!";
		}

	?>
	</div>

</body>
</html>