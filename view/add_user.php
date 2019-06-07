
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
	<h1>Sign up!</h1>

	<form action="/user/add" method="post">

		<?php if (isset($status)) :?>
			<p><?php echo $status?></p>
		<?php endif; ?>

		<table>

		<tr> <td>Name: </td>
			<td><input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"></td>
		</tr>
		<tr> <td>Age: </td>	
			<td><input type="text" name="age" value="<?php echo Functions::data_typed('age'); ?>"></td>
		<tr> <td>Email: </td>
			<td><input type="text" name="email" value="<?php echo Functions::data_typed('email'); ?>"></td>

		</table><br>

		<input type="submit" name="submit" value="add user">

	</form>

	<button id="login" onclick="location.href = '/employee/login'">emlpoyee login</button><br>

</body>
</html>