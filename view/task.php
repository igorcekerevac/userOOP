<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#logout{
			float: right;
		}
		#form{
			width: 300px;
			float: left;
		}
		#posts{
			float: left;
		}
		
	</style>
</head>
<body>
	<h1>Task <?php echo $name ?>!</h1><br>

	<div id="form">
	<h3>Add new post:</h3><br>
	<form action="/employee/post/sub" method="post">

		Title: <input type="text" name="title" value=""><br><br>
		<textarea name="body" style="height: 150px; width: 195px;"></textarea><br>

		<input type="submit" name="submit" value="submit post">
		<input type="hidden" name="task_id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>

	</form><br>
	</div>
	<div id="posts" style="width: 1000px;">
		<h3>Comments:</h3><br>
	<?php

		if(!empty($all_posts)){

			foreach($all_posts as $post){
				echo $post['date'].'<br>';
				echo $post['body'].'<br><br>';
			}
		}else{
			echo "No comments for this task!";
		}

	?>
	</div>

	<button onclick="location.href = '/clients'">back to clients</button>
	<button onclick="location.href = '/projects'">all projects</button><br>
	<button onclick="location.href = '/admin'">home</button><br><br>


</body>
</html>