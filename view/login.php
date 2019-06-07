
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
	<h1>Employee login!</h1>

	<form action="" method="post">

		Email: <input type="text" name="email" value=""><br><br>

		<input type="submit" name="submit" value="login">

	</form>


	<?php if (isset($status)) :?>
			<p><?php echo $status?></p>
	<?php endif; ?>

	<button onclick="location.href = '/'">sign up</button>

</body>
</html>