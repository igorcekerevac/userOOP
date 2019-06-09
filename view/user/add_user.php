<?php require 'view/include/header.php'; ?>


<div id="log_header">
	
	<a id="login" href="/employee/login">employee login</a>

</div>

<div id="sign_form">

	<h1 id="sign_h1">SIGN UP</h1>

	<form action="/user/add" method="post">

		<?php 

		if (isset($status)) {

			echo '<p id="status">'.$status.'</p>';
			
		} else {

			echo '<p id="status"> &nbsp </p>';

		} ?>

		<table>

		<tr> 
			<td>name</td>
			<td><input type="text" name="name" value="<?php echo Functions::data_typed('name'); ?>"></td>
		</tr>
		
		<tr> 
			<td>age</td>	
			<td><input type="text" name="age" value="<?php echo Functions::data_typed('age'); ?>"></td>
		</tr>
		
		<tr> 
			<td>email</td>
			<td><input type="text" name="email" value="<?php echo Functions::data_typed('email'); ?>"></td>
		</tr>

		<tr> 
			<td></td>
			<td><input id="add_btn" type="submit" name="submit" value="add user"></td>
		</tr>

		</table><br>

	</form>
</div>

</body>
</html>