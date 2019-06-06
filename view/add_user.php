
<!DOCTYPE html>
<html>
<head>
	<title>OOP</title>
	<style type="text/css">
		p{
			color: red;
			font-style: italic;
		}
		
	</style>
</head>
<body>
	<h1>Add user!</h1>

	<form action="" method="post">


		<?php if (isset($status)) :?>
			<p><?php echo $status?></p>
		<?php endif; ?>

		Name: <input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"><br>
		Age: <input type="text" name="age" value="<?php echo Functions::data_typed('age'); ?>"><br>
		Email: <input type="text" name="email" value="<?php echo Functions::data_typed('email'); ?>"><br>

		<input type="submit" name="submit" value="add user">



	</form>
	<button id="login" onclick="location.href = '/employee/login'">emlpoyee login</button><br>

</body>
</html>