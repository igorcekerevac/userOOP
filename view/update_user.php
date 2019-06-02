
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	
	<h1>Update user!</h1>

	<form action="" method="post">

		Name: <input type="text" name="name"><br>
		Age: <input type="text" name="age"><br>
		Email: <input type="text" name="email"><br>
		<input type="hidden" name="id" value= "<?php echo $_GET["id"] ?>"/>

		<input type="submit" value="update user">
	</form><br>

	<button onclick="location.href = 'users.php'">back to users</button><br><br>

</body>
</html>