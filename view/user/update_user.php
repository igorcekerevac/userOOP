<?php require 'view/include/header_user.php'; ?>

	

	<div id="update_form">

		<h1 id="update_h1">UPDATE</h1>

		<form action="" method="post">

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
				<td><input id="add_btn" type="submit" name="submit" value="update"></td>
			</tr>

			</table><br>

		</form>
	</div>

</body>
</html>