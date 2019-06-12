<?php require 'view/include/header_admin.php'; ?>

	<div id="task_info">
		<h1>TASK NAME/ <?php echo $name ?></h1><br>
	</div>

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

		if(!empty($all_posts)){

			foreach($all_posts as $post){
			    echo '<h5 style="color: orangered">'.$post['title'].'</h5>';
				echo '<div id="comment">';
				echo '<h5>'.$post['date'].'</h5><br>';
				echo $post['body'].'</div><br>';
			}
		}else{
			echo "No comments for this task!";
		}

	?>
	</div>

</body>
</html>