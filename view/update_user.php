
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		p{
			color: red;
			font-style: italic;
		}
	</style>
</head>
<body>
	
	<h1>Update user!</h1>

	<form action="" method="post">

		Name: <input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"><br>
		Age: <input type="text" name="age" value="<?php echo Functions::data_typed('age'); ?>"><br>
		Email: <input type="text" name="email" value="<?php echo Functions::data_typed('email'); ?>"><br>
		<input type="hidden" name="id" value= "<?php echo htmlspecialchars($_GET["id"]); ?>"/>

		<input type="submit" value="update user">

		<?php if (isset($status)) :?>
			<p><?php echo $status?></p>
		<?php endif; ?>

	</form><br>

	<button onclick="location.href = '/users'">back to users</button><br><br>

</body>
</html>