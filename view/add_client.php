
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
	<h1>Add client!</h1>

	<form action="" method="post">

		Name: <input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"><br>

		<input type="submit" name="submit" value="add client">

		<?php if (isset($status)) :?>
			<p><?php echo $status?></p>
		<?php endif; ?>

	</form><br>

	<button onclick="location.href = '/clients'">back to clients</button><br><br>

</body>
</html>