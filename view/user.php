
<!DOCTYPE html>
<html>
<head>
	<title>OOP</title>
	<style type="text/css">
		#left{
			margin-right: 10px;
			margin-left: 20px;
		}
		#update{
			margin-right: 10px;
		}
		#font{
			font-size: 20px;
		}
		#page{
			margin-right: 13px;
			text-decoration: none;
		}
		#page:hover{
			color: red;
		}
	</style>

</head>
<body>

	<h1>ALL USERS</h1><br>

	<button onclick="location.href = '/admin'">home</button><br><br>

	<?php

		foreach ($all_users as $user) {

			echo '<strong id="font">'.$user['name'].'</strong>' .

			"<a id='left' href='delete.php?id=".$user['user_id']."'>delete</a>". 
			"<a id='update' href='/user/update/?id=".$user['user_id']."'>update</a>". 

			"<a href='/user/profile/?id=".$user['user_id']."'>profile</a><br>";
		}

	?>	
	<br>


</body>
</html>