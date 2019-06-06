<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Task <?php echo $name ?>!</h1><br>
	<h1>Employee comments:</h1>

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
	<br><br>
	<button onclick="location.href = '/clients'">back to clients</button><br><br>
</body>
</html>