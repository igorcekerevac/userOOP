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

	<button id="logout" onclick="location.href = '/employee/logout'">logout</button>
	<h1>User <?php  echo $_SESSION['name'] ?>!</h1><br>
	<button onclick='location.href = "/employee?id=<?php echo $_SESSION['user_id']; ?>"'>back to tasks</button>
	<h3>Task name: <?php  echo $task_name ?></h3>
	<h3>Project name: <?php  echo $project_name ?></h3><br>


	<div id="form">
	<h3>Add new post:</h3><br>
	<form action="/employee/post/submit" method="post">

		Title: <input type="text" name="title" value=""><br><br>
		<textarea name="body" style="height: 150px; width: 195px;"></textarea><br>

		<input type="submit" name="submit" value="submit post">
		<input type="hidden" name="task_id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>

	</form><br>
	</div>
	<div id="posts">
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
	
</body>
</html>